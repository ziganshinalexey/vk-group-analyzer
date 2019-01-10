<?php

namespace Userstory\ModuleAdmin\components;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use yii\base\Component;
use yii\base\Event;
use yii\base\InvalidConfigException;

/**
 * Данный класс отвечает за создание списка пунктов меню.
 *
 * @package Userstory\ComponentBase\components
 */
class Automenu extends Component
{
    /**
     * Данная константа содержит событие получения меню.
     */
    const EVENT_GET_MENU = 'Userstory\ModuleAdmin\components\Automenu::getMenu';

    /**
     * Данное свойство содержит массив с пунктами всех существующих в приложении меню.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Геттер для свойства items, возвращает его значение.
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Сеттер для свойства items, устанавливает его значение.
     *
     * @param array $items Список пунктов меню.
     *
     * @return static
     */
    public function setItems(array $items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * Данный метод добавляет в массив с пунктами всех существующих в приложении меню список динамических пунктов меню.
     *
     * @param array $dynamicItems Список динамических пунктов меню.
     *
     * @return static
     */
    public function addMenu(array $dynamicItems)
    {
        $this->items = ArrayHelper::merge($this->items, $dynamicItems);

        return $this;
    }

    /**
     * Данный метод возвращает массив с пунктами меню для меню с указанным именем или пустой массив, если меню с
     * указанным именем не найдено.
     *
     * @param string $name Строка с именем меню.
     *
     * @throws InvalidConfigException если компонент listener не найден.
     * @throws \yii\base\InvalidParamException если параметры $direction или $sortFlag имеют некорректное кол-во элементов или не имеют нужные ключи.
     *
     * @return array
     */
    public function getMenu($name)
    {
        $event = new Event([
            'sender' => $this,
        ]);
        $this->trigger(static::EVENT_GET_MENU, $event);
        $result = isset($this->items[$name]) ? $this->items[$name] : [];
        $this->sortMultiArray($result);

        return $result;
    }

    /**
     * Данный метод сортирует массив, элементы которого сами являются массивами, по элементу с указанным ключом.
     *
     * @param array   $arr       Сортируемый массив.
     * @param string  $field     Поле, по которому сортируется массив.
     * @param integer $direction Направление сортировки.
     *
     * @return void
     * @throws \yii\base\InvalidParamException если параметры $direction или $sortFlag имеют некорректное кол-во элементов или не имеют нужные ключи.
     */
    protected function sortMultiArray(array &$arr, $field = 'priority', $direction = SORT_DESC)
    {
        foreach ($arr as $key => $element) {
            if (isset($arr[$key]['child']) && ! empty($arr[$key]['child']) && is_array($arr[$key]['child'])) {
                $this->sortMultiArray($arr[$key]['child'], $field, $direction);
            }
        }

        ArrayHelper::multisort($arr, $field, $direction);
    }
}
