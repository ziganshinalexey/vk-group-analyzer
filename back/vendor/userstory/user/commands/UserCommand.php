<?php

namespace Userstory\User\commands;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\User\components\UserComponent;
use yii;
use yii\base\InvalidConfigException;
use yii\console\Controller;

/**
 * Class UserCommand.
 * Консольная утилита для рыботы с профилями пользователей.
 *
 * @package Userstory\User\commands
 */
class UserCommand extends Controller
{
    /**
     * Задаёт интревал времени, после которого проводить очистку.
     *
     * @var string|integer
     */
    protected $timeframe = - 1;

    /**
     * Метод задает интревал времени, после которого проводить очистку.
     *
     * @param integer|string $timeframe Значение для установки.
     *
     * @return static
     */
    public function setTimeframe($timeframe)
    {
        $this->timeframe = $timeframe;
        return $this;
    }

    /**
     * Возвращает массив аргументов комманды.
     *
     * @param string $actionID Идентификатор экшена.
     *
     * @return array
     */
    public function options($actionID)
    {
        if ('CaptchaClean' === $actionID) {
            return ArrayHelper::merge(['timeframe'], parent::options($actionID));
        }

        return parent::options($actionID);
    }

    /**
     * Возвращает массив привязок аргументов.
     * Не работает в yii <= 2.0.7.
     *
     * @return array
     */
    public function optionAliases()
    {
        return [
            'tf' => 'timeFrame',
        ];
    }

    /**
     * Очищает не актуальную часть таблицы для капчи.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     *
     * @return integer
     */
    public function actionCaptchaClean()
    {
        $tf     = $this->timeframe;
        $config = $this->getCaptchaConfig();

        if ($tf < 0) {
            $tf = $config['timeFrame'];
        }

        echo 'Database component name: ', $config['db'], PHP_EOL;
        $db = Yii::$app->get($config['db']);

        if (! $db) {
            return 0;
        }

        echo 'Captcha table name: ', $config['tableName'], PHP_EOL;
        $tb = time() - $tf;

        echo 'Time frame: ', $tf, ' sec (', $tb, ')', PHP_EOL;

        if (null === $db->schema->getTableSchema($config['tableName'])) {
            echo 'Table ', $config['tableName'], 'not found. Exiting...', PHP_EOL;
            return 0;
        }

        if (! $this->confirm('Do you really want to clear table?')) {
            return 0;
        }

        $count = $db->createCommand()->delete($config['tableName'], [
            '<',
            'time',
            $tb,
        ])->execute();

        echo PHP_EOL, 'Total row deleted: ', $count, PHP_EOL;

        return 0;
    }

    /**
     * Очистка таблицы для капчи.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     *
     * @return integer
     */
    public function actionCaptchaReset()
    {
        $config = $this->getCaptchaConfig();

        echo 'Database component name: ', $config['db'], PHP_EOL;
        $db = Yii::$app->get($config['db']);

        if (! $db) {
            return 0;
        }

        echo 'Captcha table name: ', $config['tableName'], PHP_EOL;

        if (null === $db->schema->getTableSchema($config['tableName'])) {
            echo 'Table ', $config['tableName'], 'not found. Exiting...', PHP_EOL;
            return 0;
        }

        if (! $this->confirm('Do you really want to reset table?')) {
            return 0;
        }

        $db->createCommand()->truncateTable($config['tableName']);

        echo 'All done!..', PHP_EOL;

        return 0;
    }

    /**
     * Метод возвращает конфигурацию капчи.
     *
     * @return array
     */
    protected function getCaptchaConfig()
    {
        /* @var UserComponent $component */
        $component = Yii::$app->userBase;
        return $component->getCaptchaConfig();
    }
}
