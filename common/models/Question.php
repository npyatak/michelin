<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property int $id
 * @property string $title Вопрос
 * @property string $image Изображение
 * @property string $comment Комментарий
 * @property int $right_answer_points Баллы за правильный ответ
 *
 * @property Answer[] $answers
 */
class Question extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public $answersArray;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['comment'], 'string'],
            [['right_answer_points'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
            [['status'], 'integer'],
            ['answersArray', function($attribute, $params) {
                foreach ($this->answersArray as $item) {
                    $item->validate();
                    if($item->hasErrors()) {
                        $this->addError($attribute, 'Необходимо заполнить варианты ответов');
                    }
                }
            }],
        ];
    }

    public function afterSave($insert, $changedAttributes) {
        $answerIds = [];
        $oldIds = Answer::find()->select('id')->where(['question_id' => $this->id])->column();
        foreach ($this->answersArray as $answer) {
            if($answer->id) {
                $answerIds[] = $answer->id;
            }
            $answer->question_id = $this->id;
            $answer->save();
        }

        foreach (array_diff($oldIds, $answerIds) as $idToDel) {
            Answer::findOne($idToDel)->delete();
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    public function loadAnswers($newModels) {
        foreach ($newModels as $model) {
            if(isset($model['id']) && $model['id']) {
                $answer = Answer::findOne($model['id']);
            } else {
                $answer = new Answer;
            }
            $answer->load($model);
            $answer->attributes = $model;
            $this->answersArray[] = $answer;
        }

        return $this->answersArray;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Вопрос',
            'image' => 'Изображение',
            'comment' => 'Комментарий',
            'right_answer_points' => 'Баллы за правильный ответ',
            'status' => 'Статус',
            'week_id' => 'Неделя',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }

    public function getStatusArray() {
        return [
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_INACTIVE => 'Не активен',
        ];
    }
}
