<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\api\v1\actions\personType;

use ReflectionException;
use Userstory\ComponentApiServer\actions\AbstractApiAction;
use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonTypeRest\traits\personType\PersonTypeRestComponentTrait;

/**
 * REST-экшен для получения списка данных сущностей "Тип личности".
 */
class ListAction extends AbstractApiAction
{
    use PersonTypeRestComponentTrait;

    /**
     * Метод возвращает краткое описание экшена.
     *
     * @return array
     */
    public static function info(): array
    {
        return ['message' => 'REST-экшен для получения списка данных сущностей "Тип личности"'];
    }

    /**
     * Метод выполняет действие экшена.
     *
     * @param array $routeParams Параметры из роута запроса.
     * @param array $queryParams Параметры из запроса.
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     * @throws ReflectionException    Генерирует, если класс отсутствует.
     *
     * @inherit
     *
     * @return array
     */
    public function run(array $routeParams = [], array $queryParams = []): array
    {
        if (! Yii::$app->user->can('PersonType.PersonType.List')) {
            $this->processAccessError();
            return [];
        }

        $form     = $this->getPersonTypeRestComponent()->getListForm();
        $filter   = $form->getFilter();
        $hydrator = $this->getPersonTypeRestComponent()->getFilterHydrator();

        $hydrator->hydrate(Yii::$app->request->post(), $filter);
        if (null === $list = $form->run()) {
            $this->addModelErrors($form->getErrors(), false);
            return [];
        }

        return [
            'list' => $this->getFormatter()->format($list),
            'more' => $form->getMore(),
        ];
    }
}
