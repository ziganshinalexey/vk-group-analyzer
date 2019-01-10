<?php

namespace Userstory\ModuleAdmin\widgets;

use yii;
use yii\bootstrap\Widget;

/**
 * Класс виджета для отображения алертов и мессаг.
 *
 * Alert widget renders a message from session flash for AdminLTE alerts. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * \Yii::$app->getSession()->setFlash('error', '<b>Alert!</b> Danger alert preview. This alert is dismissable.');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * \Yii::$app->getSession()->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * author Evgeniy Tkachenko <et.coder@gmail.com>
 */
class Alert extends Widget
{
    /**
     * Длительность в секундах отображения сообщения типа.
     * 0 - будет отображаться до тех пор, пока оно есть в сессии.
     *
     * @var integer|array
     */
    protected $duration = 0;

    /**
     * Массив опция для кнопки закрытия.
     *
     * @var array
     */
    public $closeButton = [];

    /**
     * Массив типов сообщений (отображаются по разному).
     *
     * @var array
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the array:
     *       - class of alert type (i.e. danger, success, info, warning)
     *       - icon for alert AdminLTE
     */
    public $alertTypes = [
        'error'   => [
            'class' => 'alert-danger',
            'icon'  => '<i class="icon fa fa-ban"></i>',
        ],
        'danger'  => [
            'class' => 'alert-danger',
            'icon'  => '<i class="icon fa fa-ban"></i>',
        ],
        'success' => [
            'class' => 'alert-success',
            'icon'  => '<i class="icon fa fa-check"></i>',
        ],
        'info'    => [
            'class' => 'alert-info',
            'icon'  => '<i class="icon fa fa-info"></i>',
        ],
        'warning' => [
            'class' => 'alert-warning',
            'icon'  => '<i class="icon fa fa-warning"></i>',
        ],
    ];

    /**
     * Сеттер параметра "длительность отображения алерта".
     *
     * @param integer|array $param Длительность отображения в секундах или массив вида ['success' => 20, 'info' => 10].
     *
     * @return void
     */
    public function setDuration($param)
    {
        $this->duration = $param;
    }

    /**
     * Инициализация виджета для отображения мессаги.
     *
     * Initializes the widget.
     * This method will register the bootstrap asset bundle. If you override this method,
     * make sure you call the parent implementation first.
     *
     * @throws \Exception Наследуется из базового виджета.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        $widget    = $this->getAlertWidget();
        $session   = Yii::$app->getSession();
        $flashes   = $session->getAllFlashes();
        $appendCss = isset($this->options['class']) ? ' ' . $this->options['class'] : '';
        $view      = $this->getView();
        $begin     = 'jQuery(document).ready(function () {';
        $end       = '});';
        $js        = '';
        foreach ($flashes as $type => $data) {
            if (isset($this->alertTypes[$type])) {
                $data = (array)$data;

                $this->options['class'] = $this->alertTypes[$type]['class'] . $appendCss;
                $this->options['id']    = $this->getId() . '-' . $type;

                foreach ($data as $message) {
                    echo $widget::widget([
                        'body'        => $this->alertTypes[$type]['icon'] . $message,
                        'closeButton' => $this->closeButton,
                        'options'     => $this->options,
                    ]);
                }
                $js .= $this->setAlertDuration($type);
                $session->removeFlash($type);
            }
        }
        if ('' !== $js) {
            $js = $begin . ' ' . $js . ' ' . $end;
            $view->registerJs($js);
        }
    }

    /**
     * Возвращает имя класса виджета для отображения.
     *
     * @return string
     */
    protected function getAlertWidget()
    {
        return BootstrapAlert::class;
    }

    /**
     * Генерируем кусок js для длительности вывода алерта.
     *
     * @param string $type тип алерта.
     *
     * @return string
     */
    protected function setAlertDuration($type)
    {
        if (0 === $this->duration) {
            return '';
        }
        if (is_int($this->duration) && ( $this->duration > 0 )) {
            return 'setTimeout(function() {
                    jQuery(\'.' . $this->alertTypes[$type]['class'] . ' .close\').trigger(\'click\'); }, ' . $this->duration * 1000 . "); \n";
        }
        if (is_array($this->duration) && array_key_exists($type, $this->duration)) {
            if (is_int($this->duration[$type]) && ( $this->duration[$type] > 0 )) {
                return 'setTimeout(function() {
                    jQuery(\'.' . $this->alertTypes[$type]['class'] . ' .close\').trigger(\'click\'); }, ' . $this->duration[$type] * 1000 . "); \n";
            }
        }
        return '';
    }
}
