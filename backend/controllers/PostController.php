<?php

namespace backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\grid\EditableColumnAction;

use common\models\Post;
use common\models\User;
use common\models\ContestStage;
use common\models\search\PostSearch;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends CController
{ 
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editable' => [                                       // identifier for your editable action
                'class' => EditableColumnAction::className(),     // action class name
                'modelClass' => Post::className(),                // the update model class
            ]
        ]);
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Post;
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->post('hasEditable')) {
            $post = Yii::$app->request->post();
            $model = $this->findModel($post['editableKey']);
            $model[$post['editableAttribute']] = $post['Post'][$post['editableIndex']][$post['editableAttribute']];
            $out = json_encode(['output'=>'', 'message'=>'']);
            if ($model->save(false, [$post['editableAttribute']])) {
                $output = '';
                $out = json_encode(['output'=>$output, 'message'=>'']); 
            }
            echo $out;
            return;
        }


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->save(false, ['type', 'status']);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionStatus($id, $status) {
        $model = $this->findModel($id);
        $model->status = $status;
        $model->save(false, ['status']);

        //return $model->save(false);
        
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionExcelExport()
    {
        $contestStages = ContestStage::find()->all();
        //этап, место, ник, id в конкурсе, дата рождения, e-mail, соц. сеть, телефон, ip. 
        $postArr = [];
        $query = Post::find()
            //->select(['user_id', 'sum(score) as sumScore', 'name', 'birthdate', 'email', 'soc', 'phone', 'ip'])
            ->where(['post.status' => Post::STATUS_ACTIVE, 'user.status' => User::STATUS_ACTIVE])
            ->joinWith('user')
            ->asArray();
        
        $sheets = [];
        foreach ($contestStages as $stage) {
            if($stage->status == ContestStage::STATUS_FINISHED) {
                $q = clone($query);
                $postArr[$stage->id] = $q->andWhere(['contest_stage_id' => $stage->id])->all();

                foreach ($postArr[$stage->id] as $p => $w) {
                    $sheets['Этап '.$stage->number]['data'][] = [
                        $w['user']['id'],
                        $w['user']['soc'],
                        $w['user']['sid'],
                        $w['user']['name'],
                        $w['user']['surname'],
                        $w['user']['ip'],
                        $w['user']['browser'],
                        $w['user']['email'],

                        $w['id'],
                        $w['score'],
                        $w['media'],
                        $w['city'],
                        $w['text'],
                    ];

                    $sheets['Этап '.$stage->number]['titles'] = [
                        User::attributeLabels()['id'],
                        User::attributeLabels()['soc'],
                        User::attributeLabels()['sid'],
                        User::attributeLabels()['name'],
                        User::attributeLabels()['surname'],
                        User::attributeLabels()['ip'],
                        User::attributeLabels()['browser'],
                        User::attributeLabels()['email'],

                        Post::attributeLabels()['id'],
                        Post::attributeLabels()['score'],
                        Post::attributeLabels()['media'],
                        Post::attributeLabels()['city'],
                        Post::attributeLabels()['text'],
                    ]; 
                }
            }
        }

        $file = \Yii::createObject([
            'class' => 'codemix\excelexport\ExcelFile',
            'sheets' => $sheets
        ]);

        $file->createSheets();

        foreach ($file->getWorkbook()->getAllSheets() as $key => $sheet) {
            foreach(range('A','K') as $columnID) {
                $sheet->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }
        }

        $file->send('posts.xlsx');
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
