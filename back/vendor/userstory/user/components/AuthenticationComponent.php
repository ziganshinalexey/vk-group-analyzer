<?php

namespace Userstory\User\components;

use RuntimeException;
use SplPriorityQueue;
use Userstory\User\entities\UserAuthActiveRecord;
use Userstory\User\entities\UserProfileActiveRecord;
use Userstory\User\interfaces\AdapterInterface;
use Userstory\User\interfaces\UserInterface;
use Userstory\User\models\DefaultAdapterModel;
use Userstory\User\models\ResultModel;
use yii;
use yii\base\BaseObject;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;

/**
 * Class AuthenticationService.
 * Сервис для проведения аутентификации пользователя.
 *
 * @package Userstory\User\components
 */
class AuthenticationComponent extends BaseObject
{
    /**
     * Имя класса, используемого сервисом в качестве профиля.
     *
     * @var string
     */
    protected $userProfileClass = UserProfileActiveRecord::class;

    /**
     * Логин пользователя для проведения аутентификации.
     *
     * @var string|null
     */
    protected $identity;

    /**
     * Пароль пользователя для проведения аутентификации.
     *
     * @var string|null
     */
    protected $credential;

    /**
     * Массив конфигураций адаптеров аутентификации.
     *
     * @var array
     */
    protected $adapters = ['default' => DefaultAdapterModel::class];

    /**
     * Приоритетная очередь адаптеров аутентификации.
     *
     * @var SplPriorityQueue|null
     */
    protected $queueAdapters;

    /**
     * Список инициализированных адаптеров.
     *
     * @var AdapterInterface[]
     */
    protected $adapterMap = [];

    /**
     * Переопределение класс конструктора для инициализации свойств класса.
     *
     * @param array $config параметры конфигурации компонента.
     */
    public function __construct(array $config = [])
    {
        $this->queueAdapters = new SplPriorityQueue();
        parent::__construct($config);
    }

    /**
     * Метод устанавливающий логин пользователя для проведения аутентификации.
     *
     * @param string $identity логин пользователя.
     *
     * @return AuthenticationComponent
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }

    /**
     * Метод устанавливающий пароля пользователя для последующей аутентификации.
     *
     * @param string $credential пароль для аутентификации.
     *
     * @return AuthenticationComponent
     */
    public function setCredential($credential)
    {
        $this->credential = $credential;
        return $this;
    }

    /**
     * Вычисляет хэш указанного пароля и проверяет совпадение.
     *
     * @param string $password     проверяемый пароль.
     * @param string $passwordHash хэш пароля.
     *
     * @throws InvalidParamException Генерируется если логин/пароль не верны.
     *
     * @return boolean
     */
    public function validatePassword($password, $passwordHash)
    {
        return Yii::$app->security->validatePassword($password, $passwordHash);
    }

    /**
     * Обновление хэша пароля в базе данных для случая, когда алгоритм или сложность пароля изменена в конфигурации.
     *
     * @param UserAuthActiveRecord $user пользователь, хэш пароля которого следует проверить на соответствии алгорита и сложности хэширования.
     *
     * @throws Exception Исключение в случае ошибки вычисления хэша.
     *
     * @return void
     */
    public function updatePasswordHash(UserAuthActiveRecord $user)
    {
        $hash = explode('$', $user->passwordHash);

        if (Yii::$app->security->passwordHashCost === $hash[2]) {
            return;
        }

        $user->passwordHash       = Yii::$app->security->generatePasswordHash($this->credential);
        $user->passwordResetToken = null;

        $user->save(false, [
            'passwordHash',
            'passwordResetToken',
        ]);
    }

    /**
     * Метод обновления профиля пользователя.
     *
     * @param UserInterface        $profile профиль пользователя.
     * @param UserAuthActiveRecord $auth    обновляемая аутентификация.
     *
     * @throws Exception Исключение при ошибке запроса к БД.
     *
     * @return void
     */
    private function updateIdentity(UserInterface $profile, UserAuthActiveRecord $auth)
    {
        $userProfileClass         = $this->userProfileClass;
        $auth->passwordHash       = Yii::$app->security->generatePasswordHash($this->credential);
        $auth->passwordResetToken = null;

        $auth->save(false, [
            'passwordHash',
            'passwordResetToken',
        ]);

        $userProfileClass::updateAll([
            'firstName'  => $profile->getFirstName(),
            'lastName'   => $profile->getLastName(),
            'secondName' => $profile->getSecondName(),
            'email'      => $profile->getEmail(),
            'phone'      => $profile->getPhone(),
        ], ['id' => $auth->profileId]);
    }

    /**
     * Метод добавления профиля пользователя.
     *
     * @param UserInterface $profile профиль пользователя.
     *
     * @return UserProfileActiveRecord|null
     */
    private function insertProfile(UserInterface $profile)
    {
        $userProfileClass       = $this->userProfileClass;
        $newProfile             = new $userProfileClass();
        $newProfile->firstName  = $profile->getFirstName();
        $newProfile->lastName   = $profile->getLastName();
        $newProfile->secondName = $profile->getSecondName();
        $newProfile->email      = $profile->getEmail();
        $newProfile->phone      = $profile->getPhone();

        if (! $newProfile->save(false)) {
            return null;
        }

        return $newProfile;
    }

    /**
     * Метод добавление профиля пользователя и аутентификационных данных.
     *
     * @param UserInterface $profile     профиль пользователя.
     * @param string        $adapterName наименование адаптера аутентификации.
     *
     * @throws Exception возможное исключение при генерации хэша пароля.
     *
     * @return UserAuthActiveRecord|null
     */
    private function insertIdentity(UserInterface $profile, $adapterName)
    {
        $newProfile = $this->insertProfile($profile);

        if (! $newProfile instanceof UserProfileActiveRecord) {
            return null;
        }

        $user               = new UserAuthActiveRecord();
        $user->authSystem   = $adapterName;
        $user->login        = $this->identity;
        $user->passwordHash = Yii::$app->security->generatePasswordHash($this->credential);
        $user->authKey      = Yii::$app->security->generateRandomString();
        $user->profileId    = $newProfile->id;

        if ($user->save(false)) {
            return $user;
        }

        return null;
    }

    /**
     * Проверяем аутентификация среди пользователей существующих в системе.
     *
     * @param UserAuthActiveRecord[] $userList       список пользователей.
     * @param array                  $verifiedSystem список систем, аутентификация которых была проведена.
     *
     * @throws InvalidParamException Исключение, если логин или пароль не верны (validatePassword).
     * @throws InvalidConfigException Исключение, если ошибка в настройках адаптера.
     * @throws Exception Исключение, если ошибка при запросе к БД.
     * @throws RuntimeException Исключение, если адаптер вернул неверный результат аутентификации.
     *
     * @return null|ResultModel
     */
    private function getInnerUserResult(array $userList, array &$verifiedSystem)
    {
        foreach ($userList as $user) {
            if (! $this->validatePassword($this->credential, $user->passwordHash)) {
                continue;
            }
            if (! $user->profile->isActive()) {
                $verifiedSystem[$user->authSystem] = 1;
                continue;
            }
            if ('default' === $user->authSystem || ! $this->hasAdapter($user->authSystem)) {
                $this->updatePasswordHash($user);
                return new ResultModel(ResultModel::SUCCESS, $user);
            }

            $cloneUser               = Yii::$app->userAuth->getById($user->id);
            $cloneUser->passwordHash = $this->credential;
            $adapter                 = $this->getAdapter($user->authSystem);

            if ($adapter->isActual($cloneUser)) {
                return new ResultModel(ResultModel::SUCCESS, $user);
            }

            $result = $this->adapterAuthenticate($user->authSystem);
            if ($result->isValid()) {
                $profile = $result->getIdentity();
                if (! $profile instanceof UserInterface) {
                    throw new RuntimeException(sprintf('Adapter %s must return UserInterface result as identity.', $user->authSystem));
                }
                $this->updateIdentity($profile, $user);
                return $result;
            }
            $verifiedSystem[$user->authSystem] = 1;
        }

        return null;
    }

    /**
     * Метод проверяет аутентификацию адаптеров.
     *
     * @param array $verifiedSystem проверенные ранее адаптеры.
     *
     * @return null|ResultModel
     *
     * @throws InvalidConfigException   Исключение, если ошибка в настройках адаптера.
     * @throws RuntimeException         Исключение, если неожиданный результат работы адаптера.
     * @throws Exception                Исключение, если возникла ошибка при запросе к бд.
     */
    private function getOuterUserResult(array $verifiedSystem)
    {
        foreach ($this->getAdapterIterator() as $adapterName) {
            if (isset($verifiedSystem[$adapterName])) {
                continue;
            }

            $result = $this->adapterAuthenticate($adapterName);

            if ($result->isValid()) {
                $profile = $result->getIdentity();
                if (! $profile instanceof UserInterface) {
                    throw new RuntimeException(sprintf('Adapter %s must return UserInterface result as identity.', $adapterName));
                }

                $user = $this->insertIdentity($profile, $adapterName);

                if ($user instanceof UserAuthActiveRecord) {
                    return new ResultModel(ResultModel::SUCCESS, $user);
                }

                return new ResultModel(ResultModel::FAILURE_UNCATEGORIZED, null, [
                    ResultModel::FAILURE_UNCATEGORIZED => 'Can not create user/profile in database.',
                ]);
            }
        }

        return null;
    }

    /**
     * Аутентификация пользователя. Используются адаптеры заданные конфигурацией.
     *
     * @throws InvalidParamException    Исключение, если логин или пароль не верны (checkInnerUser).
     * @throws InvalidConfigException   Исключение, если ошибка в настройках адаптера.
     * @throws Exception                Исключение, если ошибка при запросе к БД.
     * @throws RuntimeException         Исключение, в случае если адаптер вернул неверный результат аутентификации.
     *
     * @return ResultModel
     */
    public function authenticate()
    {
        $userList       = $this->getUserList();
        $verifiedSystem = [];
        $result         = $this->getInnerUserResult($userList, $verifiedSystem);

        if ($result instanceof ResultModel) {
            return $result;
        }

        foreach ($userList as $user) {
            if ('default' === $user->authSystem || ! $this->hasAdapter($user->authSystem)) {
                continue;
            }

            $verifiedSystem[$user->authSystem] = 1;
            $result                            = $this->adapterAuthenticate($user->authSystem);

            if ($result->isValid()) {
                $profile = $result->getIdentity();
                if (! $profile instanceof UserInterface) {
                    throw new RuntimeException(sprintf('Adapter %s must return UserInterface result as identity.', $user->authSystem));
                }
                $this->updateIdentity($profile, $user);

                return new ResultModel(ResultModel::SUCCESS, $user);
            }
        }

        $result = $this->getOuterUserResult($verifiedSystem);

        if ($result instanceof ResultModel) {
            return $result;
        }

        return new ResultModel(ResultModel::FAILURE_UNCATEGORIZED, null, [
            ResultModel::FAILURE_UNCATEGORIZED => 'Pair Identity/Credential not found.',
        ]);
    }

    /**
     * Метод устанавливает параметры адаптера, переданные в качестве параметра и возвращает результат проверки аутентификации.
     *
     * @param string $adapterName имя адаптера, с помощью которого проверяется аутентификация.
     *
     * @throws InvalidConfigException Исключение, если возникла ошибка в конфигурации адатера.
     *
     * @return ResultModel
     */
    public function adapterAuthenticate($adapterName)
    {
        $adapter = $this->getAdapter($adapterName);
        return $adapter->setIdentity($this->identity)->setCredential($this->credential)->authenticate();
    }

    /**
     * Метод создает адаптер в случае необходимости и возвращает его.
     *
     * @param string $adapterName псевдоним адаптера.
     *
     * @throws InvalidConfigException Исключение в случае ошибки конфигурации адатера.
     *
     * @return AdapterInterface|mixed
     */
    public function getAdapter($adapterName)
    {
        if (isset($this->adapterMap[$adapterName]) && $this->adapterMap[$adapterName] instanceof AdapterInterface) {
            return $this->adapterMap[$adapterName];
        }

        return $this->adapterMap[$adapterName] = Yii::createObject($this->adapters[$adapterName]);
    }

    /**
     * Проверяет существование адаптера в конфигурации.
     *
     * @param string $adapterName псевдоним адаптера.
     *
     * @return boolean
     */
    public function hasAdapter($adapterName)
    {
        return isset($this->adapters[$adapterName]);
    }

    /**
     * Возвращает список пользователей логин которых совпадает с искомым.
     *
     * @return UserAuthActiveRecord[]
     */
    private function getUserList()
    {
        /* @var UserAuthComponent $userAuthComponent */
        $userAuthComponent = Yii::$app->userAuth;
        return $userAuthComponent->getUserList($this->identity);
    }

    /**
     * Получение массива конфигурации адаптеров аутентификации.
     *
     * @return array
     */
    public function getAdapters()
    {
        return $this->adapters;
    }

    /**
     * Установка массива конфигурации адаптеров аутентификации.
     *
     * @param array $adapters массив конфигураций.
     *
     * @throws InvalidConfigException Исключение в случае, когда псевдоним адаптера не указан.
     *
     * @return static
     */
    public function setAdapters(array $adapters)
    {
        foreach ($adapters as $adapter) {
            if (! is_array($adapter) || ! isset($adapter['name'])) {
                throw new InvalidConfigException('Authentication adapter name must be defined.');
            }

            $adapterName = $adapter['name'];
            $priority    = isset($adapter['priority']) ? (int)$adapter['priority'] : 1;

            $this->queueAdapters->insert($adapterName, $priority);

            unset($adapter['priority'], $adapter['name']);
            $this->adapters[$adapterName] = $adapter;
        }

        return $this;
    }

    /**
     * Возвращает приоритетную очередь адаптеров аутентификации.
     *
     * @throws InvalidConfigException Исключение, когда псевдоним адаптера не указан.
     *
     * @return SplPriorityQueue
     */
    public function getAdapterIterator()
    {
        if ($this->queueAdapters instanceof SplPriorityQueue) {
            return $this->queueAdapters;
        }

        $this->queueAdapters = new SplPriorityQueue();
        foreach ($this->adapters as $adapterName => $adapter) {
            if (! is_string($adapterName)) {
                throw new InvalidConfigException('Authentication adapter name must be defined.');
            }

            if ('default' === $adapterName) {
                continue;
            }

            $priority = isset($adapter['priority']) ? (int)$adapter['priority'] : 1;
            $this->queueAdapters->insert($adapter['name'], $priority);
        }

        return $this->queueAdapters;
    }

    /**
     * Сеттер проверяет является ли указанный класс наследником UserProfile.
     *
     * @param string $userProfileClass имя класс, используемое системой в качестве профиля пользователя.
     *
     * @throws InvalidConfigException Исключение, когда в качестве параметра указан не потомок класса UserProfile.
     *
     * @return static
     */
    public function setUserProfileClass($userProfileClass)
    {
        if (! is_subclass_of($userProfileClass, UserProfileActiveRecord::class)) {
            throw new InvalidConfigException(sprintf('Class name for profile must be inherited UserProfile, given: %s', $userProfileClass));
        }

        $this->userProfileClass = $userProfileClass;
        return $this;
    }

    /**
     * Метод возвращает имя класс, используемое для определения класса объектов профиля пользователей.
     *
     * @return string
     */
    public function getUserProfileClass()
    {
        return $this->userProfileClass;
    }
}
