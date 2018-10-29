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
use common\models\PostAction;
use common\models\search\PostSearch;
use common\models\ContestStage;

class ContestController extends Controller
{
    public $currentContestStage;

    public function init() {
        $this->currentContestStage = ContestStage::getCurrent();
    }

    public function actionIndex($id = null)
    {
        $pageSize = 8;
        $contestStage = $this->currentContestStage;
        if($contestStage == null) {
            return $this->redirect('index');
        }

        $searchModel = new PostSearch();
        $params = Yii::$app->request->queryParams;
        $params['PostSearch']['contest_stage_id'] = $contestStage->id;

        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere(['post.status' => Post::STATUS_ACTIVE])->joinWith('user');
        $dataProvider->sort = [
            'defaultOrder' => ['score' => SORT_DESC],
            'attributes' => ['created_at', 'score'],
        ];
        $dataProvider->pagination = [
            'pageSize' => $pageSize,
        ];

        if (Yii::$app->request->isAjax && isset($_GET['page'])) {
            $dataProvider->pagination = [
                'page' => $_GET['page'],
                'pageSize' => $pageSize,
            ];
            return $this->renderAjax('_posts', [
                'dataProvider' => $dataProvider,
            ]);
        }

        $stagesFinished = ContestStage::find()->where(['>', 'date_end', time()])->indexBy('id')->all();
        $oldPosts = [];
        $oldPostsAll = Post::find()->where(['in', 'contest_stage_id', array_keys($stagesFinished)])->andWhere(['post.status' => Post::STATUS_ACTIVE])->all();
        foreach ($oldPostsAll as $p) {
            $oldPosts[$stagesFinished[$p->contest_stage_id]->name][] = $p;
        }

        $model = null;
        if($id) {
            $model = Post::findOne($id);
        }

        $newPost = null;
        if(Yii::$app->session->getFlash('success')) {
            $newPost = Post::findOne((int)Yii::$app->session->getFlash('success'));
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'newPost' => $newPost,
            'pageSize' => $pageSize,
            'oldPosts' => $oldPosts,
        ]);
    }

    public function actionParticipate()
    {
        if(Yii::$app->user->isGuest) {
            return $this->render('login');
        }

        $contestStage = $this->currentContestStage;
        if($contestStage == null) {
            return $this->redirect('index');
        }

        $model = new Post;

        $post = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->contest_stage_id = $contestStage->id;
            $model->status = Post::STATUS_ACTIVE;
            
            if($model->save()) {
                $path = $model->srcPath;
                $model->mediaFile = UploadedFile::getInstance($model, 'mediaFile');

                $model->type = Post::TYPE_STORY;

                if($model->mediaFile) {
                    if(!file_exists($path)) {
                        mkdir($path, 0775, true);
                    }

                    $model->media = $model->mediaFile->name;

                    $model->mediaFile->saveAs($path.$model->media);

                    if(in_array($model->mediaFile->extension, ['jpg', 'png', 'jpeg'])) {
                        $model->type = Post::TYPE_IMAGE;
                        \yii\imagine\Image::thumbnail($path.$model->media, 354, 200)->save($path.$model->getThumb($model->media));
                    }
                }

                if($model->yt_id) {
                    $model->type = Post::TYPE_VIDEO;
                }

                $model->save(false, ['media', 'type']);

                Yii::$app->session->setFlash('success', $model->id);
                return $this->redirect(['index', 'id' => $model->id]);
            }
        }

        return $this->render('participate', [
            'model' => $model,
        ]);
    }

    public function actionPostData($id)
    {
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Post::find()->where(['post.id' => $id])->joinWith('user')->one();
            if($post === null) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
            
            return  [
                'score' => $post->score,
                'fullName' => $post->user->fullName,
                'id' => $post->id,
                'yt_id' => $post->yt_id,
                'text' => $post->text,
                'url' => Url::to($post->url, true),
                'srcUrl' => $post->getSrcUrl(true),
                'type' => $post->type,
            ];
        }
    } 

    public function actionUserAction($id, $type=null) {        
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            switch ($type) {
                case 'vk':
                    $type = PostAction::TYPE_SHARE_VK;
                    break;
                case 'fb':
                    $type = PostAction::TYPE_SHARE_FB;
                    break;                
                default:
                    $type = PostAction::TYPE_LIKE;
                    break;
            }
            $post = Post::findOne($id);
            if($post !== null && $post->userCan($type)) {
                PostAction::create($id, $type);

                $newScore = Post::find()->select('score')->where(['id' => $id])->column();
                return ['status' => 'success', 'score' => $newScore];
            } else {
                return ['status' => 'error'];
            }
        }
    } 
}
