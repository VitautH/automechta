<?
namespace frontend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\base\Widget;
use yii\data\Pagination;
use yii\widgets\LinkPager;

class ChildPagination extends LinkPager
{
    public $currentPage;
    public $pageCount;

    /**
     * Renders the page buttons.
     * @return string the rendering result
     */
    protected function renderPageButtons()
    {
        parent::renderPageButtons();
        $this->pageCount = $this->pagination->getPageCount();
        if ($this->pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $this->currentPage = $this->pagination->getPage();

        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass,    $this->currentPage <= 0, false);
        }

        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page =    $this->currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass,    $this->currentPage <= 0, false);
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, null, false, $i ==    $this->currentPage);
        }

        // last page
//        $lastPageLabel = $this->lastPageLabel === true ?    $this->pageCount : $this->lastPageLabel;
//        if ($lastPageLabel !== false) {
//            $buttons[] = $this->renderPageButton($lastPageLabel,    $this->pageCount - 1, $this->lastPageCssClass,    $this->currentPage >=    $this->pageCount - 1, false);
//        }

        return Html::tag('ul', implode("\n", $buttons), $this->options);
    }

    /*
     * render Next button
     */
    protected function renderNextPageButton()
    {
        // next page
        $this->currentPage = $this->pagination->getPage();
        $this->pageCount = $this->pagination->getPageCount();
        if ($this->nextPageLabel !== false) {
            if (($page = $this->currentPage + 1) >= $this->pageCount - 1) {
                $page = $this->pageCount - 1;
            }
        return $this->renderButton('Следующая  <i class="fa fa-angle-double-right" aria-hidden="true"></i>', $page, $this->nextPageCssClass, $this->currentPage >= $this->pageCount - 1, false);

        }
    }
    /**
     * Renders a page button Next.
     * You may override this method to customize the generation of page buttons.
     * @param string $label the text label for the button
     * @param integer $page the page number
     * @param string $class the CSS class for the page button.
     * @param boolean $disabled whether this page button is disabled
     * @param boolean $active whether this page button is active
     * @return string the rendering result
     */
    protected function renderButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => empty($class) ? $this->pageCssClass : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);

            return Html::tag('li', Html::tag('span', $label), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        return Html::a($label, $this->pagination->createUrl($page), ['class'=>'btn m-btn m-btn-dark']);
    }

}

