<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\api\v1\actions\keyword;

use ReflectionException;
use Userstory\ComponentApiServer\actions\AbstractApiAction;
use Userstory\ComponentBase\exceptions\NotFoundException;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\KeywordRest\traits\keyword\KeywordRestComponentTrait;

/**
 * REST-экшен для обновления данных одного экземпляра сущности "Ключевое фраза".
 */
class UpdateAction extends AbstractApiAction
{
    use KeywordRestComponentTrait;

    /**
     * Метод возвращает краткое описание экшена.
     *
     * @return array
     */
    public static function info(): array
    {
        return ['message' => 'REST-экшен для обновления данных одного экземпляра сущности "Ключевое фраза"'];
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
        if (! Yii::$app->user->can('Keyword.Keyword.Update')) {
            $this->processAccessError();
            return [];
        }

        $form = $this->getKeywordRestComponent()->getUpdateForm();
        $form->load(ArrayHelper::merge($routeParams, Yii::$app->request->post()));
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
