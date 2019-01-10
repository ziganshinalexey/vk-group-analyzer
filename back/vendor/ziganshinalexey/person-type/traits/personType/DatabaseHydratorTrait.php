<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\traits\personType;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonType\hydrators\PersonTypeDatabaseHydrator;

/**
 * Трейт, содержащий логику доступа к гидратору сущности "Тип личности" в массив для записи в БД и обратно.
 */
trait DatabaseHydratorTrait
{
    /**
     * Экземпляр объекта гидратора для работы с БД сущности "Тип личности".
     *
     * @var PersonTypeDatabaseHydrator|null
     */
    protected $personTypeDatabaseHydrator;

    /**
     * Метод возвращает объект гидратора сущности "Тип личности" в массив для записи в БД и обратно.
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return HydratorInterface
     */
    protected function getPersonTypeDatabaseHydrator(): HydratorInterface
    {
        if (null === $this->personTypeDatabaseHydrator) {
            throw new InvalidConfigException('Hydrator object can not be null');
        }
        return $this->personTypeDatabaseHydrator;
    }

    /**
     * Метод задает значение гидратора сущности "Тип личности" в массив для записи в БД и обратно.
     *
     * @param HydratorInterface $hydrator Объект класса преобразователя.
     *
     * @return static
     */
    public function setPersonTypeDatabaseHydrator(HydratorInterface $hydrator)
    {
        $this->personTypeDatabaseHydrator = $hydrator;
        return $this;
    }
}
