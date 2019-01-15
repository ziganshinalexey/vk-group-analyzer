<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\traits\user;

use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Yii2VkApi\interfaces\user\ComponentInterface;

/**
 * Трейт, содержащий логику доступа к компоненту "ВК пользователь".
 */
trait UserComponentTrait
{
    /**
     * Экземпляр объекта компонента "ВК пользователь".
     *
     * @var ComponentInterface|null
     */
    protected $userComponent;

    /**
     * Метод возвращает объект компонента "ВК пользователь".
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return ComponentInterface
     */
    public function getUserComponent(): ComponentInterface
    {
        if (! $this->userComponent) {
            $this->userComponent = Yii::$app->get('user');
        }
        return $this->userComponent;
    }

    /**
     * Метод устанавливает объект компонента "ВК пользователь".
     *
     * @param ComponentInterface $component Новое значение компонента.
     *
     * @return void
     */
    public function setUserComponent(ComponentInterface $component): void
    {
        $this->userComponent = $component;
    }
}
