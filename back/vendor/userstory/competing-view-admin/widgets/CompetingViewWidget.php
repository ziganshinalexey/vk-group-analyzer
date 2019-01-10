<?php

namespace Userstory\CompetingViewAdmin\widgets;

use yii\base\InvalidParamException;
use yii\base\Widget;

/**
 * Class CompetingViewWidget.
 * Класс виджета для модуля "Конкуретный просмотр".
 *
 * @package Userstory\CompetingViewAdmin\widgets
 */
class CompetingViewWidget extends Widget
{
    /**
     * Имя сущности для слежения.
     *
     * @var string|null
     */
    protected $entity;

    /**
     * Идентификатор сущности для слежения.
     *
     * @var integer|null
     */
    protected $eid;

    /**
     * Дополнительные опции виджета.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Имя представления для рендеринга.
     *
     * @var string
     */
    protected $viewName = 'index';

    /**
     * Метод возвращает имя сущности для слежения.
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Метод задает имя сущности для слежения.
     *
     * @param string $entity Значение для установки.
     *
     * @return static
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * Метод возвращает идентификатор сущности для слежения.
     *
     * @return integer
     */
    public function getEid()
    {
        return $this->eid;
    }

    /**
     * Метод задает идентификатор сущности для слежения.
     *
     * @param integer $eid Значение для установки.
     *
     * @return static
     */
    public function setEid($eid)
    {
        $this->eid = $eid;
        return $this;
    }

    /**
     * Метод возвращает дополнительные опции виджета.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Метод задает дополнительные опции виджета.
     *
     * @param array|mixed $options Значение для установки.
     *
     * @return static
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Метод возвращает имя представления для рендеринга.
     *
     * @return string
     */
    public function getViewName()
    {
        return $this->viewName;
    }

    /**
     * Метод задает имя представления для рендеринга.
     *
     * @param string $viewName Значение для установки.
     *
     * @return static
     */
    public function setViewName($viewName)
    {
        $this->viewName = $viewName;
        return $this;
    }

    /**
     * Метод возвращает путь к представлениям виджета.
     *
     * @return string
     */
    public function getViewPath()
    {
        return parent::getViewPath() . '/CompetingView';
    }

    /**
     * Метод запускает на выполение виджет.
     *
     * @throws InvalidParamException Возможное исключение, в случае передачи неверных параметров при рендеринге.
     *
     * @return void
     */
    public function run()
    {
        $viewName = $this->viewName;

        if (empty ($viewName)) {
            $viewName = 'index';
        }

        $this->render($viewName, [
            'entity'  => $this->entity,
            'eid'     => $this->eid,
            'options' => $this->options,
        ]);
    }
}
