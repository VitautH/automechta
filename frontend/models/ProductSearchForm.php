<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\helpers\Html;
use common\models\ProductType;
use common\models\Specification;

/**
 * ProductSearchForm
 */
class ProductSearchForm extends Model
{

    static $pricesList = [];

    public $model;
    public $make;
    public $type;
    public $yearFrom;
    public $yearTo;
    public $priceFrom;
    public $priceTo;
    public $published;
    public $specifications;
    public $region;

    public function init()
    {
        $type = ProductType::find()->limit(1)->orderBy('lft')->active()->one();
        if ($type) {
            $this->type = $type->id;
        }
        return parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['model', 'make', 'type', 'specifications', 'yearFrom', 'yearTo', 'priceFrom', 'priceTo', 'published', 'region'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'model' => Yii::t('app', 'Model'),
            'make' => Yii::t('app', 'Make'),
            'type' => Yii::t('app', 'Type'),
            'specifications' => Yii::t('app', 'Specifications'),
            'yearFrom' => Yii::t('app', 'Min Year'),
            'yearTo' => Yii::t('app', 'Max Year'),
            'region' => Yii::t('app', 'Region'),
        ];
    }

    /**
     * @return array
     */
    public function getSpecificationModels()
    {
        $models = [];
        if ($this->type !== null) {
            $query = Specification::find()
                ->innerJoin('product_type_specifications', 'specification.id = product_type_specifications.specification')
                ->andWhere('product_type_specifications.type=:type', [':type' => $this->type])
                ->andWhere('depth>0')
                ->andWhere('in_search=1')
                ->orderBy('lft');

            $models = $query->all();
        }
        return $models;
    }

    /**
     * @param Query $query
     * @return Query
     */
    public function search(Query $query)
    {
        $query->andFilterWhere(['type' => $this->type]);
        $query->andFilterWhere(['make' => $this->make]);
        $query->andFilterWhere(['model' => $this->model]);
        if (!empty($this->yearFrom)) {
            $query->andWhere('year>=:yearFrom', [':yearFrom' => $this->yearFrom]);
        }
        if (!empty($this->yearTo)) {
            $query->andWhere('year<=:yearTo', [':yearTo' => $this->yearTo]);
        }
        if (!empty($this->priceFrom)) {
            $query->andWhere('price>=:priceFrom', [':priceFrom' => $this->priceFrom]);
        }
        if (!empty($this->priceTo)) {
            $query->andWhere('price<=:priceTo', [':priceTo' => $this->priceTo]);
        }
        if (!empty($this->region)) {
            $query->leftJoin('user', 'user.id=product.created_by');
            $query->andWhere('user.region=:region', [':region' => $this->region]);
        }
        if (!empty($this->published)) {
            $this->published = intval($this->published);
            $time = time()-$this->published;
            $query->andWhere('product.created_at>=:created_at', [':created_at' => $time]);
        }
        if (!empty($this->specifications) && is_array($this->specifications)) {
            $query->leftJoin('product_specification', 'product_specification.product_id=product.id');
            $query->groupBy('product.id')
                   ->select('product.*, count(product.id) as prod_num');
            $specNum = 0;
            $specQuery = new Query();
            foreach ($this->specifications as $specId => $specVal) {
                $specVal = trim($specVal);
                if ($specVal !== '') {
                    $specQuery->orWhere(
                        'product_specification.specification_id=:specification_id_' . $specNum . ' AND product_specification.value=:value_' . $specNum,
                        [':specification_id_' . $specNum => $specId, ':value_' . $specNum => $specVal]
                    );
                    $specNum++;
                }
            }
            if ($specNum>0) {
                $query->addParams($specQuery->params);
                $query->having('prod_num='.$specNum);
                $query->andWhere($specQuery->where);
            }
        }

        return $query;
    }

    /**
     * @param Specification $specification
     * @return string
     */
    public function getSpecInput(Specification $specification)
    {
        $result = '';
        $value = isset($this->specifications[$specification->id]) ? $this->specifications[$specification->id] : null;
        $id = 'productsearchform_spec_'.$specification->id;

        switch ($specification->type) {
            case Specification::TYPE_DROP_DOWN:
                $optionsList = array_combine($specification->i18n()->getValuesArray(), $specification->i18n()->getValuesArray());
                $result .= $this->getSpecLabel($specification);
                $result .= '<div>' . "\n";
                $result .= Html::dropDownList(
                    'ProductSearchForm[specs][' . $specification->id .']',
                    $value,
                    $optionsList,
                    ['class' => 'm-select', 'prompt' => Yii::t('app', 'Any'), 'id' => $id]
                );
                $result .= '<span class="fa fa-caret-down"></span>' . "\n";
                $result .= '</div>' . "\n";
                break;
            case Specification::TYPE_NUMERIC:
                break;
            case Specification::TYPE_TEXT:
                $result .= Html::input('text', 'ProductSearchForm[specs][' . $specification->id .']', $value) . "\n";
                break;
            case Specification::TYPE_BOOLEAN:
//                $result .= '<div class="col-xs-10" style="padding: 0;">' . "\n";
//                $result .= $this->getSpecLabel($specification);
//                $result .= '</div>' . "\n";
//                $result .= '<div class="col-xs-2" style="padding: 0; text-align: right;">' . "\n";
//                $result .= Html::checkbox('ProductSearchForm[specs][' . $specification->id .']', $value, ['id' => $id]). "\n";
//                $result .= '<label for="' . $id . '" class="b-items__cars-one-img-check"><span class="fa fa-check"></span></label>' . "\n";
//                $result .= '</div>' . "\n";

//                $result .= $this->getSpecLabel($specification);
                $result .= $this->getSpecLabel($specification);
                $result .= '<div>' . "\n";
                $result .= Html::dropDownList(
                    'ProductSearchForm[specs][' . $specification->id .']',
                    $value,
                    [
                        1 => Yii::t('app', 'Yes'),
                        0 => Yii::t('app', 'No'),
                    ],
                    ['class' => 'm-select', 'prompt' => Yii::t('app', 'Irrelevant'), 'id' => $id]
                );
                $result .= '<span class="fa fa-caret-down"></span>' . "\n";
                $result .= '</div>' . "\n";
                break;
        }
        return $result;
    }

    /**
     * @param Specification $specification
     * @return string
     */
    protected function getSpecLabel(Specification $specification)
    {
        $result = '<label>' . $specification->i18n()->name;
        if (!empty($specification->i18n()->unit)) {
            $result .= ' ,' . $specification->i18n()->unit;
        }
        $result .= '</label>' . "\n";
        return $result;
    }

    /**
     * @return array
     */
    public static function getPricesList()
    {
        if (empty(self::$pricesList)) {
            $result = [
                500 => 500,
            ];
            for ($i = 1; $i <= 60; $i++) {
                $price = $i*1000;
                $result[$price] = $price;
            }
            self::$pricesList = $result;
        }
        return self::$pricesList;
    }

    /**
     * @return array
     */
    public static function getPublishedPeriods()
    {
        return [
            (60*60*24*1) => Yii::t('app', '1 day'),
            (60*60*24*2) => Yii::t('app', '2 days'),
            (60*60*24*3) => Yii::t('app', '3 days'),
            (60*60*24*4) => Yii::t('app', '4 days'),
            (60*60*24*5) => Yii::t('app', '5 days'),
            (60*60*24*6) => Yii::t('app', '6 days'),
            (60*60*24*7) => Yii::t('app', '7 days'),
            (60*60*24*10) => Yii::t('app', '10 days'),
            (60*60*24*30) => Yii::t('app', '30 days'),
        ];
    }
}
