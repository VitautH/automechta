<?php

namespace common\models;

use common\models\behaviors\UploadsBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\behaviors\I18nBehavior;
use yii\db\Query;
use yii\helpers\Url;
use yii\base\Event;
use common\models\AppData;
use common\models\ProductType;

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
    const HIGHT_PRIORITY = 1;
    const LOW_PRIORITY = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_UNPUBLISHED = 2;
    const STATUS_TO_BE_VERIFIED = 3;
    const STATUS_BEFORE_CREATE_ADS = 0;
    const SCENARIO_COMPLAIN = 'complain';
    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_SELLERCONTACTS = 'sellerContacts';
    const SCENARIO_CREATEADS = 'createAds';
    const SCENARIO_BEFORE_CREATEADS = 'beforeCreateAds';
    const SCENARIO_STEP_1 = 'step-1';
    const SCENARIO_STEP_2 = 'step-2';
    const SCENARIO_STEP_3 = 'step-3';
    const TABLE_NAME = 'product';
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
            [['region', 'city_id', 'phone_provider', 'phone_provider_2', 'phone_provider_3'], 'integer', 'on' => self::SCENARIO_CREATEADS],
            [['first_name', 'phone', 'video', 'phone_2', 'phone_3'], 'safe', 'on' => self::SCENARIO_CREATEADS],
            [['type', 'make', 'model', 'year', 'price', 'priority'], 'required', 'on' => self::SCENARIO_DEFAULT],
            [['exchange', 'currency', 'auction'], 'integer', 'on' => self::SCENARIO_DEFAULT],
            [['first_name', 'phone_provider', 'phone', 'region', 'city_id'], 'required', 'on' => self::SCENARIO_CREATEADS],
            [['model'], 'string', 'max' => 2048],
            [['year'], 'integer', 'min' => 1900, 'max' => date('Y')],
            ['priority', 'safe', 'when' => function ($model) {
                return Yii::$app->user->can('changeProductPriority');
            }],
            [['video'], 'safe'],
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
                'phone_provider_2',
                'phone_2',
                'phone_provider_3',
                'phone_3',
                'region',
            ],
            self::SCENARIO_STEP_1 => [
                'make',
                'model',
                'price',
                'year',
                'priority',
                'currency',
                'exchange',
                'auction',
                'seller_comments',
            ],
            self::SCENARIO_STEP_2 => [
                'video',
            ],
            self::SCENARIO_STEP_3 => [
                'first_name',
                'phone_provider',
                'phone',
                'phone_provider_2',
                'phone_2',
                'phone_provider_3',
                'phone_3',
                'region',
                'city_id',
            ],
            self::SCENARIO_CREATEADS => [
                'first_name',
                'phone_provider',
                'phone',
                'phone_provider_2',
                'phone_2',
                'phone_provider_3',
                'phone_3',
                'region',
                'city_id',
                'email',
                'video',
                'first_name',
                'type',
                'video',
                'make',
                'model',
                'price',
                'year',
                'priority',
                'exchange',
                'auction',
            ],
            self::SCENARIO_DEFAULT => [
                'username',
                'email',
                'first_name',
                'phone_provider',
                'phone',
                'city_id',
                'region',
                'video',
                'phone_2',
                'phone_provider_2',
                'phone_provider_3',
                'phone_3',
                'type',
                'make',
                'model',
                'price',
                'year',
                'priority',
                'exchange',
                'auction',
            ],
            self::SCENARIO_BEFORE_CREATEADS => [
                'type',
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
            'video' => 'Видео',
            'last_name' => 'Фамилия',
            'region' => 'Регион',
            'city_id' => 'Город',
            'phone' => 'Телефон',
            'phone_provider' => 'Оператор',
            'phone_2' => 'Доп. телефон',
            'phone_provider_2' => 'Оператор',
            'phone_3' => 'Доп. телефон',
            'phone_provider_3' => 'Оператор',
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

    public function beforeSave($insert)
    {

        Yii::$app->trigger(ProductEvent::EVENT_UPDATE_PRODUCT, new Event(['sender' => new ProductEvent($this->id)]));

        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        Yii::$app->trigger(ProductEvent::EVENT_UPDATE_PRODUCT, new Event(['sender' => new ProductEvent($this->id)]));

        return parent::beforeDelete();
    }

    public function update($runValidation = true, $attributeNames = null)
    {
        Yii::$app->trigger(ProductEvent::EVENT_UPDATE_PRODUCT, new Event(['sender' => new ProductEvent($this->id)]));

        return parent::update($runValidation, $attributeNames);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $result = parent::afterSave($insert, $changedAttributes);
        return $result;
    }

    /**
     * Generate MetaData
     */
    public function saveProductMetaData()
    {
        $metaTitleModel = new MetaData();

        $metaTitleModel->linked_table = static::TABLE_NAME;
        $metaTitleModel->linked_id = $this->id;
        $metaTitleModel->type = MetaData::TYPE_TITLE;
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

        $metaTitleModel->i18n()->value = $this->getFullTitle() . $specsStr . ', купить в кредит в Минске.';
        $metaTitleModel->save();
        unset($metaTitleModel);

        $metaDescriptionModel = new MetaData();

        $metaDescriptionModel->linked_table = static::TABLE_NAME;
        $metaDescriptionModel->linked_id = $this->id;
        $metaDescriptionModel->type = MetaData::TYPE_DESCRIPTION;

        switch ($this->type) {

            case ProductType::CARS:
                $productType = 'автомобиль';
                break;
            case ProductType::MOTO:
                $productType = 'мотоцикл';
                break;
            case ProductType::SCOOTER:
                $productType = 'скутер';
                break;
            case ProductType::ATV:
                $productType = 'квадроцикл';
                break;
        }

        $description = 'Купить ' . $productType . ' ' . $this->getFullTitle() . ' ' . $specsStr . ' .Цена ' . $this->price . ' в кредит в Минске. Частное объявление о продаже квадроцикла на сайте Автомечта.' . $this->i18n()->seller_comments;
        $metaDescriptionModel->i18n()->value = $description;
        $metaDescriptionModel->save();
        unset($metaDescriptionModel);

        $metaKeywordsModel = new MetaData();

        $metaKeywordsModel->linked_table = static::TABLE_NAME;
        $metaKeywordsModel->linked_id = $this->id;
        $metaKeywordsModel->type = MetaData::TYPE_KEYWORDS;

        switch ($this->type) {

            case ProductType::CARS:
                $productType = 'автомобиль';
                break;
            case ProductType::MOTO:
                $productType = 'мотоцикл';
                break;
            case ProductType::SCOOTER:
                $productType = 'скутер';
                break;
            case ProductType::ATV:
                $productType = 'квадроцикл';
                break;
        }

        $keywords = $this->getShortTitle() . ' , ' . $this->year . ' г.в., Минск, объявление, продам, ' . $productType . ' , купить ' . $productType . ', автомечта, кредит, купить в кредит, купить в кредит в  Минске';

        try {
            $metaKeywordsModel->i18n()->value = $keywords;
            $metaKeywordsModel->save();
        } catch (\yii\base\Exception $exception) {

        }

        unset($metaKeywordsModel);
    }

    /*
     * Update MetaData
     */
    public function updateProductMetaData()
    {
        $metaTitleModel = MetaData::find()->where(['and', ['linked_table' => static::TABLE_NAME], ['linked_id' => $this->id], ['type' => MetaData::TYPE_TITLE]])->one();
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

        $metaTitleModel->i18n()->value = $this->getFullTitle() . $specsStr . ', купить в кредит в Минске.';
        $metaTitleModel->save();
        unset($metaTitleModel);

        $metaDescriptionModel = MetaData::find()->where(['and', ['linked_table' => static::TABLE_NAME], ['linked_id' => $this->id], ['type' => MetaData::TYPE_DESCRIPTION]])->one();
        switch ($this->type) {

            case ProductType::CARS:
                $productType = 'автомобиль';
                break;
            case ProductType::MOTO:
                $productType = 'мотоцикл';
                break;
            case ProductType::SCOOTER:
                $productType = 'скутер';
                break;
            case ProductType::ATV:
                $productType = 'квадроцикл';
                break;
        }

        $description = 'Купить ' . $productType . ' ' . $this->getFullTitle() . ' ' . $specsStr . ' .Цена ' . $this->price . ' в кредит в Минске. Частное объявление о продаже квадроцикла на сайте Автомечта.' . $this->i18n()->seller_comments;
        $metaDescriptionModel->i18n()->value = $description;
        $metaDescriptionModel->save();
        unset($metaDescriptionModel);

        $metaKeywordsModel = MetaData::find()->where(['and', ['linked_table' => static::TABLE_NAME], ['linked_id' => $this->id], ['type' => MetaData::TYPE_KEYWORDS]])->one();
        switch ($this->type) {

            case ProductType::CARS:
                $productType = 'автомобиль';
                break;
            case ProductType::MOTO:
                $productType = 'мотоцикл';
                break;
            case ProductType::SCOOTER:
                $productType = 'скутер';
                break;
            case ProductType::ATV:
                $productType = 'квадроцикл';
                break;
        }

        $keywords = $this->getShortTitle() . ' , ' . $this->year . ' г.в., Минск, объявление, продам, ' . $productType . ' , купить ' . $productType . ', автомечта, кредит, купить в кредит, купить в кредит в  Минске';

        try {
            $metaKeywordsModel->i18n()->value = $keywords;
            $metaKeywordsModel->save();
        } catch (\Error $error) {

        }
        unset($metaKeywordsModel);
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


    /**
     * @return integer
     */
    public function exchangeBynToUsd($byn)
    {
        $appData = AppData::getData();
        if (!is_numeric($appData['usdRate'])) {
            $rate = 1;
        } else {
            $rate = $appData['usdRate'];
        }

        return intval($byn / $rate);
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
     * @return string;
     */
    public function getShortTitle()
    {
        return $this->getMake0()->one()->name . ' ' . $this->model;
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    /*
     * Get Product
     */
    public static function getProduct($id)
    {
        if (Yii::$app->cache->exists('product_' . $id)) {
            $result['product'] = json_decode(Yii::$app->cache->getField('product_' . $id, 'product'));
            $result['views'] = Yii::$app->cache->getField('product_' . $id, 'counter');
        } else {
            $model = self::find()->where(['id' => $id])->one();
            $product = [];
            $product ['id'] = $model->id;
            $product ['make'] = $model->getMake0()->one()->name;
            $product ['type'] = $model->type;
            $product['makeid'] = ProductMake::find()->where(['and', ['depth' => 2], ['name' => $model->model], ['product_type' => $model->type]])->one()->id;
            $product ['model'] = $model->model;
            $product ['year'] = $model->year;
            $product['views'] = $model->views;
            $product ['title'] = $model->getFullTitle();
            $product ['title_image'] = $model->getTitleImageUrl(267, 180);
            $product ['short_title'] = $model->i18n()->title;
            $product ['price_byn'] = $model->getByrPrice();
            $product ['price_usd'] = $model->getUsdPrice();
            $product ['exchange'] = $model->exchange;
            $product ['auction'] = $model->auction;
            $product ['priority'] = $model->priority;
            $product ['seller_comments'] = $model->i18n()->seller_comments;
            $product ['created_at'] = $model->created_at;
            $product ['created_by'] = $model->created_by;
            $product ['updated_at'] = $model->updated_at;
            $product ['phone'] = $model->phone;
            $product ['phone_2'] = $model->phone_2;
            $product ['phone_3'] = $model->phone_3;
            $product ['phone_provider_2'] = $model->phone_provider_2;
            $product ['phone_provider_3'] = $model->phone_provider_3;
            $product ['first_name'] = $model->first_name;
            $product ['region'] = $model->region;
            $product ['city_id'] = $model->city_id;
            $product ['video'] = $model->video;

            /*
             * Image
             */
            $uploads = $model->getUploads();
            $product ['image'] = [];
            foreach ($uploads as $i => $upload) {
                $product  ['image'] [$i] ['full'] = $upload->getThumbnail(800, 460);
                $product  ['image'] [$i] ['thumbnail'] = $upload->getThumbnail(115, 85);
            }

            /*
             * Specification
             */
            $productSpecifications = $model->getSpecifications();
            $productSpecificationsMain = array_filter($productSpecifications, function ($productSpec) {
                $specification = $productSpec->getSpecification()->one();
                return $specification->type != Specification::TYPE_BOOLEAN;
            });
            $productSpecificationsMain = array_values($productSpecificationsMain);
            $productSpecificationsAdditional = array_filter($productSpecifications, function ($productSpec) {
                $specification = $productSpec->getSpecification()->one();
                return $specification->type == Specification::TYPE_BOOLEAN;
            });
            $productSpecificationsAdditional = array_values($productSpecificationsAdditional);
            foreach ($productSpecificationsAdditional as $key => $productSpecification) {
                $productSpecificationsAdditionalCols[$key % 3][] = $productSpecification;
            }

            /*
            * Additional specification
            */
            $product ['specAdditional'] = [];
            $countSpecifications = ProductSpecification::find()->where(['product_id' => $model->id])
                ->andWhere(['value' => 1])->count();
            if ($countSpecifications > 0) {
                foreach ($productSpecificationsAdditionalCols as $i => $productSpecificationsAdditionalCol) {
                    foreach ($productSpecificationsAdditionalCol as $i => $productSpecificationsAdditional) {
                        $spec = $productSpecificationsAdditional->getSpecification()->one();
                        if ((int)$productSpecificationsAdditional->value == 1) {
                            $product  ['spec_additional'] [$i] ['name'] = $spec->i18n()->name;
                        }
                    }
                }
            }

            /*
             * Main Specification
             */
            $product ['spec'] = [];
            foreach ($productSpecificationsMain as $i => $productSpec) {
                $spec = $productSpec->getSpecification()->one();
                $product  ['spec'] [$i] ['name'] = $spec->i18n()->name;
                $product  ['spec'] [$i] ['format'] = $productSpec->getFormattedValue();
                $product  ['spec'] [$i] ['unit'] = $spec->i18n()->unit;
            }

            /*
             * Similar product
             */
            $similarProducts = Product::find()
                ->where(['status' => Product::STATUS_PUBLISHED])
                ->andwhere(['!=', 'id', $model->id])
                ->andwhere(['make' => $model->make])
                ->andWhere(['model' => $model->model])
                ->orderBy('RAND()')
                ->limit(4)
                ->all();
            $product ['similar'] = [];
            foreach ($similarProducts as $i => $similarProduct) {
                $product['similar'][$i]['id'] = $similarProduct->id;
                $product['similar'][$i]['main_image_url'] = $similarProduct->getTitleImageUrl(640, 480);
                $product['similar'][$i]['full_title'] = $similarProduct->getFullTitle();
                $product['similar'][$i]['price_byn'] = $similarProduct->getByrPrice();
                $product['similar'][$i]['price_usd'] = $similarProduct->getUsdPrice();
                $product['similar'][$i]['city_id'] = $similarProduct->city_id;
                $product['similar'][$i]['year'] = $similarProduct->year;
                $product['similar'][$i]['spec'] = [];
                foreach ($similarProduct->getSpecifications(Specification::PRIORITY_HIGHEST) as $params => $productSpec) {
                    $spec = $productSpec->getSpecification()->one();
                    $product['similar'][$i]['spec'][$params]['name'] = $spec->i18n()->name;
                    $product['similar'][$i]['spec'][$params]['get_title_image_url'] = $spec->getTitleImageUrl(20, 20);
                    $product['similar'][$i]['spec'][$params]['value'] = $productSpec->getFormattedValue();
                    $product['similar'][$i]['spec'][$params]['unit'] = $spec->i18n()->unit;
                }
                unset($productSpec);
                unset($params);
                foreach ($similarProduct->getSpecifications(Specification::PRIORITY_HIGH) as $params => $productSpec) {
                    $spec = $productSpec->getSpecification()->one();
                    $product['similar'][$i]['spec'][$params]['priority_hight']['name'] = $spec->i18n()->name;
                    $product['similar'][$i]['spec'][$params]['priority_hight']['value'] = $productSpec->getFormattedValue();
                    $product['similar'][$i]['spec'][$params]['priority_hight']['unit'] = $spec->i18n()->unit;
                }
            }
            $views = $product['views'];
            $product = json_encode($product);
            $params = [
                'product' => json_encode($product),
                'counter' => $views,
            ];
            unset($product);
            Yii::$app->cache->hmset('product_' . $id, $params, 172800);
            unset($params);
            gc_collect_cycles();
            $result['product'] = json_decode(Yii::$app->cache->getField('product_' . $id, 'product'));
            $result['views'] = Yii::$app->cache->getField('product_' . $id, 'counter');
        }


        return $result;
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
            self::STATUS_BEFORE_CREATE_ADS => 'В работе',
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
