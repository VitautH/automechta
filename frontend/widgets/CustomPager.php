<?php

namespace frontend\widgets;

use yii\widgets\LinkPager;
use yii\helpers\Html;

/**
 * Class LinkPager
 * @package frontend\widgets
 */
class CustomPager extends LinkPager
{
    public $wrapperOptions = [];

    /**
     * Renders the page buttons.
     * @return string the rendering result
     */
    protected function renderPageButtons()
    {
        return Html::tag('div', parent::renderPageButtons(), $this->wrapperOptions);
    }

}
