<?php

namespace Userstory\ComponentBase\traits;

use yii\web\Response;

/**
 * Трейт для разделения вызовов преобразований по соответствующим им именам действиям контроллера.
 *
 * @package Userstory\ComponentBase\ModelView
 */
trait MethodByActionTrait
{
    /**
     * Реализация метода, преобразующего данные для рендеринга. Метод осуществляет поиск действия в реализации класса.
     *
     * @param mixed $data сырые, входные данные от контроллера.
     *
     * @return mixed
     */
    public function getViewData($data)
    {
        $actionIdArray = explode('/', $this->action->getUniqueId());
        $action        = array_pop($actionIdArray);
        $action        = $this->getActionName($action);
        if (method_exists($this, $action)) {
            return $this->{$action}($data);
        }

        return $this->getDefaultData($data);
    }

    /**
     * Реализация метода, преобразующего данные для JSON данных. Метод осуществляет поиск действия в реализации класса.
     *
     * @param mixed  $data     сырые, входные данные от контроллера.
     * @param string $jsonType запрашиваемый тип JSON данных.
     *
     * @return mixed
     */
    public function getJsonData($data, $jsonType = Response::FORMAT_JSON)
    {
        $actionIdArray = explode('/', $this->action->getUniqueId());
        $action        = array_pop($actionIdArray);
        if (method_exists($this, $method = $this->getActionName($action . '-json'))) {
            return $this->{$method}($data, $jsonType);
        } elseif (method_exists($this, $method = $this->getActionName($action))) {
            return $this->{$method}($data);
        }

        return $this->getDefaultDataJson($data);
    }

    /**
     * Преобразует действие index-json в indexJson.
     *
     * @param string $action входящее имя текущего действия.
     *
     * @return string
     */
    protected function getActionName($action)
    {
        return lcfirst(implode('', array_map('ucfirst', array_map('strtolower', preg_split('/\W/', $action)))));
    }

    /**
     * Метод преобразования данных, используемый по умолчанию.
     *
     * @param mixed $data сырые, входные данные от контроллера.
     *
     * @return mixed
     */
    protected function getDefaultData($data)
    {
        return $data;
    }

    /**
     * Метод преобразования данных в JSON формат, используемый по умолчанию.
     *
     * @param mixed $data сырые, входные данные от контроллера.
     *
     * @return mixed
     */
    protected function getDefaultDataJson($data)
    {
        return $data;
    }
}
