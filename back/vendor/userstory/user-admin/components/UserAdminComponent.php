<?php

namespace Userstory\UserAdmin\components;

use Userstory\ComponentBase\traits\ModelsFactoryTrait;
use Userstory\UserAdmin\factories\UserAdminFactory;
use Userstory\UserAdmin\operations\CommonOperation;
use Userstory\UserAdmin\operations\NotifyOperation;
use yii\base\Component;

/**
 * Class UserAdminComponent.
 * Класс компонента для работы с админкой пользователей.
 *
 * @property UserAdminFactory $modelFactory
 * @property NotifyOperation  $notifyOperation
 * @property CommonOperation  $commonOperation
 *
 * @package Userstory\UserAdmin\components
 */
class UserAdminComponent extends Component
{
    use ModelsFactoryTrait;

    /**
     * Объект операций для работы с уведомлениями.
     *
     * @var NotifyOperation|null
     */
    protected $notifyOperation;

    /**
     * Объект операций для работы с ролями и разрешениями.
     *
     * @var CommonOperation|null
     */
    protected $commonOperation;

    /**
     * Метод возвращает объект операций для работы с уведомлениями.
     *
     * @return NotifyOperation
     */
    public function getNotifyOperation()
    {
        /* @var UserAdminFactory $modelFactory */
        $modelFactory = $this->getModelFactory();

        if (null === $this->notifyOperation) {
            $this->notifyOperation = $modelFactory->getNotifyOperation();
        }

        return $this->notifyOperation;
    }

    /**
     * Метод возвращает объект общих операций.
     *
     * @return CommonOperation
     */
    public function getCommonOperation()
    {
        /* @var UserAdminFactory $modelFactory */
        $modelFactory = $this->getModelFactory();

        if (null === $this->commonOperation) {
            $this->commonOperation = $modelFactory->getCommonOperation();
        }

        return $this->commonOperation;
    }
}
