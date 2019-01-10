<?php

namespace Userstory\ComponentBase\traits;

use yii;
use yii\base\InvalidConfigException;

/**
 * Дополнительный трейт для компонентов, позволяет навесить много оброботчиков на одно и то же событие через конфиг.
 * Пример:
 * 'myComponent' => [
 *    'class' => 'app\myComponent',
 *    'on qwe' => [
 *        ['class', 'handler1'],
 *        ['class', 'handler2'],
 *    ],
 * ].
 *
 * @deprecated Следует использовать Userstory\Yii2Events\traits\MultipleHandlersTrait.
 */
trait MultipleHandlersTrait
{
    /**
     * Присоединяем оброботчики событий (Статик классы переделывает в объект!).
     *
     * @param string         $name    название события.
     * @param array|callable $handler обработчик собития.
     * @param mixed          $data    дополнительные данные.
     * @param boolean        $append  добавить в конец.
     *
     * @inherit
     *
     * @return void
     * @throws InvalidConfigException Генерирует в случае неправльной конфигурации пакета.
     */
    public function on($name, $handler, $data = null, $append = true)
    {
        $count = count($handler);
        for ($i = 0; $i < $count; $i ++) {
            if (is_string($handler[$i]) && class_exists($handler[$i])) {
                $eventHandler = [
                    $handler[$i],
                    $handler[++ $i],
                ];
                parent::on($name, $eventHandler);
            } elseif (is_array($handler[$i])) {
                if (class_exists($handler[$i][0])) {
                    $handler[$i][0] = Yii::createObject($handler[$i][0]);
                }
                parent::on($name, $handler[$i]);
            }
        }
    }
}
