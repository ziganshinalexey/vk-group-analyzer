<?php

namespace Userstory\ComponentApiServer\behaviors;

use Userstory\ComponentApiServer\components\ApiServerComponent;
use Userstory\ComponentBase\validators\IpValidator;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use yii;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\web\ForbiddenHttpException;

/**
 * Class IpLimiterBehavior.
 * Класс поведения для реализации логики проверки доступа по IP адресу.
 *
 * @package Userstory\ComponentApiServer\behaviors
 */
class IpLimiterBehavior extends Behavior
{
    /**
     * Список IP адресов для сравнения.
     * Может быть задан как в формате ['192.168.0.1', ...], так и в формате правила (списка правил) валидатора (@see IpValidator).
     * Каждое значение из этого списка будет проверено последовательно. Если текущий IP в итоге не проходит проверку - доступ запрещается.
     *
     * @var array
     */
    protected $ips = [];

    /**
     * Включить ли фильтр по IP адресам.
     *
     * @var boolean
     */
    protected $enableIPRestriction = false;

    /**
     * Метод задает проверку фильтра по IP адресам.
     *
     * @param boolean $isEnabled Включить ли проверку.
     *
     * @return static
     */
    public function setEnableIPRestriction($isEnabled)
    {
        $this->enableIPRestriction = $isEnabled;
        return $this;
    }

    /**
     * Метод возвращает надо ли проводить проверку фильтра по IP адресам.
     *
     * @return boolean
     */
    public function getEnableIPRestriction()
    {
        return $this->enableIPRestriction;
    }

    /**
     * Сеттер задает список IP адресов.
     *
     * @param array $ips Список для установки.
     *
     * @return static
     */
    public function setIps(array $ips)
    {
        $this->ips = $ips;
        return $this;
    }

    /**
     * Метод возвращает обработчики на родительские события.
     *
     * @return array
     */
    public function events()
    {
        return ArrayHelper::merge(parent::events(), [
            ApiServerComponent::EVENT_API_BEFORE_ACTION => 'allowIp',
        ]);
    }

    /**
     * Метод обрабатывает событие api запроса: проверяет доступ по IP.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     * @throws ForbiddenHttpException Исключение, если доступ текущему IP запрещен.
     *
     * @return void
     */
    public function allowIp()
    {
        if (empty($this->ips) || ! $this->isEnabledCheck()) {
            return;
        }

        $ip        = Yii::$app->request->userIP;
        $isGranted = false;

        foreach ($this->ips as $ipRule) {
            if (is_string($ipRule)) {
                $params = [
                    'ipv6'   => false,
                    'ranges' => [$ipRule],
                ];
            } elseif (is_array($ipRule)) {
                $params = $ipRule;
            }

            if (empty($params)) {
                continue;
            }

            $validator = $this->getValidator($params);

            if ($validator->validate($ip)) {
                $isGranted = true;
                break;
            }
        }

        if (! $isGranted) {
            throw new ForbiddenHttpException('Forbidden IP access');
        }
    }

    /**
     * Метод возвращает объект валидатора.
     *
     * @param array $params Параметры валидатора.
     *
     * @throws InvalidConfigException Если что-то сконфигурировано неверно.
     *
     * @return IpValidator|mixed
     */
    protected function getValidator(array $params)
    {
        $config = ArrayHelper::merge(['class' => IpValidator::class], $params);
        return Yii::createObject($config);
    }

    /**
     * Метод проверяет включена ли проверка.
     *
     * @return boolean
     */
    protected function isEnabledCheck()
    {
        /* @var ApiServerComponent $apiServer */
        $apiServer         = Yii::$app->apiServer;
        $globalRestriction = $this->enableIPRestriction;

        if (null === $apiServer->action) {
            return $globalRestriction;
        }

        $actionRestriction = $apiServer->action->enableIPRestriction;

        return ( true === $actionRestriction ) || ( null === $actionRestriction && $globalRestriction );
    }
}
