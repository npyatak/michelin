<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

class Post extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = 5;

    const IMAGE_SQUARE = 1;
    const IMAGE_HORIZONTAL = 2;
    const IMAGE_VERTICAL = 3;

    const TYPE_IMAGE = 1;
    const TYPE_VIDEO = 2;

    public $mediaFile;
    public $link;

    public $x;
    public $y;
    public $w;
    public $h;
    public $scale;
    public $angle;

    public $_lastUserActions;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'score', 'status', 'created_at', 'updated_at', 'type'], 'integer'],
            [['media', 'yt_id'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['text', 'string', 'max' => 2000],

            [['x', 'y', 'w', 'h', 'scale', 'angle'], 'safe'],
            [['mediaFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, png, mp4, mov, m4v, mpeg, mpg', 'maxSize' => 1024 * 1024 * 30, 'tooBig' => 'Максимальный размер 30Мб', 'checkExtensionByMimeType'=>false],
            ['text', 'required', 'when' => function($model) {
                return ($model->mediaFile == null && $model->yt_id == null);
            }, 'message' => 'Необходимо заполнить выбрать изображение/видео или заполнить текст'],
            ['link', 'checkLink'],
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
            ],
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
            'contest_stage_id' => 'Этап',
            'mediaFile' => 'Медиа файл',
            'score' => 'Баллы',
            'status' => 'Статус',
            'is_from_ig' => 'Из инстаграма',
            'media' => 'Медиа',
            'created_at' => 'Дата/Время создания',
            'updated_at' => 'Время последнего изменения',
            'type' => 'Тип',
            'text' => 'Текст',
        ];
    }

    public function checkLink($attribute, $model) {
        $key = $this->parseUrl();

        if(!$key) {
            $this->addError($attribute, 'Указана не верная ссылка');
        } elseif(self::find()->where(['yt_id' => $key])->count() > 0) {
            $this->addError($attribute, 'Это видео уже было загружено');
        }
    }

    public function afterDelete() {
        $path = $this->srcPath;
        if(file_exists($path.$this->media) && is_file($path.$this->media)) {
            unlink($path.$this->media);
        }
        return parent::afterDelete();
    }

    public function beforeSave($insert) {
        if($this->link) {
            $this->yt_id = $this->parseUrl();
        } 

        return parent::beforeSave($insert);
    }

    public function parseUrl() {
        $key = null;
        $urlParts = parse_url(trim($this->link));
        
        if(in_array($urlParts['host'], ['youtube.com', 'www.youtube.com'])) {
            parse_str($urlParts['query'], $queryParts);

            if(isset($queryParts['v'])) {
                $key = $queryParts['v'];
            } elseif (strripos($urlParts['path'], 'embed')) {
                $exp = explode('embed/', $urlParts['path']);
                if(isset($exp[1])) {
                    $key = $exp[1];
                }
            }
        } elseif(in_array($urlParts['host'], ['youtu.be', 'www.youtu.be'])) {
            $key = str_replace("/", "", $urlParts['path']);
        }

        return $key;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getContestStage()
    {
        return $this->hasOne(ContestStage::className(), ['id' => 'contest_stage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostActions()
    {
        return $this->hasMany(PostAction::className(), ['post_id' => 'id']);
    }

    public function getUrl() {
        return Url::toRoute(['creative-contest/index', 'id'=>$this->id]);
    }

    public function getSrcPath() {
        return __DIR__ . '/../../frontend/web/uploads/post/';
    }

    public function getSrcUrl() {
        if($this->type == self::TYPE_VIDEO) {
            return 'https://img.youtube.com/vi/'.$this->yt_id.'/hqdefault.jpg';
        }
        return Yii::$app->urlManagerFrontEnd->createAbsoluteUrl('/uploads/post/'.$this->media);
    }

    // public static function getImageUrl($user_id, $media) {
    //     return Yii::$app->urlManagerFrontEnd->createAbsoluteUrl('/uploads/post/'.$user_id.'/'.$media);
    // }

    public static function getStatusArray() {
        return [
            self::STATUS_NEW => 'Новый',
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_BANNED => 'Забанен',
        ];
    }

    public function getStatusLabel() {
        return self::getStatusArray()[$this->status];
    }

    public static function getTypeArray() {
        return [
            self::TYPE_IMAGE => 'Изображение',
            self::TYPE_VIDEO => 'Видео',
        ];
    }

    public function getTypeLabel() {
        $arr = self::getTypeArray();
        return $this->type && !empty($arr) ? $arr[$this->type] : null;
    }

    public function getLastUserActions() {
        if($this->_lastUserActions === null) {
            $this->_lastUserActions = PostAction::find()
                ->select(['MAX(id) as last_user_action_id', 'MAX(created_at) as last_user_action_time', 'type'])
                ->where(['user_id'=>Yii::$app->user->id, 'post_id'=>$this->id])
                ->groupBy('type, post_id')
                ->orderBy('id DESC, type')
                ->indexBy('type')
                ->asArray()
                ->all();
        }
        return $this->_lastUserActions;
    }

    public function userCan($type) {
        if(isset($this->lastUserActions[$type]) && !PostAction::userCanDo($this->lastUserActions[$type]['last_user_action_time'])) {
            return false;
        }

        return true;
    }
}
