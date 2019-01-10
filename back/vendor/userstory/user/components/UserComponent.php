<?php

namespace Userstory\User\components;

use Userstory\ComponentBase\traits\ModelsFactoryTrait;
use Userstory\User\factories\UserFactory;
use yii\base\Component;

/**
 * Class UserComponent.
 * Класс компонента для работы с бозовой логикой пользователей.
 *
 * @property UserFactory $modelFactory
 *
 * @package Userstory\User\components
 */
class UserComponent extends Component
{
    use ModelsFactoryTrait;

    /**
     * Настройки каптчи для аутентификации.
     *
     *   'enable'       => boolean // Включить капчу
     *   'db'           => string, // ID компонента базы
     *   'failsNumber'  => integer // Число ошибочных попыток анутификации
     *   'restoreDB'    => boolean // Если true, то попытка востановления таблицы в случае её отсутствия
     *   'tableName'    => string  // Название таблицы для хранения ошибок аунтикикации
     *   'timeFrame'    => integer // Рамки учета времени в секундах
     * );
     *
     * @var array|null
     */
    protected $captchaConfig;

    /**
     * Задаёт сливанием настройки капчи для формы.
     *
     * @param array|mixed $value Конфиг капчи.
     *
     * @return void
     */
    public function setCaptchaConfig($value)
    {
        $this->captchaConfig = $value;
    }

    /**
     * Возвращает настройки капчи.
     *
     * @return array
     */
    public function getCaptchaConfig()
    {
        return $this->captchaConfig;
    }
}
