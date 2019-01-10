<?php

namespace Userstory\ComponentBase\ModelView;

use yii\web\Response;

/**
 * Преобразователь данных, используемых по умолчанию.
 *
 * @deprecated
 */
final class DefaultView extends AbstractModelView
{
    /**
     * Реализация метода, преобразующего данные для рендеринга. Метод осуществляет поиск действия в реализации класса.
     *
     * @param mixed $data сырые, входные данные от контроллера.
     *
     * @deprecated
     *
     * @return mixed
     */
    public function getViewData($data)
    {
        return $data;
    }

    /**
     * Реализация метода, преобразующего данные для JSON данных. Метод осуществляет поиск действия в реализации класса.
     *
     * @param mixed  $data     сырые, входные данные от контроллера.
     * @param string $jsonType запрашиваемый тип JSON данных.
     *
     * @inherit
     *
     * @deprecated
     *
     * @return mixed
     */
    public function getJsonData($data, $jsonType = Response::FORMAT_JSON)
    {
        return $data;
    }
}
