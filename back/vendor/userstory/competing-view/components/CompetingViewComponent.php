<?php

namespace Userstory\CompetingView\components;

use Userstory\CompetingView\entities\CompetingView;
use Userstory\CompetingView\hydrators\ViewArrayHydrator;
use Userstory\CompetingView\queries\CompetingViewQuery;
use Userstory\ModuleUser\entities\UserAuth;
use yii;
use yii\base\Component;
use Userstory\ModuleUser\web\USUser as User;

/**
 * Класс компонента для доступа к модулю.
 *
 * @property integer $id         Идентфикатор записи
 * @property integer $entityName Имя сущности
 * @property integer $entityId   Идентификатор сущности
 * @property integer $userId     Идентификатор пользователя
 * @property integer $viewDate   Время просмотра
 *
 * @package Userstory\CompetingView\components
 */
class CompetingViewComponent extends Component
{
    /**
     * Список моделей, с которыми работает текущий компонент.
     *
     * @var array
     */
    public $modelClasses = [];

    /**
     * Список поддерживаемых сущностей.
     *
     * @var array
     */
    public $allowedEntities = [];

    /**
     * Таймаут активности в течении которого считаем просматривающего актуальным(в секундах).
     *
     * @var integer
     */
    public $viewDelay = 60;

    /**
     * URL для обращения клиента о запросе активности.
     *
     * @var string
     */
    public $viewUrl = '/compview';

    /**
     * Метод возвращает модель построителя запросов.
     *
     * @return CompetingViewQuery
     */
    protected function getQuery()
    {
        return new $this->modelClasses['query']($this->modelClasses['main']);
    }

    /**
     * Метод возвращает модель гидратора для API.
     *
     * @return ViewArrayHydrator
     */
    protected function getHydrator()
    {
        return new $this->modelClasses['hydrator']();
    }

    /**
     * Очистка таблицы просмотров от старых записей.
     *
     * @return integer Возвращает количество удаленных записей.
     */
    public function clearOldViews()
    {
        $delay = $this->viewDelay;
        return $this->getQuery()->deleteOlder($delay);
    }

    /**
     * Сокращенное создание записи о просмотре.
     *
     * @param string $entityName Наименование сущности.
     * @param mixed  $entityId   Идентификатор конкретной сущности.
     *
     * @return boolean
     */
    public function saveView($entityName, $entityId)
    {
        if (! in_array($entityName, $this->allowedEntities, true)) {
            return false;
        }
        $userId = $this->getUserId();
        $view   = $this->getQuery()->filterByEntity($entityName, $entityId)->filterByUser($userId)->one();
        if (null === $view) {
            $view             = new CompetingView();
            $view->entityName = $entityName;
            $view->entityId   = $entityId ? : '';
            $view->userId     = $userId;
        }
        $view->viewDate = time();
        return $view->save();
    }

    /**
     * Получить объекты записей с информацией о просмотре сущности.
     *
     * @param string  $entName наименование сущности.
     * @param integer $entId   Идентификатор конкретной сущности.
     *
     * @return CompetingView[]
     */
    public function getView($entName, $entId)
    {
        return $this->getQuery()->filterByEntity($entName, $entId)->filterByNotUser($this->getUserId())->filterByDelay($this->viewDelay)->all();
    }

    /**
     * Проверить просматривают ли сущность другие пользователи.
     *
     * @param string  $entName наименование сущности.
     * @param integer $entId   Идентификатор конкретной сущности.
     *
     * @return boolean
     */
    public function hasView($entName, $entId)
    {
        return $this->getQuery()->filterByEntity($entName, $entId)->filterByNotUser($this->getUserId())->filterByDelay($this->viewDelay)->exists();
    }

    /**
     * Возвращает ИД текущего пользователя.
     *
     * @return integer|null
     */
    protected function getUserId()
    {
        if (Yii::$app->user->isGuest) {
            return null;
        }
        return Yii::$app->user->getIdentity()->getId();
    }

    /**
     * Поиск и выдача записей о просмотре указанной сущности, но другими пользователями.
     *
     * @param string $entityName Наименование сущности.
     * @param string $entityId   Идентификатор сущности.
     *
     * @return CompetingView[]|array
     *
     * @deprecated использовать getView
     */
    public function findByEntityAndAnotherUser($entityName, $entityId)
    {
        $delay  = $this->viewDelay;
        $userId = $this->getUserId();

        $records = $this->getQuery()->filterByEntity($entityName, $entityId)->filterByNotUser($userId)->filterByDelay($delay)->all();

        $result = [];
        foreach ($records as $record) {
            if (isset($result[$record->userId]) && $result[$record->userId]['record']->viewDate > $record->viewDate) {
                continue;
            }

            $result[$record->userId] = [
                'record'   => $record,
                'username' => null,
            ];
        }

        foreach ($result as $key => $record) {
            $result[$key]['username'] = 'Unknown';

           $identity = Yii::$app->user->getIdentity();
            if ($identity instanceof UserAuth && null !== $user = $identity->findIdentity($record['record']->userId)) {
                /* @var $user UserAuth */
                $profile = $user->profile;
                if (null !== $profile) {
                    $result[$key]['username'] = $profile->getFirstName() . ' ' . $profile->getSecondName() . ' ' . $profile->getLastName();
                }
            }
        }
        return $result;
    }
}
