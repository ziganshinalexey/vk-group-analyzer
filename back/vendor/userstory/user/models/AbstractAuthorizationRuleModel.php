<?php

namespace Userstory\User\models;

use Userstory\User\interfaces\RuleInterface;
use yii\base\BaseObject;

/**
 * Абстрактный класс - базовый при разработке правил проверки.
 *
 * @package Userstory\User\models
 */
abstract class AbstractAuthorizationRuleModel extends BaseObject implements RuleInterface
{
    /**
     * Список обрабатываемых полномочий.
     *
     * @var array
     */
    protected $permissionList = [];

    /**
     * Геттер списка полномочий, обрабатываемых правилом.
     *
     * @return array
     */
    public function getPermissionList()
    {
        return $this->permissionList;
    }

    /**
     * Сеттер для списка полномочий, обрабатываемых правилом.
     *
     * @param array|string $permissionList список или название проверяемого полномочия.
     *
     * @return static
     */
    public function setPermissionList($permissionList)
    {
        $this->permissionList = (array)$permissionList;
        return $this;
    }
}
