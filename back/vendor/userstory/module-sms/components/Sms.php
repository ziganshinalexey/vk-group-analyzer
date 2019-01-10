<?php

namespace Userstory\ModuleSms\components;

use Userstory\ModuleSms\models\AbstractProvider;
use Userstory\ModuleSms\models\Debug;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\UnknownMethodException;
use yii;

/**
 * Class Sms.
 * Компонент для отправки сообщения на телефон.
 *
 * @package Userstory\ModuleUser\components
 */
class Sms extends Component
{
    /**
     * Конфигурация провайдера который предаставляет шлюз.
     *
     * @var null|array
     */
    protected $provider;

    /**
     * Включить режим отладки, подключается провайдер дебаг.
     *
     * @var boolean
     */
    protected $debug = false;

    /**
     * Инициализированный объект провайдера.
     *
     * @var null|AbstractProvider
     */
    protected $object;

    /**
     * Указать статус режима отладки.
     *
     * @param boolean $value статус вкл./выкл.
     *
     * @return void
     */
    public function setDebug($value)
    {
        $this->debug = $value;
    }

    /**
     * Получить статус режима отладки.
     *
     * @return boolean
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * Получить конфигурацию провайдера.
     *
     * @return array|null
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Указать конфигурацию провайдера.
     *
     * @param array $value конфигурация.
     *
     * @return void
     */
    public function setProvider(array $value)
    {
        $this->provider = $value;
    }

    /**
     * Инициализация компонента.
     *
     * @return void
     * @throws InvalidConfigException если конфигурация объекта логирования некорректна.
     */
    public function init()
    {
        parent::init();
        $this->object = $this->debug || null === $this->provider ? Yii::createObject(Debug::class) : Yii::createObject($this->provider);
    }

    /**
     * Магически метод, обращаемся к методам провайдера.
     *
     * @param string $name   название метода для обращения.
     * @param mixed  $params передаваемые параметры.
     *
     * @return mixed
     *
     * @throws UnknownMethodException метод не найден в классе.
     */
    public function __call($name, $params)
    {
        if (method_exists($this->object, $name)) {
            return call_user_func_array([
                $this->object,
                $name,
            ], $params);
        }
        throw new UnknownMethodException('Calling unknown method: ' . get_class($this->object) . '::' . $name . '()');
    }
}
