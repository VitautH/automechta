<?php

namespace frontend\widgets;

use yii\helpers\Html;
use frontend\widgets\ChildPagination;
/**
 * Class LinkPager
 * @package frontend\widgets
 */
class CustomPager extends ChildPagination
{
    public $wrapperOptions = [];

    /**
     * Renders the page buttons.
     * @return string the rendering result
     */
    protected function renderPageButtons()
    {
        return Html::tag('div', parent::renderNextPageButton().parent::renderPageButtons(), $this->wrapperOptions);
    }

}
