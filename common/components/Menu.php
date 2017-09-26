<?php

namespace common\components;

use Yii;
use yii\base\Component;

/**
 * Class Menu
 *
 * @package common\components
 */
class Menu extends Component
{
    /**
     * @var array $items
     * @see \yii\widgets\Menu::items for details.
     */
    private $items = [];

    /**
     * @var string the route used to determine if a menu item is active or not.
     * If not set, it will use the route of the current request.
     */
    private $route = null;

    public function __construct(array $config = [])
    {
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }

        parent::__construct($config);
    }

    /**
     * @param array $items
     * @see \yii\widgets\Menu::items for details.
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * Get route value.
     * @return string route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * The route used to determine if a menu item is active or not.
     * If not set, it will use the route of the current request.
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * Get all items
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Get top level items
     * @return array
     */
    public function getTopItems()
    {
        $result = [];
        foreach ($this->items as $item) {
            $topItem = $item;
            unset($topItem['items']);
            $result[] = $topItem;
        }
        return $result;
    }

    /**
     * Get side items based on current route
     * @param integer $level number of nested level
     * @return array
     */
    public function getSideItems($level = 1)
    {
        $route = ltrim($this->getRoute(), '/');

        $currentLevel = 1;

        $innerBranch = null;
        $branch = $this->getBranch($route);

        while ($branch && $currentLevel < $level) {
            if (isset($branch[0]['items'])) {
                $branch = $this->getBranch($route, $branch[0]['items']);
            }
            $currentLevel++;
        }

        if (isset($branch[0]['items'])) {
            $innerBranch = $this->getBranch($route, $branch[0]['items']);
        }

        $result = [];

        if (is_array($branch) && isset($branch[0]['items'])) {
            foreach($branch[0]['items'] as $item) {
                if ($item['url'] === $route || (isset($innerBranch[0]['url']) && $innerBranch[0]['url'] === $item['url'])) {
                    $item['active'] = true;
                }
                unset($item['items']);
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * Get breadcrumbs array to be used in yii\widgets\Breadcrumbs widget.
     * @param array $items - for internal usage
     * @return array
     */
    public function getBreadcrumbs($items = null)
    {
        $route = ltrim($this->getRoute(), '/');
        if ($items === null) {
            $items = $this->items;
        }

        foreach ($items as $item) {
            $result = [];
            if (isset($item['url']) && $item['url'][0] === $route) {
                $result[] = $item['label'];
                break;
            } elseif (isset($item['items'])) {
                $result[] = ['label' => $item['label'], 'url' => $item['url']];
                $result = array_merge($result, $this->getBreadcrumbs($item['items']));
            }
            if (!empty($result) && is_string($result[count($result) - 1])) {
                break;
            }
        }
        if (!empty($result) && !is_string($result[count($result) - 1])) {
            $result = [];
        }
        return $result;
    }

    /**
     * Get item by route
     * @param string $route
     * @param array $items
     * @param boolean $found - for internal usage
     * @return array|null
     */
    public function getBranch($route = null, array $items = null, &$found = false)
    {
        $result = null;

        if ($route === null) {
            $route = $this->getRoute();
        }
        if ($items === null) {
            $items = $this->getItems();
        }

        foreach ($items as $item)  {
            if ($found) {
                break;
            }

            $result = [$item];

            if (isset($item['url']) && $item['url'][0] === $route) {
                $found = true;
                break;
            }

            if (isset($item['items'])) {
                $this->getBranch($route, $item['items'], $found);
            }
        }

        return $found ? $result : null;
    }
}
