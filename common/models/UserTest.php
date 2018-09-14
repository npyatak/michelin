<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_test".
 *
 * @property int $id
 * @property int $user_id Пользователь
 * @property int $week_id Неделя
 * @property string $answers Ответы
 * @property int $score Баллы
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 * @property Week $week
 */
class UserTest extends \yii\db\ActiveRecord
{

    public $answersArr = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_test';
    }

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'week_id'], 'required'],
            [['user_id', 'week_id', 'score', 'is_finished', 'right_answers', 'created_at', 'updated_at'], 'integer'],
            [['answers'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['week_id'], 'exist', 'skipOnError' => true, 'targetClass' => Week::className(), 'targetAttribute' => ['week_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'week_id' => 'Неделя',
            'answers' => 'Ответы',
            'answersArr' => 'Ответы',
            'score' => 'Баллы',
            'is_finished' => 'Закончен',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'right_answers' => 'Правильные ответы',
            'time' => 'Время',
        ];
    }

    public function beforeSave($insert) {
        $this->answers = json_encode($this->answersArr);

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        if(Question::find()->where(['status' => Question::STATUS_ACTIVE, 'week_id' => $this->week_id])->count() == count($this->answersArr) && !$this->is_finished) {
            $questions = Question::find()->where(['status' => Question::STATUS_ACTIVE, 'week_id' => $this->week_id])->indexBy('id')->all();
            $score = 0;
            $right_answers = 0;

            foreach ($this->answersArr as $q_id => $a_id) {
                $is_right = Answer::find()->select('is_right')->where(['id' => $a_id])->asArray()->one()['is_right'];
                if($is_right && isset($questions[$q_id])) {
                    $right_answers++;
                    $score += $questions[$q_id]->right_answer_points;
                }
            }

            $this->is_finished = 1;
            $this->right_answers = $right_answers;
            $this->score = $score;

            $this->save(false, ['is_finished', 'right_answers', 'score']);

            $user = User::findOne(Yii::$app->user->id);
            $userScores = UserTest::find()->select('score')->where(['user_id' => $user->id])->column();
            $user->score = max($userScores);
            $user->save(false, ['score']);
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    public function afterFind() {
        $this->answersArr = json_decode($this->answers, true);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWeek()
    {
        return $this->hasOne(Week::className(), ['id' => 'week_id']);
    }

    public function getQuestionsText() {
        $lastDigit =  substr($this->right_answers, -1);
        if($lastDigit == 1 && $this->right_answers != 11) {
            return 'вопрос';
        } elseif($lastDigit == 2 && $this->right_answers != 12) {
            return 'вопроса';
        } else {
            return 'вопросов';
        }
    }

    public function getTime() {
        if($this->is_finished) {
            return $this->updated_at - $this->created_at;
        }
    }
}
