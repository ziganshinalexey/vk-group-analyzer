<?php

namespace Userstory\ComponentBase\interfaces;

use yii\base\Action;
use yii\web\Response;

/**
 * Интерфейс, определяющий методе преобразования данных.
 *
 * @package Userstory\ComponentBase\ModelView
 */
interface ModelViewInterface
{
    /**
     * Преобразовывает входные данные в данные, воспринимаемые вьюшками.
     *
     * @param mixed $data данные для преобразования.
     *
     * @return mixed
     */
    public function getViewData($data);

    /**
     * Преобразование данных в JSON строку.
     *
     * @param mixed  $data     данные для преобразования.
     * @param string $jsonType тип JSON данных.
     *
     * @return string
     */
    public function getJsonData($data, $jsonType = Response::FORMAT_JSON);

    /**
     * Определение вызванного действия.
     *
     * @param Action $action текущее действие контроллера.
     *
     * @return mixed
     */
    public function setAction(Action $action);
}
