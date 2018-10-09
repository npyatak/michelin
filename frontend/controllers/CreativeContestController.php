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
class CreativeContestController extends Controller
{
    public $currentContestStage;

    public function init() {
        $this->currentContestStage = ContestStage::getCurrent();
    }

    public function actionIndex()
    {
        $contestStage = $this->currentContestStage;
        if($contestStage == null) {
            return $this->redirect('index');
        }

        $searchModel = new PostSearch();
        $params = Yii::$app->request->queryParams;
        $params['Post']['contest_stage_id'] = $contestStage->id;
        $params['Post']['status'] = Post::STATUS_ACTIVE;

        $dataProvider = $searchModel->search($params);
        $dataProvider->sort = [
            'defaultOrder' => ['score' => SORT_DESC],
            //'defaultOrder' => ['created_at'=>SORT_DESC],
            'attributes' => ['created_at', 'score'],
        ];
        $dataProvider->pagination = [
            'pageSize' => 100,
        ];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
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
            
            if($model->save()) {
                $path = $model->srcPath;
                $model->mediaFile = UploadedFile::getInstance($model, 'mediaFile');

                if($model->mediaFile) {
                    if(!file_exists($path)) {
                        mkdir($path, 0775, true);
                    }

                    $model->media = $model->mediaFile->name;
                    $model->type = in_array($model->mediaFile->extension, ['jpg', 'png', 'jpeg']) ? Post::TYPE_IMAGE : Post::TYPE_VIDEO;
                    $model->save(false, ['media', 'type']);

                    $model->mediaFile->saveAs($path.$model->media);
                }

                return $this->redirect(['index']);
            }
        }

        return $this->render('participate', [
            'model' => $model,
        ]);
    }
}
