<?php

declare(strict_types = 1);

namespace app\api\v1\actions\vk;

use app\api\v1\forms\vk\AccessTokenForm;
use Userstory\ComponentApiServer\actions\AbstractApiAction;
use yii;
use yii\base\InvalidConfigException;
use yii\httpclient\Exception;

/**
 * Класс AnalyzeAction Реализующий апи действие.
 */
class AccessTokenAction extends AbstractApiAction
{
    /**
     * Метод выполняет действие экшена.
     *
     * @param array $routeParams Параметры из роута запроса.
     * @param array $queryParams Параметры из запроса.
     *
     * @inherit
     *
     * @return array
     *
     * @throws InvalidConfigException Если форматтер не указан.
     * @throws Exception
     */
    public function run(array $routeParams = [], array $queryParams = []): array
    {
        $form = new AccessTokenForm();
        $form->load(Yii::$app->request->post(), '');

        if (null === $data = $form->run()) {
            $this->addModelErrors($form->getErrors(), true);
            return [];
        }

        return $data;
    }

    /**
     * Метод возвращает краткое описание экшена.
     *
     * @return array
     */
    public static function info(): array
    {
        return ['message' => 'REST-метод для анализирования пользователя на тип личности'];
    }
}
