<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\traits\user;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Yii2VkApi\hydrators\UserDatabaseHydrator;

/**
 * Трейт, содержащий логику доступа к гидратору сущности "ВК пользователь" в массив для записи в БД и обратно.
 */
trait DatabaseHydratorTrait
{
    /**
     * Экземпляр объекта гидратора для работы с БД сущности "ВК пользователь".
     *
     * @var UserDatabaseHydrator|null
     */
    protected $userDatabaseHydrator;

    /**
     * Метод возвращает объект гидратора сущности "ВК пользователь" в массив для записи в БД и обратно.
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return HydratorInterface
     */
    protected function getUserDatabaseHydrator(): HydratorInterface
    {
        if (null === $this->userDatabaseHydrator) {
            throw new InvalidConfigException('Hydrator object can not be null');
        }
        return $this->userDatabaseHydrator;
    }

    /**
     * Метод задает значение гидратора сущности "ВК пользователь" в массив для записи в БД и обратно.
     *
     * @param HydratorInterface $hydrator Объект класса преобразователя.
     *
     * @return static
     */
    public function setUserDatabaseHydrator(HydratorInterface $hydrator)
    {
        $this->userDatabaseHydrator = $hydrator;
        return $this;
    }
}
