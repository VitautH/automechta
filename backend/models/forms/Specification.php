<?php

namespace backend\models\forms;

use Yii;
use yii\helpers\Html;
use common\models\Specification as SpecificationModel;
use common\models\ProductSpecification;
use yii\widgets\ActiveForm;

/**
 * Class Specification
 * @package common\models\forms
 */
class Specification extends \yii\base\Model
{

    /**
     * @param SpecificationModel $specification
     * @param ProductSpecification $productSpecification
     * @param ActiveForm $form
     * @return string
     */
    public static function getControl(SpecificationModel $specification, ProductSpecification $productSpecification, ActiveForm $form = null)
    {
        $result = '';
        switch ($specification->type) {
//            case SpecificationModel::TYPE_CHECKBOX_LIST:
//                $result = static::getCheckboxListControl($specification, $value, $extraValue);
//                break;
            case SpecificationModel::TYPE_DROP_DOWN:
                $result = static::getDropDownControl($specification, $productSpecification, $form);
                break;
            case SpecificationModel::TYPE_NUMERIC:
                $result = static::getNumericControl($specification, $productSpecification, $form);
                break;
//            case SpecificationModel::TYPE_RANGE:
//                $result = static::getRangeControl($specification, $value, $extraValue);
//                break;
            case SpecificationModel::TYPE_TEXT:
                $result = static::getTextControl($specification, $productSpecification, $form);
                break;
            case SpecificationModel::TYPE_BOOLEAN:
                $result = static::getBooleanControl($specification, $productSpecification, $form);
                break;
        }

        return $result;
    }

//    public static function getCheckboxListControl(SpecificationModel $specification, ProductSpecification $productSpecification, ActiveForm $form)
//    {
//        $optionsList = array_combine($specification->i18n()->getValuesArray(), $specification->i18n()->getValuesArray());
//
//        $result = '';
//
//        foreach ($optionsList as $option) {
//            $result .= '<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">' . PHP_EOL .
//            Html::checkbox(
//                'Specification[' . $specification->id . '][]',
//                $productSpecification->value,
//                [
//                    'class' => 'mdl-checkbox__input',
//                    'value' => $option,
//                ]
//            ) . PHP_EOL .
//                '<span class="mdl-checkbox__label">' . $option . '</span>' . PHP_EOL .
//            '</label><br>';
//        }
//
//        return $result;
//    }

    public static function getDropDownControl(SpecificationModel $specification, ProductSpecification $productSpecification, ActiveForm $form)
    {
        $optionsList = array_combine($specification->i18n()->getValuesArray(), $specification->i18n()->getValuesArray());

        return $form->field($productSpecification, "[{$specification->id}]value")->dropDownList($optionsList, [
            'class' => 'mdl-textfield__input',
        ]);
    }

    public static function getNumericControl(SpecificationModel $specification, ProductSpecification $productSpecification, ActiveForm $form)
    {
        return $form->field($productSpecification, "[{$specification->id}]value")->textInput(['maxlength' => true]);
    }

//    public static function getRangeControl(SpecificationModel $specification, ProductSpecification $productSpecification, ActiveForm $form)
//    {
//
//        return '<div class="mdl-textfield mdl-js-textfield ">' .
//            Html::textInput('ProductSpecification[' . $specification->id . '][From]', $productSpecification->value, ['class' => 'mdl-textfield__input']) .
//            '<label class="mdl-textfield__label">' . Yii::t('app', 'From') . '</label>' .
//        '</div>' .
//        ' ' .
//        '<div class="mdl-textfield mdl-js-textfield ">' .
//            Html::textInput('ProductSpecification[' . $specification->id . '][To]', $productSpecification->value, ['class' => 'mdl-textfield__input']) .
//            '<label class="mdl-textfield__label">' . Yii::t('app', 'To') . '</label>' .
//        '</div>';
//    }

    public static function getTextControl(SpecificationModel $specification, ProductSpecification $productSpecification, ActiveForm $form)
    {
        return $form->field($productSpecification, "[{$specification->id}]value")->textInput(['maxlength' => true]);
    }

    public static function getBooleanControl(SpecificationModel $specification, ProductSpecification $productSpecification, ActiveForm $form)
    {
        return $form->field($productSpecification, "[{$specification->id}]value")->checkbox([
            'class' => 'mdl-checkbox__input',
            'label' => '',
            'labelOptions' => [
                'class' => 'mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect',
            ]
        ]);
    }
}
