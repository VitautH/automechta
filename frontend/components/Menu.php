<?php

namespace frontend\components;

use Yii;
use common\components\Menu as CommonMenu;
use common\models\Menu as MenuModel;

/**
 * Class Menu
 *
 * @package backend\model
 */
class Menu extends CommonMenu
{

    /**
     * Menu constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $roots = MenuModel::find()->where('depth=1')->orderBy('lft')->all();

        $items = [];
        $this->buildItems($items, $roots);

        $this->setItems($items);
        parent::__construct($config);
    }

    public function getTopItems()
    {
        $result = [];
        $items = parent::getTopItems();
        foreach ($items as $item) {
            unset($item['template']);
            $result[] = $item;
        }
        return $result;
    }

    /**
     * @param $items
     * @param $models
     */
    private function buildItems(&$items, $models)
    {
        foreach ($models as $model) {
            $item = [
                'label' => $model->i18n()->name,
                'url' => [$model->route]
            ];
            $child = $model->leaves()->all();
            if (!empty($child)) {
                $item['template'] = '<a class="dropdown-toggle" data-toggle=\'dropdown\' href="#">{label} <span class="fa fa-caret-down"></span></a>' . "\n";
                $item['items'] = [];
                $item['options'] = ['class' => 'dropdown'];
                $this->buildItems($item['items'], $child);
            }
            $items[] = $item;
        }
    }

}