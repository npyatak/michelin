<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post_action}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $post_id
 * @property integer $type
 * @property integer $score
 * @property integer $created_at
 *
 * @property Post $post
 * @property User $user
 */
class PostAction extends \yii\db\ActiveRecord
{
    const TYPE_LIKE = 1;
    const TYPE_SHARE_VK = 2;
    const TYPE_SHARE_FB = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_action}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'post_id', 'type'], 'required'],
            [['user_id', 'post_id', 'type', 'score', 'created_at'], 'integer'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            
            ['type', 'in',  'range' => [self::TYPE_LIKE, self::TYPE_SHARE_VK, self::TYPE_SHARE_FB]],
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'updatedAtAttribute' => false
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'post_id' => 'Пост',
            'type' => 'Тип',
            'score' => 'Баллы',
            'created_at' => 'Дата/Время',
        ];
    }

    public function afterSave($insert, $changedAttributes) {
        $this->post->score = PostAction::find()->where(['post_id'=>$this->post->id])->sum('score');
        $this->post->save(false, ['score']);
        // $userWeekScore = new UserWeekScore;
        // $userWeekScore->score = PostAction::find()->select('SUM(score)')->where(['post_id'=>$this->post_id])->column();
        // $userWeekScore->save(false, ['score']);

        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getTypeArray() {
        return [
            self::TYPE_LIKE => 'Лайк',
            self::TYPE_SHARE_VK => 'Поделиться ВК',
            self::TYPE_SHARE_FB => 'Поделиться FB',
        ];
    }

    public function getTypeLabel() {
        return self::getTypeArray()[$this->type];
    }

    public function getTypeScores() {
        return [
            self::TYPE_LIKE => 1,
            self::TYPE_SHARE_VK => 2,
            self::TYPE_SHARE_FB => 2,
        ];
    }

    public function getScoreInitial() {
        return self::getTypeScores()[$this->type];
    }

    public static function create($post_id, $type) {
        $model = new self;
        $model->user_id = Yii::$app->user->id;
        $model->post_id = $post_id;
        $model->type = $type;
        $model->score = $model->scoreInitial;

        $model->save();
    }

    public static function userCanDo($lastActionTime) {
        return strtotime('today midnight') > $lastActionTime;
    }
}
