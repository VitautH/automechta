<?php

namespace common\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\behaviors\I18nBehavior;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $route
 * @property integer $status
 * @property string $permission
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Menu extends \yii\db\ActiveRecord
{

    const STATUS_PUBLISHED = 1;
    const STATUS_UNPUBLISHED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['route'], 'required'],
            [['lft', 'rgt', 'depth', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['route', 'permission'], 'string', 'max' => 256]
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
            'route' => Yii::t('app', 'Route'),
            'status' => Yii::t('app', 'Status'),
            'permission' => Yii::t('app', 'Permission'),
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
                'class' => I18nBehavior::className(),
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
     * @inheritdoc
     * @return MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }

    /**
     * Get root node or create if not exists
     * @return Menu
     */
    public static function getRoot()
    {
        $root = self::find()->root()->one();
        if ($root === null) {
            $root = new self(['route' => '/']);
            $root->id = 0;
            $root->makeRoot();
        }
        return $root;
    }

    /**
     * Get current node model or empty model if current was not found
     * @return Menu
     */
    public static function getCurrent()
    {
        $url = Yii::$app->request->getUrl();
        $path = Yii::$app->request->getPathInfo();

        $model = self::find()->where('route=:route', [':route' => $url])->andWhere('depth>0')->one();

        if ($model === null) {
            $model = self::find()->where('route=:route', [':route' => '/' . $path])->andWhere('depth>0')->one();
        }
        if ($model === null) {
            $model = self::find()->where(['like', 'route', '/' . $path])->andWhere('depth>0')->one();
        }
        if ($model === null) {
            $model = self::find()->where(['like', 'route', $path])->andWhere('depth>0')->one();
        }
        if ($model === null) {
            $controller = Yii::$app->controller->id;
            $model = self::find()->where(['like', 'route', $controller])->andWhere('depth>0')->one();
        }
        if ($model === null) {
            $model = new self();
        }

        return $model;
    }
}
