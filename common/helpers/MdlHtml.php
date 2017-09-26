<?php

namespace common\helpers;

use Yii;
use yii\helpers\Html;

/**
 * @author Aleh Hutnikau <goodnickoff@gmail.com>
 */
class MdlHtml extends Html
{
    public static function activeDropDownList($model, $attribute, $items, $options = [])
    {
        $defaultOptions = [
            'class' => 'mdl-textfield__input',
            'containerOptions' => ['class'=>'mdl-textfield mdl-textfield--full-width mdl-js-textfield mdl-textfield--floating-label'],
            'labelOptions' => ['class'=>'mdl-textfield__label'],
        ];
        $options = array_merge($defaultOptions, $options);
        $labelOptions = $options['labelOptions'];
        $containerOptions = $options['containerOptions'];
        unset($options['containerOptions']);
        unset($options['labelOptions']);
        if (!array_key_exists('id', $options)) {
            $options['id'] = static::getInputId($model, $attribute);
        }
        $labelOptions['for'] = $options['id'];

        $label = isset($options['label']) ? $options['label'] : static::encode($model->getAttributeLabel($attribute));
        unset($options['label']);

        $result = static::beginTag('div', $containerOptions);
        $result .= parent::activeDropDownList($model, $attribute, $items, $options);
        $result .= static::tag('label', $label, $labelOptions);
        $result .= static::endTag('div');

        return $result;
    }

    /**
     * Generates an input tag for the given model attribute.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param string $type the input type (e.g. 'text', 'password')
     * @param Model $model the model object
     * @param string $attribute the attribute name or expression. See [[getAttributeName()]] for the format
     * about attribute expression.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     *
     * - containerOptions: array, defaults to ['class'=>'mdl-textfield mdl-js-textfield'].
     * - labelOptions: array, defaults to ['class'=>'mdl-textfield mdl-js-textfield'].
     *
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * @return string the generated input tag
     */
    public static function activeInput($type, $model, $attribute, $options = [])
    {
        $defaultOptions = [
            'class' => 'mdl-textfield__input',
            'containerOptions' => ['class'=>'mdl-textfield mdl-js-textfield'],
            'labelOptions' => ['class'=>'mdl-textfield__label'],
        ];
        $options = array_merge($defaultOptions, $options);
        $labelOptions = $options['labelOptions'];
        $containerOptions = $options['containerOptions'];
        unset($options['containerOptions']);
        unset($options['labelOptions']);
        if (!array_key_exists('id', $options)) {
            $options['id'] = static::getInputId($model, $attribute);
        }
        $labelOptions['for'] = $options['id'];

        $name = isset($options['name']) ? $options['name'] : static::getInputName($model, $attribute);
        $value = isset($options['value']) ? $options['value'] : static::getAttributeValue($model, $attribute);
        $label = isset($options['label']) ? $options['label'] : static::encode($model->getAttributeLabel($attribute));
        unset($options['label']);

        $result = static::beginTag('div', $containerOptions);
        $result .= static::input($type, $name, $value, $options);
        $result .= static::tag('label', $label, $labelOptions);
        $result .= static::endTag('div');

        return $result;
    }

    /**
     * Generates a checkbox input.
     * @param string $name the name attribute.
     * @param boolean $checked whether the checkbox should be checked.
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - uncheck: string, the value associated with the uncheck state of the checkbox. When this attribute
     *   is present, a hidden input will be generated so that if the checkbox is not checked and is submitted,
     *   the value of this attribute will still be submitted to the server via the hidden input.
     * - label: string, a label displayed next to the checkbox.  It will NOT be HTML-encoded. Therefore you can pass
     *   in HTML code such as an image tag. If this is is coming from end users, you should [[encode()]] it to prevent XSS attacks.
     *   When this option is specified, the checkbox will be enclosed by a label tag.
     * - labelOptions: array, the HTML attributes for the label tag. Do not set this option unless you set the "label" option.
     *
     * The rest of the options will be rendered as the attributes of the resulting checkbox tag. The values will
     * be HTML-encoded using [[encode()]]. If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     *
     * @return string the generated checkbox tag
     */
    public static function toggle($name, $checked = false, $options = [])
    {
        $defaultOptions = ['class'=>'mdl-switch__input'];

        $options = array_merge($defaultOptions, $options);

        $options['checked'] = (bool) $checked;
        $value = array_key_exists('value', $options) ? $options['value'] : '1';
        if (isset($options['uncheck'])) {
            // add a hidden field so that if the checkbox is not selected, it still submits a value
            $hidden = static::hiddenInput($name, $options['uncheck']);
            unset($options['uncheck']);
        } else {
            $hidden = '';
        }

        if (!isset($options['label'])) {
            $options['label'] = '';
        }

        $label = $options['label'];
        $labelOptions = isset($options['labelOptions']) ? $options['labelOptions'] : ['class' => 'mdl-switch mdl-js-switch'];
        unset($options['label'], $options['labelOptions']);

        $content = static::label(static::input('checkbox', $name, $value, $options) . '<span class="mdl-switch__label">' . $label . '</span>', null, $labelOptions);
        return $hidden . $content;
    }
}
