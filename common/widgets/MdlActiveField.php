<?php


namespace common\widgets;

use yii\widgets\ActiveField;
use yii\helpers\Html;

/**
 * MdlActiveField represents a form input field within an [[ActiveForm]].
 *
 * @author Aleh Hutnikau <goodnickoff@gmail.com>
 */
class MdlActiveField extends ActiveField
{
    /**
     * Renders a toggle.
     * @see http://www.getmdl.io/components/index.html#toggles-section
     * This method will generate the "checked" tag attribute according to the model attribute value.
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - uncheck: string, the value associated with the uncheck state of the radio button. If not set,
     *   it will take the default value '0'. This method will render a hidden input so that if the radio button
     *   is not checked and is submitted, the value of this attribute will still be submitted to the server
     *   via the hidden input. If you do not want any hidden input, you should explicitly set this option as null.
     * - label: string, a label displayed next to the checkbox. It will NOT be HTML-encoded. Therefore you can pass
     *   in HTML code such as an image tag. If this is coming from end users, you should [[Html::encode()|encode]] it to prevent XSS attacks.
     *   When this option is specified, the checkbox will be enclosed by a label tag. If you do not want any label, you should
     *   explicitly set this option as null.
     * - labelOptions: array, the HTML attributes for the label tag. This is only used when the "label" option is specified.
     *
     * The rest of the options will be rendered as the attributes of the resulting tag. The values will
     * be HTML-encoded using [[Html::encode()]]. If a value is null, the corresponding attribute will not be rendered.
     *
     * If you set a custom `id` for the input element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @return $this the field object itself
     */
    public function toggle($options = [])
    {
        $defaultErrorOptions = ['class' => 'mdl-textfield__error'];
        $defaultInputOptions = ['class' => 'mdl-switch__input'];

        $this->template = "{input}\n<span class=\"mdl-switch__label\">" . $this->model->getAttributeLabel($this->attribute) . "</span>\n{error}";
        $this->options = array_merge($this->options, ['tag' => 'label', 'class' => 'mdl-switch mdl-js-switch']);

        $this->errorOptions = isset($options['errorOptions']) ? array_merge($defaultErrorOptions, $options['errorOptions']) : $defaultErrorOptions;
        $this->inputOptions = isset($options['inputOptions']) ? array_merge($defaultInputOptions, $options['inputOptions']) : $defaultInputOptions;

        parent::checkbox($this->inputOptions, false);
        return $this;
    }
}