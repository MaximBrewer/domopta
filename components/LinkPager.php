<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 15.05.17
 * Time: 13:05
 */

namespace app\components;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class LinkPager extends \yii\widgets\LinkPager
{
    public $prevPageLabel = '';
    public $prevPageCssClass = 'prev';
    public $nextPageLabel= '';
    public $nextPageCssClass = 'next';

    public $activePageCssClass = 'active';

    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();


        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, null, false, $i == $currentPage);
        }

        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        return implode("\n", $buttons);
    }


    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => empty($class) ? $this->pageCssClass : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled || $active) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            $tag = ArrayHelper::remove($this->disabledListItemSubTagOptions, 'tag', 'span');

            $this->disabledListItemSubTagOptions['class'] = $class;
            return Html::tag($tag, $label, $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;
        $linkOptions['class'] = $class;

        return Html::a($label, $this->pagination->createUrl($page), $options);
    }

}