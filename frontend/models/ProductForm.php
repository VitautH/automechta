<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Product;
use common\models\ProductType;

/**
 * ProductForm
 */
class ProductForm extends Model
{
    public $step;
    public $submitted;
    public $uploads;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['step', 'submitted'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'step' => Yii::t('app', 'Step'),
        ];
    }

    public function validateStep(Product $model)
    {
        $result = true;
        switch ($this->step) {
            case 0:
                break;
            case 1:
                break;
            case 2:
                break;
            case 3:
                if (empty(Yii::$app->request->post('Uploads'))) {
                    $result = false;
                    $this->addError('uploads', 'Необходимо загрузить хотя бы одно фото');
                }
                $result = $result && filter_var($this->submitted, FILTER_VALIDATE_BOOLEAN);
                break;
            case 4:
                break;
            default:
                $result = false;
                break;
        }
        return $result;
    }
}
