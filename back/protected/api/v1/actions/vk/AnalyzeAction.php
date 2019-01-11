<?php

declare(strict_types = 1);

namespace app\api\v1\actions\vk;

use Userstory\ComponentApiServer\actions\AbstractApiAction;

/**
 * Класс AnalyzeAction Реализующий апи действие.
 */
class AnalyzeAction extends AbstractApiAction
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
     */
    public function run(array $routeParams = [], array $queryParams = []): array
    {
        return [];
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
