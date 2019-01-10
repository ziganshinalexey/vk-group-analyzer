<?php

namespace Userstory\ModuleAdmin\helpers;

use yii;

/**
 * Класс хелпера преобразования элементов меню.
 */
class Menu
{
    /**
     * Метод, который преобразовывает элементы меню.
     *
     * @param array $items элементы меню.
     *
     * @return array $preparedItems преобразованные элементы меню.
     */
    public static function prepareItems(array $items = [])
    {
        $preparedItems = [];

        foreach ($items as $item) {
            if (array_key_exists('permission', $item) && ! self::checkAccess($item['permission'])) {
                continue;
            }

            if (isset($item['child'])) {
                $pushedItem = [
                    'label' => self::prepareLabel($item['title']),
                    'items' => self::prepareItems($item['child']),
                ];
            } else {
                $pushedItem = [
                    'label' => self::prepareLabel($item['title']),
                ];
            }

            if (isset($item['icon'])) {
                $pushedItem['icon'] = $item['icon'];
            }

            if (isset($item['id'])) {
                $pushedItem['id'] = $item['id'];
            }

            if (isset($item['type'])) {
                $pushedItem['type'] = $item['type'];
            }

            if (isset($item['forceUpdate'])) {
                $pushedItem['forceUpdate'] = $item['forceUpdate'];
            } else {
                $pushedItem['forceUpdate'] = false;
            }

            if (isset($item['route']) || isset($item['url'])) {
                $url               = $item['route'] ? $item['route'] : $item['uri'];
                $pushedItem['url'] = [$url];
            } else {
                $pushedItem['url'] = [];
            }

            $preparedItems[] = $pushedItem;
        }

        return $preparedItems;
    }

    /**
     * Метод конвертирует переводы из конфига в строку.
     *
     * @param array|string $messageFromConfig Перевод из конфига.
     *
     * @return string
     */
    protected static function prepareLabel($messageFromConfig)
    {
        $alias   = null;
        $message = null;
        if (is_string($messageFromConfig)) {
            $alias   = lcfirst($messageFromConfig);
            $message = $messageFromConfig;
        }
        if (is_array($messageFromConfig)) {
            $alias   = lcfirst((string)key($messageFromConfig));
            $message = current($messageFromConfig);
        }
        if (null !== $alias && null !== $message) {
            return Yii::t('Admin.Menu', $alias, ['defaultTranslation' => $message]);
        }
        return '';
    }

    /**
     * Метод, который определяет доступ к элементам меню.
     *
     * @param string|array $permissions права на элементы меню.
     *
     * @return boolean
     */
    public static function checkAccess($permissions)
    {
        if (null === $permissions) {
            return true;
        }

        $access = false;
        foreach ((array)$permissions as $permission) {
            if (Yii::$app->user->can($permission)) {
                $access = true;
                break;
            }
        }

        return $access;
    }
}
