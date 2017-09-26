<?php

namespace common\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\behaviors\I18nBehavior;
use common\models\behaviors\UploadsBehavior;

/**
 * This is the model class for table "teaser".
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
 *
 * @property TeaserI18n[] $teaserI18ns
 */
class Teaser extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_UNPUBLISHED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teaser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lft', 'rgt', 'depth', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
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
                'i18nModel' => '\common\models\TeaserI18n',
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
    public function getTeaserI18ns()
    {
        return $this->hasMany(TeaserI18n::className(), ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return TeaserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TeaserQuery(get_called_class());
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
}
