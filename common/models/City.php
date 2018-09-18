<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string $name Название
 * @property string $source Источник
 * @property string $descr Название
 * @property int $is_emphasized Выделить
 * @property string $char1 Хар-ка 1
 * @property string $char2 Хар-ка 2
 * @property string $char3 Хар-ка 3
 * @property string $coord Координаты (разделитель запятая)
 * @property int $type Тип
 * @property string $video_yt_id YT id видео
 */
class City extends \yii\db\ActiveRecord
{
    const TYPE_TEXT = 0;
    const TYPE_VIDEO = 1;

    public $peopleArr;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'source'], 'required'],
            [['descr'], 'safe'],
            [['is_emphasized', 'type'], 'integer'],
            [['name', 'source'], 'string', 'max' => 521],
            [['char1', 'char2', 'char3', 'coord', 'video_yt_id', 'people'], 'string', 'max' => 255],
            ['peopleArr', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'source' => 'Источник',
            'descr' => 'Название',
            'is_emphasized' => 'Выделить',
            'char1' => 'Хар-ка 1',
            'char2' => 'Хар-ка 2',
            'char3' => 'Хар-ка 3',
            'coord' => 'Координаты (разделитель запятая)',
            'type' => 'Тип',
            'video_yt_id' => 'YT id видео',
            'peopleArr' => 'Корреспонденты',
        ];
    }

    public function beforeSave($insert) {
        $this->people = serialize($this->peopleArr);
        //print_r($this->people);exit;

        return parent::beforeSave($insert);
    }


    public function afterFind() {
        $this->peopleArr = unserialize($this->people);
    }

    public function getTypeArray() {
        return [
            self::TYPE_TEXT => 'Текст',
            self::TYPE_VIDEO => 'Видео',
        ];
    }

    public function getCorrespondents() {
        $res = [];
        if(!empty($this->peopleArr)) {
            foreach ($this->peopleArr as $p) {
                $res[$p] = $this->peopleData[$p];
            }
        }
        
        return $res;
    }

    public function getPeopleList() {
        return [
            1 => 'savin',
            2 => 'chesnokova',
            3 => 'chebatkov',
            4 => 'kovinov',
        ];
    }

    public function getPeopleData() {
        return [
            1 => ['class' => 'savin', 'name' => 'Евгений Савин'],
            2 => ['class' => 'chesnokova', 'name' => 'Ирина Чеснокова'],
            3 => ['class' => 'chebatkov', 'name' => 'Жека Чебатков'],
            4 => ['class' => 'kovinov', 'name' => 'Дмитрий Ковинов'],
        ];
    }
}
