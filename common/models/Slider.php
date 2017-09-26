<?php

namespace common\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\behaviors\UploadsBehavior;
use common\models\behaviors\I18nBehavior;

/**
 * This is the model class for table "slider".
 *
 * @property integer $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $link
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $text_position
 *
 * @property SliderI18n[] $sliderI18ns
 */
class Slider extends \yii\db\ActiveRecord
{

    const STATUS_PUBLISHED = 1;
    const STATUS_UNPUBLISHED = 2;

    const POSITION_TOP_LEFT = 0;
    const POSITION_TOP_RIGHT = 1;
    const POSITION_BOTTOM_LEFT = 2;
    const POSITION_BOTTOM_RIGHT = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slider';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link'], 'required'],
            [['lft', 'rgt', 'depth', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'text_position'], 'integer'],
            [['link'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lft' => Yii::t('app', 'Lft'),
            'rgt' => Yii::t('app', 'Rgt'),
            'depth' => Yii::t('app', 'Depth'),
            'link' => Yii::t('app', 'Link'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'text_position' => Yii::t('app', 'Text Position'),
        ];
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
            ],
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
                'i18nModel' => '\common\models\SliderI18n',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSliderI18ns()
    {
        return $this->hasMany(SliderI18n::className(), ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return SliderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SliderQuery(get_called_class());
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
     * @return array
     */
    public static function getTextPositions()
    {
        return [
            self::POSITION_TOP_LEFT => Yii::t('app', 'Top Left'),
            self::POSITION_TOP_RIGHT=> Yii::t('app', 'Top Right'),
            self::POSITION_BOTTOM_LEFT=> Yii::t('app', 'Bottom Left'),
            self::POSITION_BOTTOM_RIGHT=> Yii::t('app', 'Bottom Right'),
        ];
    }

    /**
     * Get root node or create if not exists
     * @return Slider
     */
    public static function getRoot()
    {
        $root = self::find()->root()->one();
        if ($root === null) {
            $root = new self(['link'=>'/']);
            $root->id = 0;
            $root->makeRoot();
        }
        return $root;
    }

    /**
     * @param int $width
     * @param int $height
     * @return mixed
     */
    public function getTitleImageUrl($width = 1920, $height = 800)
    {
        $result = Yii::$app->uploads->getDummyImageUrl();
        $uploads = $this->getUploads();
        if (!empty($uploads)) {
            $result = Yii::$app->uploads->resize($uploads[0]->hash, $width, $height);
        }
        return $result;
    }
}
