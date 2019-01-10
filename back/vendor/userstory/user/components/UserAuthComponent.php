<?php

namespace Userstory\User\components;

use Userstory\User\entities\UserAuthActiveRecord;
use Userstory\User\queries\UserAuthQuery;
use yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Управление запросами модели UserAuth.
 *
 * @package Userstory\User\components
 */
class UserAuthComponent extends Component
{
    const USER_AUTH_MODEL_KEY = 'model';
    const USER_AUTH_QUERY_KEY = 'query';

    /**
     * Список связанных классов, с которыми работает текущий компонент.
     *
     * @var array
     */
    protected $modelClasses = [];

    /**
     * Получаем объект построителя запросов.
     *
     * @return UserAuthQuery|mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-запроса.
     */
    protected function getQuery()
    {
        return Yii::createObject($this->modelClasses[self::USER_AUTH_QUERY_KEY], [$this->modelClasses[self::USER_AUTH_MODEL_KEY]]);
    }

    /**
     * Устанавливаем значение для атрибута.
     *
     * @param array $value значение для атрибута.
     *
     * @return static
     */
    public function setModelClasses(array $value)
    {
        $this->modelClasses = $value;
        return $this;
    }

    /**
     * Находим пользователя по ид.
     *
     * @param integer $id Идентификатор пользователя.
     *
     * @return UserAuthActiveRecord|mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-запроса.
     */
    public function getById($id)
    {
        return $this->getQuery()->byId($id)->one();
    }

    /**
     * Находим пользователя по логину.
     *
     * @param string $login Логин пользователя.
     *
     * @return UserAuthActiveRecord|mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-запроса.
     */
    public function getByLogin($login)
    {
        return $this->getQuery()->byLogin($login)->one();
    }

    /**
     * Метод возвращает список пользователей логин которых совпадает с искомым.
     *
     * @param string $login Логин для поиска.
     *
     * @return UserAuthActiveRecord[]
     */
    public function getUserList($login)
    {
        return $this->getQuery()->bySameLogin($login)->with('profile')->all();
    }
}
