<?php

namespace Userstory\CompetingView\hydrators;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\CompetingView\entities\CompetingView;
use yii;
use Userstory\ModuleUser\entities\UserAuth;

/**
 * Класс для преобрзования данных из объекта в массив и наоборот.
 *
 * @package Userstory\CompetingView\hydrators
 */
class ViewArrayHydrator implements HydratorInterface
{
    /**
     * Преобразовать модели в массив для апишки.
     *
     * @param CompetingView[] $models список моделей просмотров.
     *
     * @return array
     */
    public function extractList(array $models)
    {
        $result   = [];
        foreach ($models as $model) {
            if (Yii::$app->user->getIdentity() instanceof UserAuth && null !== $user = Yii::$app->user->findIdentity($model->userId)) {
                $result[] = [
                    'profileId'  => $model->userId,
                    'firstName'  => $user->profile->getFirstName(),
                    'lastName'   => $user->profile->getLastName(),
                    'secondName' => $user->profile->getSecondName(),
                ];
            } else {
                $result[] = [
                    'profileId'  => $model->userId,
                    'firstName'  => 'Unknown',
                    'lastName'   => 'Unknown',
                    'secondName' => '',
                ];
            }
        }
        return $result;
    }

    /**
     * Метод извлекает данные из переданного объекта.
     *
     * @param mixed $object Объект, из которого извлекаются данные.
     *
     * @return mixed
     */
    public function extract($object)
    {
    }

    /**
     * Метод наполняет переданный объект переданными данными.
     *
     * @param mixed $data   Данные для наполнения объекта.
     * @param mixed $object Объект для наполнения.
     *
     * @return mixed
     */
    public function hydrate($data, $object)
    {
    }
}
