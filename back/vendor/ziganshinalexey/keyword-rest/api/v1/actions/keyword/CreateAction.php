<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\api\v1\actions\keyword;

use ReflectionException;
use Userstory\ComponentApiServer\actions\AbstractApiAction;
use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\KeywordRest\traits\keyword\KeywordRestComponentTrait;

/**
 * REST-экшен для создания одного экземпляра сущности "Ключевое фраза".
 */
class CreateAction extends AbstractApiAction
{
    use KeywordRestComponentTrait;

    /**
     * Метод возвращает краткое описание экшена.
     *
     * @return array
     */
    public static function info(): array
    {
        return ['message' => 'REST-метод для создания одного экземпляра сущности "Ключевое фраза"'];
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
        if (! Yii::$app->user->can('Keyword.Keyword.Create')) {
            $this->processAccessError();
            return [];
        }

        $form = $this->getKeywordRestComponent()->getCreateForm();
        $form->load(Yii::$app->request->post());

        if (null === $item = $form->run()) {
            $this->addModelErrors($form->getErrors(), false);
            return [];
        }

        return $this->getFormatter()->format($item);
    }
}
