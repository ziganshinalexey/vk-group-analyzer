<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\traits\group;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Yii2VkApi\hydrators\GroupDatabaseHydrator;

/**
 * Трейт, содержащий логику доступа к гидратору сущности "ВК группа" в массив для записи в БД и обратно.
 */
trait DatabaseHydratorTrait
{
    /**
     * Экземпляр объекта гидратора для работы с БД сущности "ВК группа".
     *
     * @var GroupDatabaseHydrator|null
     */
    protected $groupDatabaseHydrator;

    /**
     * Метод возвращает объект гидратора сущности "ВК группа" в массив для записи в БД и обратно.
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return HydratorInterface
     */
    protected function getGroupDatabaseHydrator(): HydratorInterface
    {
        if (null === $this->groupDatabaseHydrator) {
            throw new InvalidConfigException('Hydrator object can not be null');
        }
        return $this->groupDatabaseHydrator;
    }

    /**
     * Метод задает значение гидратора сущности "ВК группа" в массив для записи в БД и обратно.
     *
     * @param HydratorInterface $hydrator Объект класса преобразователя.
     *
     * @return static
     */
    public function setGroupDatabaseHydrator(HydratorInterface $hydrator)
    {
        $this->groupDatabaseHydrator = $hydrator;
        return $this;
    }
}
