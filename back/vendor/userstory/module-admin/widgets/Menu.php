<?php

namespace Userstory\ModuleAdmin\widgets;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu as YiiMenu;

/**
 * Класс меню в админке. Рендеринг и прочая ботва.
 *
 * Theme menu widget.
 */
class Menu extends YiiMenu
{
    /**
     * Шаблон ссылки в отображении меню.
     *
     * @var string $linkTemplate
     */
    public $linkTemplate = '<a href="{url}">{icon} {label}</a>';

    /**
     * Шаблон подменю в отображении всего меню.
     *
     * @var string $submenuTemplate
     */
    public $submenuTemplate = "\n<ul class='treeview-menu' {show}>\n{items}\n</ul>\n";

    /**
     * Галочка использования предков в меню.
     *
     * @var boolean $activateParents
     */
    public $activateParents = true;

    /**
     * Рекурсивный рендер пунктов меню.
     *
     * @param mixed $items Пункты, которые нужно отрендерить.
     *
     * @throws \yii\base\InvalidParamException если $item не массив и не объект.
     * @return string
     */
    protected function renderItems($items)
    {
        $n     = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag     = ArrayHelper::remove($options, 'tag', 'li');
            $class   = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if (0 === $i && null !== $this->firstItemCssClass) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && null !== $this->lastItemCssClass) {
                $class[] = $this->lastItemCssClass;
            }
            if (! empty($item['items'])) {
                $class[] = 'treeview';
            }
            if (! empty($class)) {
                if (empty($options['class'])) {
                    $options['class'] = implode(' ', $class);
                } else {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }
            $menu = $this->renderItem($item);
            if (! empty($item['items'])) {
                $menu .= strtr($this->submenuTemplate, [
                    '{show}'  => $item['active'] ? "style='display: block'" : '',
                    '{items}' => $this->renderItems($item['items']),
                ]);
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }
        return implode("\n", $lines);
    }

    /**
     * Генерация отображения пункта меню.
     *
     * @param mixed $item Пункт меню.
     *
     * @throws \yii\base\InvalidParamException если $item не массив и не объект.
     * @return string
     */
    protected function renderItem($item)
    {
        if (isset($item['items'])) {
            $linkTemplate = '<a href="{url}">{icon} {label} <i class="fa fa-angle-left pull-right"></i></a>';
        } else {
            $linkTemplate = $this->linkTemplate;
        }
        if (isset($item['url'])) {
            $template   = ArrayHelper::getValue($item, 'template', $linkTemplate);
            $url        = empty($item['url']) ? Url::to('/') : Url::to($item['url']);
            $iconFirst  = [
                '{url}'   => $url,
                '{label}' => '<span>' . $item['label'] . '</span>',
                '{icon}'  => '<i class="' . $item['icon'] . '"></i> ',
            ];
            $url        = empty($item['url']) ? Url::to('/') : Url::to($item['url']);
            $iconSecond = [
                '{url}'   => $url,
                '{label}' => '<span>' . $item['label'] . '</span>',
                '{icon}'  => null,
            ];
            $replace    = ! empty($item['icon']) ? $iconFirst : $iconSecond;
            return strtr($template, $replace);
        } else {
            $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);
            $iconExt  = [
                '{label}' => '<span>' . $item['label'] . '</span>',
                '{icon}'  => '<i class="' . $item['icon'] . '"></i> ',
            ];
            $iconSim  = [
                '{label}' => '<span>' . $item['label'] . '</span>',
            ];
            $replace  = ! empty($item['icon']) ? $iconExt : $iconSim;
            return strtr($template, $replace);
        }
    }

    /**
     * Нормализация (отображения или структуры, хз).
     *
     * @param mixed $items  Пункты меню.
     * @param mixed $active Нужно ли их активировать.
     *
     * @return array
     */
    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && ! $item['visible']) {
                unset($items[$i]);
                continue;
            }
            if (! isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel        = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $items[$i]['icon']  = isset($item['icon']) ? $item['icon'] : '';
            $hasActiveChild     = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if ($this->hideEmptyItems && empty($items[$i]['items'])) {
                    unset($items[$i]['items']);
                    if (! isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (! isset($item['active'])) {
                if (( $this->activateParents && $hasActiveChild ) || ( $this->activateItems && $this->isItemActive($item) )) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active']) {
                $active = true;
            }
        }
        return array_values($items);
    }

    /**
     * Проверка того пункт в меню активный.
     *
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     *
     * @param mixed $item Проверяемый пункт меню.
     *
     * @return boolean
     */
    protected function isItemActive($item)
    {
        if (isset($item['url'][0]) && is_array($item['url'])) {
            $route = $item['url'][0];
            if (Yii::$app->controller && '/' !== $route[0]) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            $arrayRoute     = explode('/', ltrim($route, '/'));
            $arrayThisRoute = explode('/', $this->route);
            if ($arrayRoute[0] !== $arrayThisRoute[0]) {
                return false;
            }
            if (isset($arrayRoute[1]) && $arrayRoute[1] !== $arrayThisRoute[1]) {
                return false;
            }
            if (isset($arrayRoute[2]) && $arrayRoute[2] !== $arrayThisRoute[2]) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                foreach (array_splice($item['url'], 1) as $name => $value) {
                    if (null !== $value && ( ! isset($this->params[$name]) || $this->params[$name] !== $value )) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }
}
