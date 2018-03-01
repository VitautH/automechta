<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\behaviors\I18nBehavior;
use common\models\behaviors\UploadsBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $alias
 * @property integer $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $views
 * @property integer $in_aside
 *
 * @property PageI18n[] $pageI18ns
 */
class Page extends \yii\db\ActiveRecord
{

    const TYPE_STATIC = 1;
    const TYPE_NEWS = 2;

    const STATUS_PUBLISHED = 1;
    const STATUS_UNPUBLISHED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'in_aside'], 'integer'],
            [['alias'], 'string', 'max' => 256],
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => UploadsBehavior::className(),
            ],
            [
                'class' => I18nBehavior::className(),
                'i18nModel' => '\common\models\PageI18n',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Alias'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'in_aside' => Yii::t('app', 'In aside menu'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageI18ns()
    {
        return $this->hasMany(PageI18n::className(), ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PUBLISHED => Yii::t('app', 'Published'),
            self::STATUS_UNPUBLISHED=> Yii::t('app', 'Unpublished'),
        ];
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        if ($this->type === self::TYPE_NEWS) {
            return Url::to(['news/show', 'id' => $this->id]);
        } elseif($this->type === self::TYPE_STATIC) {
            return Url::to($this->alias);
        }
    }

    /**
     * Increase `views` value
     */
    public function increaseViews()
    {
        $this->views = ($this->views + 1);
        $this->save();
    }
     public function getTitleImage ($width=null, $height=null){
         if ($this->main_image === null){
           return  $image = $this->getTitleImageUrl($width, $height);
         }
         else {
             $image = $this->main_image;
             if($image !== null) {
                 return $image;
             }
             else {
                 return null;
             }
         }
     }
}
