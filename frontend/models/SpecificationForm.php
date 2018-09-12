<?php

namespace frontend\models;

use Yii;
use yii\helpers\Html;
use common\models\Specification as SpecificationModel;
use common\models\ProductSpecification;
use yii\widgets\ActiveForm;

/**
 * Class Specification
 * @package common\models\forms
 */
class SpecificationForm extends \yii\base\Model
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

    public static function getDropDownControl(SpecificationModel $specification, ProductSpecification $productSpecification, ActiveForm $form)
    {
        $optionsList = array_combine($specification->i18n()->getValuesArray(), $specification->i18n()->getValuesArray());
        $class = null;
        $required = null;

        if ($specification->required === 1) {
            $class = 'required-field';
            $required = 'required';
        }

        $options = [
            'class' => 'm-select ' . $class,
            'prompt' => 'Выбрать'
        ];
        $label = self::getLabel($specification);

        $hint = trim($specification->i18n()->comment);
        if (empty($hint)) {
            $hint = '&nbsp;';
        }

        $html = '<div class="form-field row ' . $required . '">
    <div class="col-lg-2">
    <label class="control-label">' . $label . '</label>
    </div>
<div class="col-lg-5">

' . $form->field($productSpecification, "[{$specification->id}]value", [])
                ->dropDownList($optionsList, $options)->label(false) . '


    </div>
    </div>';


        return $html;

        return $form->field($productSpecification, "[{$specification->id}]value", [
            'template' => "<label>" . $label . "</label>\n<div class='s-relative'>\n{input}\n<span class=\"fa fa-caret-down\"></span>\n\n{hint}\n{error}</div>",
            'options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s']
        ])
            ->dropDownList($optionsList, $options)->hint($hint);
    }

    public static function getNumericControl(SpecificationModel $specification, ProductSpecification $productSpecification, ActiveForm $form)
    {
        $label = self::getLabel($specification);
        $class = null;
        $required = null;

        if ($specification->required === 1) {
            $class = 'required-field';
            $required = 'required';
        }
        $hint = $specification->i18n()->comment;
        if (empty($hint)) {
            $hint = '&nbsp;';
        }

        $html = '<div class="form-field row ' . $required . '">
    <div class="col-lg-2">
    <label class="control-label">' . $label . '</label>
    </div>
<div class="col-lg-5">
' . $form->field($productSpecification, "[{$specification->id}]value", [])
                ->textInput(['maxlength' => true, 'class' => $class, 'placeholder' => $hint])->label(false) . '
    </div>
    </div>';


        return $html;


//        return $form->field($productSpecification, "[{$specification->id}]value", [
//            'template' => "<label>" . $label . "</label>\n<div class='s-relative'>\n{input}\n\n{error}</div>",
//            'options' => ['class' => 'b-submit__main-element wow zoomInUp', 'data-wow-delay' => '0.5s'],
//        ])
//            ->textInput(['maxlength' => true, 'class' => $class, 'placeholder' => $hint])->hint($hint);
    }

    public static function getTextControl(SpecificationModel $specification, ProductSpecification $productSpecification, ActiveForm $form)
    {
        $label = self::getLabel($specification);
        $class = null;
        $required = null;

        if ($specification->required === 1) {
            $class = 'required-field';
            $required = 'required';
        }

        $hint = $specification->i18n()->comment;
        if (empty($hint)) {
            $hint = '&nbsp;';
        }

        $html = '<div class="form-field row ' . $required . '">
    <div class="col-lg-2">
    <label class="control-label">' . $label . '</label>
    </div>
<div class="col-lg-5">
' . $form->field($productSpecification, "[{$specification->id}]value", [])
                ->textInput(['maxlength' => true, 'class' => $class, 'placeholder' => $hint])->label(false) . '
    </div>
    </div>';


        return $html;
//        return $form->field($productSpecification, "[{$specification->id}]value", [
//            'template' => "<label>".$label."</label>\n<div class='s-relative'>\n{input}\n\n{error}</div>",
//            'options' => ['class' => 'b-submit__main-element'],
//        ])
//        ->textInput(['maxlength' => true, 'class' => $class, 'placeholder'=>$hint])->hint($hint);
    }

    public static function getBooleanControl(SpecificationModel $specification, ProductSpecification $productSpecification, ActiveForm $form)
    {


        $id = Html::getInputId($productSpecification, "[{$specification->id}]value");
        return $form->field($productSpecification, "[{$specification->id}]value", [
            'template' => "\n{input}
<label class=\"s-submitCheckLabel\" for=\"$id\"><i class=\"fas fa-check\"></i></label>
<label class=\"s-submitCheck\" for=\"$id\">" . $specification->i18n()->name . "</label>
{hint}\n",
            'options' => ['class' => 'b-submit__main-element b-submit__main-element-checkbox'],
        ])
            ->checkbox([], false);
    }

    /**
     * @param $specification
     * @return string
     */
    public static function getLabel($specification)
    {
        $label = $specification->i18n()->name;
        if ($specification->required === 1) {
            $label .= ' <span class="text-danger">*</span>';
        }
        return $label;
    }
}
