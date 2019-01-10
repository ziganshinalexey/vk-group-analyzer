<?php

namespace Userstory\UserAdmin\forms;

use Userstory\User\entities\AuthRolePermissionActiveRecord as AuthRolePermission;

/**
 * Class PermissionForm.
 * Класс формы для работы с разрешениями ролей.
 *
 * @property boolean $isAssigned
 * @property string  $description
 *
 * @package Userstory\UserAdmin\forms
 */
class PermissionForm extends AuthRolePermission
{
    /**
     * Назначено ли разрешение роли.
     *
     * @var boolean|null
     */
    protected $isAssigned;

    /**
     * Описание текущего разрешения.
     *
     * @var string|null
     */
    protected $description;

    /**
     * Метод возвращает назначено ли разрешение роли.
     *
     * @return boolean
     */
    public function getIsAssigned()
    {
        return $this->isAssigned;
    }

    /**
     * Метод задает назначено ли разрешение роли.
     *
     * @param boolean $isAssigned Значение для установки.
     *
     * @return static
     */
    public function setIsAssigned($isAssigned)
    {
        $this->isAssigned = $isAssigned;
        return $this;
    }

    /**
     * Метод возвращает описание текущего разрешения.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Метод задает описание текущего разрешения.
     *
     * @param string $description Значение для установки.
     *
     * @return static
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Метод возвращает правила валидации атрибутов.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                ['isAssigned', 'isGlobal'],
                'boolean',
            ],
        ];
    }
}
