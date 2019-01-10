<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\api\v1\actions\personType;

use ReflectionException;
use Userstory\ComponentApiServer\actions\AbstractApiAction;
use Userstory\ComponentBase\exceptions\NotFoundException;
use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonTypeRest\traits\personType\PersonTypeRestComponentTrait;

/**
 * REST-экшен для получения данных одного экземпляра сущности "Тип личности".
 */
class ViewAction extends AbstractApiAction
{
    use PersonTypeRestComponentTrait;

    /**
     * Метод возвращает краткое описание экшена.
     *
     * @return array
     */
    public static function info(): array
    {
        return ['message' => 'REST-экшен для получения данных одного экземпляра сущности "Тип личности"'];
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
        if (! Yii::$app->user->can('PersonType.PersonType.View')) {
            $this->processAccessError();
            return [];
        }

        $form = $this->getPersonTypeRestComponent()->getViewForm();
        $form->load($routeParams, '');

        try {
            if (null === $item = $form->run()) {
                $this->addModelErrors($form->getErrors(), false);
                return [];
            }
        } catch (NotFoundException $exception) {
            return $this->processNotFoundError();
        }

        return $this->getFormatter()->format($item);
    }
}
