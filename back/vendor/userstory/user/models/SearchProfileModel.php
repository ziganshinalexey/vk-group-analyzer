<?php

namespace Userstory\User\models;

use yii\base\Model;
use Userstory\User\entities\UserProfileActiveRecord;
use Userstory\User\queries\UserProfileQuery;
use yii;
use yii\base\InvalidCallException;
use yii\db\ActiveQuery;
use function ctype_digit;
use function is_array;
use function is_int;

/**
 * Class SearchProfileModel.
 * Модель формирования выборки поиска пользователя.
 *
 * @package Userstory\User\models
 */
class SearchProfileModel extends Model
{
    /**
     * Построитель запроса для профиля пользователя.
     *
     * @var UserProfileQuery|null
     */
    protected $userProfileQuery;

    /**
     * Свойство класса, содержащее поисковый запрос.
     *
     * @var string|null
     */
    protected $q;

    /**
     * Ммассив индификаторов для исключения из выборки.
     *
     * @var array|null
     */
    protected $notIds;

    /**
     * Свойство класса, содержащее "страницу" выборки.
     *
     * @var integer|null
     */
    protected $page;

    /**
     * Ограничение единичной выборки.
     *
     * @var integer
     */
    protected $limit = 20;

    /**
     * Свойство хранит список идентификаторов профилей.
     *
     * @var array
     */
    protected $idList = [];

    /**
     * Свойство хранит флаг полноты записей в ответе.
     *
     * @var boolean|null
     */
    protected $more;

    /**
     * Метод возвращает флаг полноты записей в ответе.
     *
     * @return boolean
     *
     * @throws InvalidCallException Генерирует при преждевременном вызове метода.
     */
    public function getMore(): bool
    {
        if (null === $this->more) {
            throw new InvalidCallException(__METHOD__ . '() Метод необходимо вызывать после метода search().');
        }
        return (bool)$this->more;
    }

    /**
     * Метод получает список идентификаторов профилей.
     *
     * @return array|null
     */
    public function getIdList()
    {
        return $this->idList;
    }

    /**
     * Указать список идентификаторов для исключения из выборки.
     *
     * @param array $value массив идентификаторов.
     *
     * @return static
     */
    public function setNotIds(array $value)
    {
        $this->notIds = $value;
        return $this;
    }

    /**
     * Получить список идентификаторов для исключения из выборки.
     *
     * @return array|null
     */
    public function getNotIds()
    {
        return $this->notIds;
    }

    /**
     * Указать построитель запросов.
     *
     * @param ActiveQuery $query класс построителя запроса.
     *
     * @return static
     */
    public function setUserProfileQuery(ActiveQuery $query)
    {
        $this->userProfileQuery = $query;
        return $this;
    }

    /**
     * Метод определяющий правила валидации формы.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                ['page'],
                'filter',
                'filter' => function($value) {
                    $value = (int)preg_replace('/\D/', '', $value);
                    return $value > 0 ? $value : 1;
                },
            ],

            [
                ['q'],
                'string',
                'min'      => 3,
                'tooShort' => 'Поисковая строка должна быть минимум 3 символа.',
            ],
            [
                [
                    'q',
                    'page',
                    'notIds',
                ],
                'safe',
            ],
            [
                'limit',
                'integer',
            ],
            [
                'idList',
                'customIdListValidate',
            ],
        ];
    }

    /**
     * Метод кастомной валидации списка идентификаторов.
     *
     * @param string $attribute Название атрибута.
     *
     * @return void
     */
    public function customIdListValidate($attribute): void
    {
        if (empty($this->$attribute)) {
            return;
        }
        if (! is_array($this->$attribute)) {
            $this->addError($attribute, 'Значение списка идентификаторов задано неверно.');
            return;
        }
        foreach ($this->$attribute as $value) {
            if (! is_int($value) && ! ctype_digit($value)) {
                $this->addError($attribute, 'Значение списка идентификаторов задано неверно.');
                return;
            }
        }
    }

    /**
     * Метод класса, определяющий названия параметров.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'q'    => Yii::t('User.SearchProfileModel', 'q', 'Поисковый запрос'),
            'page' => Yii::t('User.SearchProfileModel', 'q', 'Страница'),
        ];
    }

    /**
     * Метод определяет имя формы как пустое.
     *
     * @return string
     */
    public function formName()
    {
        return '';
    }

    /**
     * Возвращает массив найденных и упорядоченных сотрудников.
     *
     * @return UserProfileActiveRecord[]|null
     */
    public function search()
    {
        if (! $this->validate()) {
            return false;
        }

        $query = $this->userProfileQuery->byLikeFIO($this->q);
        if (! empty($this->notIds)) {
            $query->byNotIds($this->notIds);
        }

        if (is_array($this->getIdList()) && ! empty($this->getIdList())) {
            $query->byIdList($this->getIdList());
        }

        $list = $query->orderBy(['firstName' => SORT_ASC])->limit($this->getLimit() + 1)->offset($this->getLimit() * ($this->getPage() - 1))->all();

        if ($this->getLimit() && count($list) > $this->getLimit()) {
            $this->more = true;
            array_pop($list);
        } else {
            $this->more = false;
        }

        return $list;
    }

    /**
     * Геттер для свойства класса, содержащего поисковый запрос.
     *
     * @return string
     */
    public function getQ()
    {
        return $this->q;
    }

    /**
     * Сеттер для свойства класса, содержащего поисковый запрос.
     *
     * @param string $q Поисковый запрос.
     *
     * @return static
     */
    public function setQ($q)
    {
        $this->q = $q;
        return $this;
    }

    /**
     * Геттер для свойства класса, содержащего "страницу" выборки.
     *
     * @return integer
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Сеттер для свойства класса, содержащего "страницу" выборки.
     *
     * @param integer $page Страница выборки.
     *
     * @return static
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * Геттер для ограничения выборки.
     *
     * @return integer
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Сеттер для ограничения выборки.
     *
     * @param integer $limit Колическто строк в выборке.
     *
     * @return static
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }
}
