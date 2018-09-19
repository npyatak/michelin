<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use frontend\models\ContactForm;

use common\models\City;
use common\models\User;
use common\models\Week;
use common\models\UserTest;
use common\models\Question;
use common\models\Answer;

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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
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
    public function actionIndex()
    {
        return $this->render('index');
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
            $cities = City::find()->all();

            $citiesArr = [];
            foreach ($cities as $c) {
                $citiesArr[] = [
                    'id' => $c->id,
                    'name' => $c->name,
                    'type' => $c->type,
                ];
            }

            shuffle($citiesArr);

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

    public function actionLogin2($id = 1) {
        $user = User::findOne($id);

        Yii::$app->getUser()->login($user);

        return $this->redirect('/');
    }
}
