<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\UploadedFile;
use frontend\models\ContactForm;

use common\models\City;
use common\models\User;
use common\models\Week;
use common\models\UserTest;
use common\models\Question;
use common\models\Answer;
use common\models\Post;
use common\models\search\PostSearch;
use common\models\ContestStage;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public $currentWeek;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout'],
                'rules' => [
                    [
                        'actions' => ['login', 'index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function init() {
        $this->currentWeek = Week::getCurrent();
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($cityId = null)
    {
        return $this->render('index', [
            'cityId' => $cityId,
        ]);
    }

    public function actionLogin() {
        $serviceName = Yii::$app->getRequest()->getQueryParam('service');
        $ref = Yii::$app->getRequest()->getQueryParam('ref');
        
        if (isset($serviceName)) {
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);

            if($ref !== '' && $ref != '/login') {
                $eauth->setRedirectUrl(Url::toRoute($ref));
            }
            $eauth->setCancelUrl(Url::toRoute('site/login'));

            try {
                if ($eauth->authenticate()) {
                    $user = User::findByService($serviceName, $eauth->id);
                    if(!$user) {
                        $user = new User;
                        $user->soc = $serviceName;
                        $user->sid = $eauth->id;
                        $user->name = $eauth->first_name;
                        $user->surname = $eauth->last_name;
                        if(isset($eauth->photo_url)) $user->image = $eauth->photo_url;
                        
                        $user->save();
                    } elseif($user->status === User::STATUS_BANNED) {
                        Yii::$app->getSession()->setFlash('error', 'Вы не можете войти. Ваш аккаунт заблокирован');
                        
                        $eauth->redirect($eauth->getCancelUrl());
                    } elseif(!$user->name) {
                        $user->name = $eauth->first_name;
                        $user->surname = $eauth->last_name;
                        if(isset($eauth->photo_url)) $user->image = $eauth->photo_url;

                        $user->save();
                    }

                    $user->ip = $_SERVER['REMOTE_ADDR'];
                    $user->browser = $_SERVER['HTTP_USER_AGENT'];
                    $user->save(false);

                    Yii::$app->user->login($user);
                    // special redirect with closing popup window
                    $eauth->redirect();
                } else {
                    // close popup window and redirect to cancelUrl
                    $eauth->cancel();
                    $eauth->redirect($eauth->getCancelUrl());
                }
            } catch (\nodge\eauth\ErrorException $e) {
                Yii::$app->getSession()->setFlash('error', 'EAuthException: '.$e->getMessage());

                $eauth->cancel();
                $eauth->redirect($eauth->getCancelUrl());
            }
        }

        return $this->render('login');
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionContest2()
    {
        return $this->render('contest2');
    }


    public function actionContest()
    {
        if(Yii::$app->user->isGuest) {
            return $this->render('contest');
        }

        $week = $this->currentWeek;

        if($week !== null) {
            $questionsCount = Question::find()->where(['status' => Question::STATUS_ACTIVE, 'week_id' => $week->id])->count();
        } else {
            return $this->redirect('index');
        }

        $userTest = UserTest::find()->where(['week_id' => $week->id, 'user_id' => Yii::$app->user->identity->id])->one();
        if($userTest && $userTest->is_finished) {
            return $this->redirect(['site/contest-result']);
        }

        $questionOffset = 0;
        if($userTest !== null && !empty($userTest->answersArr)) {
            $questionOffset = count($userTest->answersArr);
        }

        $question = Question::find()->where(['status' => Question::STATUS_ACTIVE, 'week_id' => $week->id])->offset($questionOffset)->one();

        return $this->render('contest', [
            'week' => $week,
            'question' => $question,
            'userTest' => $userTest,
        ]);
    }

    public function actionContestAjax($question = false, $answer = false) {
        if(!Yii::$app->user->isGuest) {
            $week = $this->currentWeek;
            if($week === null) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }

            $userTest = UserTest::find()->where(['week_id' => $week->id, 'user_id' => Yii::$app->user->identity->id])->one();
            
            if(Yii::$app->request->isAjax && $question && $answer && ($userTest === null || !$userTest->is_finished)) { 
                if($userTest === null) {
                    $userTest = new UserTest;
                    $userTest->week_id = $week->id;
                    $userTest->user_id = Yii::$app->user->identity->id;
                }

                $userTest->answersArr[$question] = $answer;
                $userTest->save();

                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                $questionsCount = Question::find()->where(['status' => Question::STATUS_ACTIVE, 'week_id' => $week->id])->count();
                if($questionsCount == count($userTest->answersArr)) {
                    return ['status' => 'redirect'];
                }

                $question = Question::find()->where(['status' => Question::STATUS_ACTIVE, 'week_id' => $week->id])->offset(count($userTest->answersArr))->one();

                return $this->renderAjax('_question', ['question' => $question]);
            }
        }
    }

    public function actionLeaders()
    {
        $leaders = UserTest::find()->where(['is_finished' => 1])->orderBy('score DESC, time DESC')->joinWith('user')->all();

        return $this->render('leaders', [
            'leaders' => $leaders,
        ]);
    }

    public function actionWinners()
    {
        $weekWinners = Week::find()->where(['not', ['winner_id' => null]])->joinWith('winner')->all();

        return $this->render('winners', [
            'weekWinners' => $weekWinners,
        ]);
    }

    public function actionMap()
    {
        $cities = City::find()/*->where(['type' => City::TYPE_VIDEO])*/->where(['not', ['coord' => '']])->all();

        return $this->render('map', [
            'cities' => $cities,
        ]);
    }

    public function actionContestResult()
    {
        $week = $this->currentWeek;
        if(Yii::$app->user->isGuest || $week === null) {
            //throw new NotFoundHttpException('The requested page does not exist.');
            return $this->redirect('index');
        }
            
        $userTest = UserTest::find()->where(['week_id' => $week->id, 'user_id' => Yii::$app->user->id])->one();
        if($userTest === null) {
            //throw new NotFoundHttpException('The requested page does not exist.');
            return $this->redirect('index');
        }

        return $this->render('contest-result', [
            'userTest' => $userTest,
        ]);
    }

    public function actionVideo()
    {
        return $this->render('video');
    }

    public function actionCityList()
    {
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $cities = City::find()->orderBy('name')->all();

            $citiesArr = [];
            foreach ($cities as $c) {
                $citiesArr[] = [
                    'id' => $c->id,
                    'name' => $c->name,
                    'type' => $c->type,
                ];
            }

            //shuffle($citiesArr);

            return $citiesArr;
        }
    }

    public function actionCityData($id)
    {
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $city = City::findOne($id);
            if($city === null) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
            
            return  [
                'name' => $city->name,
                'descr' => $city->descr,
                'coord' => $city->coord,
                'type' => $city->type,
                'score1' => $city->char1,
                'score2' => $city->char2,
                'score3' => $city->char3,
                'yt_id' => $city->video_yt_id,
                'people' => $city->correspondents,
            ];
        }
    }   

    public function actionRules() 
    {
        $file = 'rules_michelin.pdf';
        $completePath = __DIR__.'/../web/pdf/'.$file;
        if(!is_file($completePath)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return Yii::$app->response->sendFile($completePath, $file, ['inline'=>true, 'Content-type' => 'application/pdf', 'Content-Disposition' => 'attachment']);
    }

    public function actionLogin2($id = 1) {
        $user = User::findOne($id);

        Yii::$app->getUser()->login($user);

        return $this->redirect('/');
    }

   /* public function actionDraw() {
        $arr = [
            ['tire' => '00', 'marker' => 1, 'css' => 'left: 16.5%; top: 32%'],
            ['tire' => '00', 'marker' => 2, 'css' => 'left: 27.5%; top: 40%'],
            ['tire' => '00', 'marker' => 3, 'css' => 'left: 64.5%; top: 25%'],
            ['tire' => '00', 'marker' => 4, 'css' => 'left: 87%; top: 47%'],
            ['tire' => '00', 'marker' => 5, 'css' => 'left: 29.4%; top: 14%'],
            ['tire' => '00', 'marker' => 6, 'css' => 'left: 72.7%; top: 21%'],
            ['tire' => '00', 'marker' => 7, 'css' => 'left: 42.3%; top: 7%'],
            ['tire' => '01', 'marker' => 1, 'css' => 'left: 14.3%; top: 41%'],
            ['tire' => '01', 'marker' => 2, 'css' => 'left: 26.2%; top: 50%'],
            ['tire' => '01', 'marker' => 3, 'css' => 'left: 65.5%; top: 33%'],
            ['tire' => '01', 'marker' => 5, 'css' => 'left: 28.2%; top: 18%'],
            ['tire' => '01', 'marker' => 6, 'css' => 'left: 74.2%; top: 27%'],
            ['tire' => '01', 'marker' => 7, 'css' => 'left: 41.8%; top: 9%'],
            ['tire' => '01', 'marker' => 8, 'css' => 'left: 67.4%; top: 11%'],
            ['tire' => '02', 'marker' => 1, 'css' => 'left: 12%; top: 50%'],
            ['tire' => '02', 'marker' => 3, 'css' => 'left: 66.6%; top: 41%'],
            ['tire' => '02', 'marker' => 5, 'css' => 'left: 26.8%; top: 22%'],
            ['tire' => '02', 'marker' => 6, 'css' => 'left: 75.7%; top: 34%'],
            ['tire' => '02', 'marker' => 7, 'css' => 'left: 41.3%; top: 12%'],
            ['tire' => '02', 'marker' => 8, 'css' => 'left: 68.5%; top: 16%'],
            ['tire' => '02', 'marker' => 9, 'css' => 'left: 54%; top: 7%'],
            ['tire' => '03', 'marker' => 3, 'css' => 'left: 68%; top: 52%'],
            ['tire' => '03', 'marker' => 5, 'css' => 'left: 25.5%; top: 29%'],
            ['tire' => '03', 'marker' => 6, 'css' => 'left: 77.7%; top: 45%'],
            ['tire' => '03', 'marker' => 7, 'css' => 'left: 40.8%; top: 16%'],
            ['tire' => '03', 'marker' => 8, 'css' => 'left: 69.5%; top: 22%'],
            ['tire' => '03', 'marker' => 9, 'css' => 'left: 54.5%; top: 9%'],
            ['tire' => '03', 'marker' => 10, 'css' => 'left: 32.4%; top: 14%'],
            ['tire' => '04', 'marker' => 5, 'css' => 'left: 23.5%; top: 38%'],
            ['tire' => '04', 'marker' => 7, 'css' => 'left: 40.3%; top: 22%'],
            ['tire' => '04', 'marker' => 8, 'css' => 'left: 71%; top: 29%'],
            ['tire' => '04', 'marker' => 9, 'css' => 'left: 54.6%; top: 13%'],
            ['tire' => '04', 'marker' => 10, 'css' => 'left: 31.3%; top: 18%'],
            ['tire' => '05', 'marker' => 5, 'css' => 'left: 21.8%; top: 49%'],
            ['tire' => '05', 'marker' => 7, 'css' => 'left: 39.6%; top: 31%'],
            ['tire' => '05', 'marker' => 8, 'css' => 'left: 72.5%; top: 38%'],
            ['tire' => '05', 'marker' => 9, 'css' => 'left: 55%; top: 19%'],
            ['tire' => '05', 'marker' => 10, 'css' => 'left: 30%; top: 24.5%'],
            ['tire' => '05', 'marker' => 11, 'css' => 'left: 74.4%; top: 13%'],
            ['tire' => '06', 'marker' => 7, 'css' => 'left: 38.7%; top: 41%'],
            ['tire' => '06', 'marker' => 8, 'css' => 'left: 74.1%; top: 51%'],
            ['tire' => '06', 'marker' => 9, 'css' => 'left: 55.3%; top: 26%'],
            ['tire' => '06', 'marker' => 10, 'css' => 'left: 28.6%; top: 32%'],
            ['tire' => '06', 'marker' => 11, 'css' => 'left: 75.8%; top: 17%'],
            ['tire' => '06', 'marker' => 12, 'css' => 'left: 37.4%; top: 12%'],
            ['tire' => '07', 'marker' => 9, 'css' => 'left: 55.5%; top: 36%'],
            ['tire' => '07', 'marker' => 10, 'css' => 'left: 27.1%; top: 43%'],
            ['tire' => '07', 'marker' => 11, 'css' => 'left: 77.2%; top: 22%'],
            ['tire' => '07', 'marker' => 12, 'css' => 'left: 36.6%; top: 15%'],
            ['tire' => '08', 'marker' => 9, 'css' => 'left: 56%; top: 47%'],
            ['tire' => '08', 'marker' => 11, 'css' => 'left: 78.9%; top: 28%'],
            ['tire' => '08', 'marker' => 12, 'css' => 'left: 35.6%; top: 20%'],
            ['tire' => '09', 'marker' => 11, 'css' => 'left: 80.9%; top: 36%'],
            ['tire' => '09', 'marker' => 12, 'css' => 'left: 34.9%; top: 27%'],
            ['tire' => '09', 'marker' => 13, 'css' => 'left: 54.3%; top: 9%'],
            ['tire' => '10', 'marker' => 11, 'css' => 'left: 83.1%; top: 46%'],
            ['tire' => '10', 'marker' => 12, 'css' => 'left: 33.8%; top: 38%'],
            ['tire' => '10', 'marker' => 13, 'css' => 'left: 54.5%; top: 12%'],
            ['tire' => '10', 'marker' => 14, 'css' => 'left: 36.8%; top: 14%'],
            ['tire' => '11', 'marker' => 12, 'css' => 'left: 32.5%; top: 49%'],
            ['tire' => '11', 'marker' => 13, 'css' => 'left: 54.8%; top: 17%'],
            ['tire' => '11', 'marker' => 14, 'css' => 'left: 35.8%; top: 19%'],
            ['tire' => '12', 'marker' => 13, 'css' => 'left: 55.9%; top: 42%'],
            ['tire' => '12', 'marker' => 14, 'css' => 'left: 36.1%; top: 17%'],
            ['tire' => '12', 'marker' => 15, 'css' => 'left: 32.8%; top: 47%'],
        ];

        $arr2 = [
            ['tire' => '00', 'css' => 'background-position: 0 0'],
            ['tire' => '01', 'css' => 'background-position: 0 5.263158%'],
            ['tire' => '02', 'css' => 'background-position: 0 10.526316%'],
            ['tire' => '03', 'css' => 'background-position: 0 15.789474%'],
            ['tire' => '04', 'css' => 'background-position: 0 21.052632%'],
            ['tire' => '05', 'css' => 'background-position: 0 26.315789%'],
            ['tire' => '06', 'css' => 'background-position: 0 31.578947%'],
            ['tire' => '07', 'css' => 'background-position: 0 36.842105%'],
            ['tire' => '08', 'css' => 'background-position: 0 42.105263%'],
            ['tire' => '09', 'css' => 'background-position: 0 47.368421%'],
            ['tire' => '10', 'css' => 'background-position: 0 52.631579%'],
            ['tire' => '11', 'css' => 'background-position: 0 57.894737%'],
            ['tire' => '12', 'css' => 'background-position: 0 68.421053%'],
        ];

        // foreach ($arr as $v) {
        //     for ($i=0; $i < 7; $i++) { 
        //         $tire = (int)$v['tire'] + 13 * $i;
        //         $marker = $v['marker'] + 15 * $i;
        //         echo '
        //         #tire.frame-00'.$tire.' .marker'.$marker;
        //         if($i != 6) {
        //             echo ', ';
        //         }
        //     }
        //     echo '</br>';
        //     echo ' {
        //             display: block;
        //             '.$v['css'].'
        //         }';
        //     echo '</br>';
        // }

        foreach ($arr2 as $v) {
            for ($i=0; $i < 7; $i++) { 
                $tire = (int)$v['tire'] + 13 * $i;
                echo '
                #tire.frame-00'.$tire;
                if($i != 6) {
                    echo ', ';
                }
            }
            echo '</br>';
            echo ' {
                    '.$v['css'].'
                }';
            echo '</br>';
        }
    }*/
}
