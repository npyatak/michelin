<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%week}}".
 *
 * @property integer $id
 * @property integer $number
 * @property string $name
 * @property string $image
 * @property string $description_1
 * @property string $description_2
 * @property integer $status
 *
 * @property Questions[] $posts
 * @property UserWeekScore[] $userWeekScores
 */
class Week extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_WAITING = 1;
    const STATUS_ACTIVE = 5;
    const STATUS_FINISHED = 9;

    public $dateStartFormatted;
    public $dateEndFormatted;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%week}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'name', 'dateStartFormatted', 'dateEndFormatted'], 'required'],
            [['number', 'winner_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['image'], 'string', 'max' => 255],
            [['number'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Порядковый номер',
            'name' => 'Имя',
            'image' => 'Изображение',
            'description' => 'Описание',
            'status' => 'Статус',
            'date_start' => 'Дата начала этапа',
            'date_end' => 'Дата окончания этапа',
            'dateStartFormatted' => 'Дата начала этапа',
            'dateEndFormatted' => 'Дата окончания этапа',
            'winner_id' => 'Победитель',
        ];
    }

    public function beforeSave($insert) {
        $this->date_start = strtotime($this->dateStartFormatted);
        $this->date_end = strtotime($this->dateEndFormatted);

        return parent::beforeSave($insert);
    }

    public function afterFind() {
        $this->dateStartFormatted = date('d.m.Y H:i', $this->date_start);
        $this->dateEndFormatted = date('d.m.Y H:i', $this->date_end);

        return parent::afterFind();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['week_id' => 'id']);
    }

    public function getStatus() {
        if($this->date_start < time() && $this->date_end > time()) {
            return self::STATUS_ACTIVE;
        } elseif(time() > $this->date_end) {
            return self::STATUS_FINISHED;
        } elseif(time() < $this->date_start) {
            return self::STATUS_WAITING;
        } else {
            return self::STATUS_INACTIVE;            
        }
    }

    public static function getStatusArray() {
        return [
            self::STATUS_INACTIVE => 'Неактивна',
            self::STATUS_WAITING => 'В ожидании',
            self::STATUS_ACTIVE => 'Активна',
            self::STATUS_FINISHED => 'Закончена',
        ];
    }

    public function getStatusLabel() {
        return self::getStatusArray()[$this->status];
    }

    public function isCurrent() {
        return $this->date_start < time() && $this->date_end > time();
    }

    public static function getCurrent() {
        return self::find()->where(['<', 'date_start', time()])->andWhere(['>', 'date_end', time()])->one();
    }

    public function isFinished() {
        return $this->date_end < time();
    }

    public function getStartDate() {
        $dateTimeStart = new \DateTime;
        $dateTimeStart->setTimestamp($this->date_start);

        return $dateTimeStart->format('j').' '.$this->getMonth($dateTimeStart->format('n'), true);
    }

    public function getEndDate() {
        $dateTimeEnd = new \DateTime;
        $dateTimeEnd->setTimestamp($this->date_end);

        return $dateTimeEnd->format('j').' '.$this->getMonth($dateTimeEnd->format('n'), true);
    }


    public function getMonth($monthId, $secondForm=false) {
        return $secondForm ? $this->monthsArray[$monthId][1] : $this->monthsArray[$monthId][0];
    }

    public function getMonthsArray() {
        return [
            1 => ['январь', 'января'],
            2 => ['февраль', 'февраля'],
            3 => ['март', 'марта'],
            4 => ['апрель', 'апреля'],
            5 => ['май', 'мая'],
            6 => ['июнь', 'июня'],
            7 => ['июль', 'июля'],
            8 => ['август', 'августа'],
            9 => ['сентябрь', 'сентября'],
            10 => ['октябрь', 'октября'],
            11 => ['ноябрь', 'ноября'],
            12 => ['декабрь', 'декабря'],
        ];
    }

    public function getWinner()
    {
        return $this->hasOne(User::className(), ['id' => 'winner_id']);
    }
}
