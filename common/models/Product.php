<?php

namespace common\models;

use common\models\behaviors\UploadsBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\behaviors\I18nBehavior;
use yii\db\Query;
use yii\helpers\Url;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $type
 * @property integer $make
 * @property integer $model
 * @property integer $price
 * @property integer $year
 * @property integer $views
 * @property integer $priority
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $exchange
 * @property integer $auction
 * @property integer $currency
 *
 * @property ProductType $type0
 * @property ProductI18n[] $productI18ns
 */
class Product extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_UNPUBLISHED = 2;
    const STATUS_TO_BE_VERIFIED = 3;
    const SCENARIO_COMPLAIN = 'complain';
    const SCENARIO_DEFAULT ='default';
    const SCENARIO_SELLERCONTACTS = 'sellerContacts';
    private static $maxPrice;
    private static $minPrice;
    private static $yearsList;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region', 'phone_provider'], 'integer', 'on'=>self::SCENARIO_SELLERCONTACTS],
            [['region', 'last_name', 'first_name', 'phone', 'phone_provider',], 'safe', 'on'=>self::SCENARIO_SELLERCONTACTS],
            [['type','make', 'model', 'year', 'price','priority'], 'required', 'on'=>self::SCENARIO_DEFAULT],
            [['first_name','phone_provider', 'phone', 'region'], 'required', 'on'=>self::SCENARIO_SELLERCONTACTS],
            [['model'], 'string', 'max' => 2048],
            [['year'], 'integer', 'min' => 1900, 'max' => date('Y')],
            ['priority', 'safe', 'when' => function ($model) {
                return Yii::$app->user->can('changeProductPriority');
            }],
            [['status', 'type', 'make', 'price', 'views', 'created_at', 'updated_at', 'created_by', 'updated_by', 'exchange', 'currency', 'auction'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_SELLERCONTACTS => [
                'first_name',
                'phone_provider',
                'phone',
                'region',
            ],
            self::SCENARIO_DEFAULT => [
                'username',
                'email',
                'first_name',
                'phone_provider',
                'phone',
                'type',
                'make',
                'model',
                'price',
                'year',
                'priority'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'type' => Yii::t('app', 'Type'),
            'make' => Yii::t('app', 'Make'),
            'model' => Yii::t('app', 'Model'),
            'price' => Yii::t('app', 'Price'),
            'year' => Yii::t('app', 'Year'),
            'views' => Yii::t('app', 'Views'),
            'priority' => Yii::t('app', 'Priority'),
            'created_at' => Yii::t('app', 'Published At'),
            'created_at' => Yii::t('app', 'Date of publication'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'exchange' => Yii::t('app', 'Exchange'),
            'auction' => Yii::t('app', 'Auction'),
            'currency' => Yii::t('app', 'Currency'),
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'region' =>'Регион',
            'phone' => 'Телефон',
            'phone_provider' => 'Оператор',
            'phone_2' => 'Доп. телефон',
            'phone_provider_2' => 'Оператор',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => UploadsBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => I18nBehavior::className(),
                'i18nModel' => '\common\models\ProductI18n',
            ],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $result = parent::afterSave($insert, $changedAttributes);
        return $result;
    }

    /**
     * If metadata is empty generate it
     */
    public function updateMetaData()
    {
        $metaDataModels = MetaData::getModels($this);
        foreach ($metaDataModels as $metaDataModel) {
            if ($metaDataModel->type == MetaData::TYPE_TITLE && empty($metaDataModel->i18n()->value)) {
                $specs = ProductSpecification::find()
                    ->innerJoin('specification', 'specification.id=product_specification.specification_id')
                    ->where('product_id=:product_id AND specification.in_meta=1', [':product_id' => $this->id])
                    ->all();

                $specsStr = '';

                foreach ($specs as $spec) {

                    $specsStr .= ', ' . $spec->value;
                    $unit = trim($spec->getSpecification()->one()->i18n()->unit);
                    if ($unit !== '') {
                        $specsStr .= ' ' . $spec->getSpecification()->one()->i18n()->unit;
                    }
                }

                $metaDataModel->i18n()->value = $this->getFullTitle() . $specsStr . ', купить в кредит в Минске.';
                $metaDataModel->save();
            }
            if ($metaDataModel->type == MetaData::TYPE_DESCRIPTION && empty($metaDataModel->i18n()->value)) {
                $metaDataModel->i18n()->value = $this->i18n()->seller_comments;
                $metaDataModel->save();
            }
        }
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
    public function getType0()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMake0()
    {
        return $this->hasOne(ProductMake::className(), ['id' => 'make']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductI18ns()
    {
        return $this->hasMany(ProductI18n::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecifications($priority = null)
    {
        $query = ProductSpecification::find()->where('product_id=' . $this->id);
        $query->joinWith('specification');
        if ($priority !== null) {
            $query->andWhere('specification.priority=' . $priority);
        }
        $query->orderBy('specification.lft');
        return $query->all();
    }

    /**
     * @param bool $skipIfSet
     * @return $this the model instance itself.
     */
    public function loadDefaultValues($skipIfSet = true)
    {
        if ($this->type === null || !$skipIfSet) {
            $type = ProductType::find()->where('depth>0')->limit(1)->one();
            if (!empty($type)) {
                $this->type = $type->id;
            }
        }
        return parent::loadDefaultValues($skipIfSet);
    }

    public function getUrl()
    {
        return Url::to(['catalog/show', 'id' => $this->id]);
    }

    /**
     * @return float
     */
    public function getUsdPrice()
    {
        $appData = AppData::getData();
        if (!is_numeric($appData['usdRate'])) {
            $rate = 1;
        } else {
            $rate = $appData['usdRate'];
        }
        if ($this->currency === 0) { // price in usd
            return intval($this->price);
        } else {
            return intval($this->price / $rate);
        }
    }

    /**
     * @return float
     */
    public function getByrPrice()
    {
        $appData = AppData::getData();
        if (!is_numeric($appData['usdRate'])) {
            $rate = 1;
        } else {
            $rate = $appData['usdRate'];
        }
        if ($this->currency === 0) { // price in usd
            return intval($this->price * $rate);
        } else {
            return intval($this->price);
        }
    }

    /**
     * @return string;
     */
    public function getFullTitle()
    {
        return $this->getMake0()->one()->name . ' ' . $this->model . ' (' . $this->year . ')';
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PUBLISHED => Yii::t('app', 'Published'),
            self::STATUS_UNPUBLISHED => Yii::t('app', 'Unpublished'),
            self::STATUS_TO_BE_VERIFIED => Yii::t('app', 'Подлежит проверке'),
        ];
    }

    /**
     * @return array
     */
    public static function getPriorities()
    {
        return [
            0 => Yii::t('app', 'Normal priority'),
            1 => Yii::t('app', 'High priority'),
        ];
    }

    /**
     * @return array
     */
    public static function getCurrencies()
    {
        return [
            0 => Yii::t('app', 'USD'),
            1 => Yii::t('app', 'BYN'),
        ];
    }

    /**
     * Get max price of all published products.
     * @return bool|int|string
     */
    public static function getMaxPrice()
    {
        if (self::$maxPrice === null) {
            self::$maxPrice = (new Query())
                ->select('max(price)')
                ->from('product')
                ->where('status=' . self::STATUS_PUBLISHED)
                ->limit(1)
                ->scalar();
            if (self::$maxPrice === null) {
                self::$maxPrice = 0;
            }
        }
        return self::$maxPrice;
    }

    /**
     * Get min price of all published products.
     * @return bool|int|string
     */
    public static function getMinPrice()
    {
        if (self::$minPrice === null) {
            self::$minPrice = (new Query())->select('min(price)')->from('product')->limit(1)->scalar();
            if (self::$minPrice === null) {
                self::$minPrice = 0;
            }
        }
        return self::$minPrice;
    }

    /**
     * @return array
     */
    public static function getYearsList()
    {
        if (self::$yearsList === null) {
            self::$yearsList = [];
            for ($i = 1970; $i <= date('Y'); $i++) {
                self::$yearsList[$i] = $i;
            }
            self::$yearsList = array_reverse(self::$yearsList, true);
        }
        return self::$yearsList;
    }

    /**
     * Increase `views` value
     */
    public function increaseViews()
    {
        if (!$this->isNewRecord) {
            if (!is_numeric($this->views)) {
                $views = 0;
            } else {
                $views = $this->views;
            }
            $views++;
            Yii::$app->db->createCommand()
                ->update($this->tableName(), ['views' => $views], 'id=:id', [':id' => $this->id])
                ->execute();
        }
    }
}
