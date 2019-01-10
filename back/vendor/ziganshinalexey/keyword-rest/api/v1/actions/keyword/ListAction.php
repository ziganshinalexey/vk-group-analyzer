<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\api\v1\actions\keyword;

use ReflectionException;
use Userstory\ComponentApiServer\actions\AbstractApiAction;
use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\KeywordRest\traits\keyword\KeywordRestComponentTrait;

/**
 * REST-экшен для получения списка данных сущностей "Ключевое фраза".
 */
class ListAction extends AbstractApiAction
{
    use KeywordRestComponentTrait;

    /**
     * Метод возвращает краткое описание экшена.
     *
     * @return array
     */
    public static function info(): array
    {
        return ['message' => 'REST-экшен для получения списка данных сущностей "Ключевое фраза"'];
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
        if (! Yii::$app->user->can('Keyword.Keyword.List')) {
            $this->processAccessError();
            return [];
        }

        $form     = $this->getKeywordRestComponent()->getListForm();
        $filter   = $form->getFilter();
        $hydrator = $this->getKeywordRestComponent()->getFilterHydrator();

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
