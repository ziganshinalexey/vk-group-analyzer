<?php

namespace Userstory\User\components;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\User\interfaces\RoleServiceInterface;
use Userstory\User\interfaces\RuleInterface;
use Userstory\User\operations\AuthorizationOperation;
use yii;
use yii\base\Component;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\caching\Cache;
use yii\di\Instance;

/**
 * Class AuthorizationService.
 * Класс для осуществления авторизации в системе текущего пользователя.
 *
 * @property string $authAssignment
 * @property string $authRole
 * @property string $authRoleMap
 * @property string $authRolePermission
 *
 * @property string $guestRole
 * @property array  $permissionsList
 *
 * @package Userstory\User\components
 */
class AuthorizationComponent extends Component
{
    /**
     * Название роли неавторизованного пользователя.
     *
     * @var string|null
     */
    protected $guestRole;

    /**
     * Свойство для взаимодействия с кэшем.
     *
     * @var Cache|null
     */
    protected $cache;

    /**
     * Формат ключа кэша, для инициализации системы кэширования.
     *
     * @var string
     */
    protected $cacheKeyFormat = 'us_user_permission_';

    /**
     * Ключ кэша со списком закэшированных разрешений профилей.
     *
     * @var string
     */
    protected $cacheKeyProfiles = 'us_user_cached_profiles';

    /**
     * Свойство для хранения локального кэша полномочий.
     *
     * @var array
     */
    protected $permissions = [];

    /**
     * Массив конфигураций правил проверки наличия полномочий.
     *
     * @var array|null
     */
    protected $rulesConfiguration;

    /**
     * Инициированные адаптеры правил.
     *
     * @var array|null
     */
    protected $ruleAdapters;

    /**
     * Список разрешениий системы.
     *
     * @var array
     */
    protected $permissionsList = [];

    /**
     * Объект операции для работы компонента.
     *
     * @var AuthorizationOperation|null
     */
    protected $operation;

    /**
     * Метод возвращает шаблон имени таблицы, хранящей назначенные пользователю группы.
     *
     * @return string
     */
    public function getAuthAssignment()
    {
        return $this->operation->getTable(AuthorizationOperation::AUTH_ASSIGNMENT_TABLE_KEY);
    }

    /**
     * Метод возвращает аблон имени таблицы СУБД, хранящей зарегистрированные роли в системе.
     *
     * @return string
     */
    public function getAuthRole()
    {
        return $this->operation->getTable(AuthorizationOperation::AUTH_ROLE_TABLE_KEY);
    }

    /**
     * Метод возвращает шаблон имени таблицы СУБД, хранящей карту соответствия между ролями системы и ролями внешних систем аутентификации.
     *
     * @return string
     */
    public function getAuthRoleMap()
    {
        return $this->operation->getTable(AuthorizationOperation::AUTH_ROLE_MAP_TABLE_KEY);
    }

    /**
     * Метод возвращает шаблон имени таблицы СУБД, хранящей полномочия роли.
     *
     * @return string
     */
    public function getAuthRolePermission()
    {
        return $this->operation->getTable(AuthorizationOperation::AUTH_ROLE_PERMISSION_TABLE_KEY);
    }

    /**
     * Метод задает конфигурацию объекта операции.
     *
     * @param array $config Конфигурация для работы.
     *
     * @return static
     */
    public function setOperation(array $config)
    {
        $this->operation = Yii::createObject($config);
        return $this;
    }

    /**
     * Инициализатор сервиса авторизации.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        if (null !== Yii::$app->cache) {
            $this->cache = Instance::ensure(Yii::$app->cache, Cache::class);
        }
    }

    /**
     * Метод проверяет наличие указанного полномочия ($permission) у указанного профиля пользователя ($profileId).
     *
     * @param integer $profileId  идентификатор пользователя.
     * @param string  $permission проверяемое полномочие.
     * @param mixed   $context    контекст, относительного которого проверяется авторизация.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     * @throws Exception              Исключение генерируется во внутренних вызовах.
     *
     * @return boolean
     */
    public function checkAccess($profileId, $permission, $context = null)
    {
        $this->loadFromCache($profileId);

        // Если полномочия нет в списке доступных - false
        if (! isset($this->permissions[$permission])) {
            return false;
        }

        // Если привилегия глобальная - true
        if ($this->permissions[$permission]) {
            return true;
        }

        // Если правило проверки полномочия существует - выполняем проверку
        if ($this->hasRule($permission)) {
            return $this->getRule($permission)->isGranted($profileId, $permission, $context);
        }

        return true;
    }

    /**
     * Метод проверяет является ли указанное полномочие глобальным у указанного пользователя.
     *
     * @param integer $profileId  идентификатор пользователя.
     * @param string  $permission проверяемое полномочие.
     *
     * @return boolean
     */
    public function permissionIsGlobal($profileId, $permission)
    {
        $this->loadFromCache($profileId);

        return isset($this->permissions[$permission]) && $this->permissions[$permission];
    }

    /**
     * Метод проверяет существование правила проверки полномочия в конфигурации правил.
     *
     * @param string $permission полномочие.
     *
     * @return boolean
     */
    public function hasRule($permission)
    {
        return isset($this->ruleAdapters[$permission]) || isset($this->rulesConfiguration[$permission]);
    }

    /**
     * Получение правила, заданного в конфигурации.
     *
     * @param string $permission полномочие.
     *
     * @return RuleInterface
     * @throws InvalidConfigException исключение в случае ошибочной конфигурации.
     */
    public function getRule($permission)
    {
        if (isset($this->ruleAdapters[$permission])) {
            return $this->ruleAdapters[$permission];
        }

        $instance = Yii::createObject($this->rulesConfiguration[$permission]);

        if (! $instance instanceof RuleInterface) {
            $type = is_object($instance) ? get_class($instance) : gettype($instance);
            throw new InvalidConfigException(sprintf('Rule must be implement Userstory\User\RuleInterface, "%s" given.', $type));
        }

        foreach ((array)$instance->getPermissionList() as $perm) {
            $this->ruleAdapters[$perm] = $instance;
        }

        return $instance;
    }

    /**
     * Сеттер для установки кэша, заданного из конфигурации.
     *
     * @param mixed $cache инициированный кэш.
     *
     * @return static
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * Метод получения сервиса аутентификации.
     *
     * @return AuthenticationComponent
     *
     * @throws InvalidConfigException компонент authenticationService не настроен.
     */
    public function getAuthenticationService()
    {
        return Yii::$app->get('authenticationService');
    }

    /**
     * Метод возвращает сервис авторизации по псевдониму системы аутентификации.
     *
     * @param string $authSystem псевдоним системы аутентификации.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     *
     * @return RoleServiceInterface|null
     */
    public function getRoleServiceAdapter($authSystem)
    {
        $auth = $this->getAuthenticationService();
        if ($auth->hasAdapter($authSystem) && ( $adapter = $auth->getAdapter($authSystem) ) && $adapter instanceof RoleServiceInterface) {
            return $adapter;
        }

        return null;
    }

    /**
     * Метод возвращает список идентифкаторов ролей, членом которых должен быть пользователь.
     *
     * @param integer $profileId Идентификатор профиля пользователя.
     *
     * @return array
     */
    private function getOuterRoles($profileId)
    {
        $query = $this->operation->getOuterRolesQuery($profileId, $this->authRoleMap, $this->authAssignment);
        return $this->operation->getOuterRoles($profileId, $query);
    }

    /**
     * Метод проверяет наличие внешне добавленных ролей пользователя.
     *
     * @param integer $profileId идентификатор профиля пользователя.
     *
     * @return void
     */
    private function addOuterRoles($profileId)
    {
        $roleIds = $this->getOuterRoles($profileId);
        $this->operation->addOuterRoles($profileId, $roleIds);
    }

    /**
     * Загрузка полномочий пользователя из кэша.
     *
     * @param integer $profileId идентификатор профайла.
     *
     * @return void
     */
    public function loadFromCache($profileId)
    {
        if (! empty($this->permissions)) {
            return;
        }

        $data = $this->getCacheValue($profileId);

        if (is_array($data)) {
            $this->permissions = $data;
            return;
        }

        // Получение полномочий неавторизованного пользователя.
        if (null === $profileId) {
            $this->addUnauthorizedUserPermissions();
            return;
        }

        // Назначаем пользователю роли, путем получения из внешних источников.
        $this->addOuterRoles($profileId);

        $this->permissions = $this->operation->getUserPermissions($profileId);

        $this->setCacheValue($profileId, $this->permissions);
    }

    /**
     * Метод возвращает ключ для доступа к кэшу.
     *
     * @param integer $profileId Идентификатор профиля пользователя.
     *
     * @return string
     */
    protected function getCacheKey($profileId)
    {
        return $this->cacheKeyFormat . $profileId;
    }

    /**
     * Метод сохраняет данные в кэше.
     *
     * @param integer $profileId   Идентификатор профиля.
     * @param array   $permissions Список полномочий.
     *
     * @return void
     */
    protected function setCacheValue($profileId, array $permissions)
    {
        if (! $this->cache instanceof Cache) {
            return;
        }

        $cacheKey = $this->getCacheKey($profileId);
        $this->cache->set($cacheKey, $permissions);

        if (false === ($profileIds = $this->cache->get($this->cacheKeyProfiles))) {
            $profileIds = [];
        }

        $profileIds[] = $profileId;
        $this->cache->set($this->cacheKeyProfiles, $profileIds);
    }

    /**
     * Метод возвращает данные из кэша.
     *
     * @param integer $profileId Идентификатор профиля.
     *
     * @return boolean
     */
    protected function getCacheValue($profileId)
    {
        if (! $this->cache instanceof Cache) {
            return false;
        }

        $cacheKey = $this->getCacheKey($profileId);
        return $this->cache->get($cacheKey);
    }

    /**
     * Загрузка полномочий пользователя из кэша.
     *
     * @return void
     */
    public function clearCache()
    {
        $this->permissions = [];

        if (! $this->cache instanceof Cache) {
            return;
        }

        $profileIds = (array)$this->cache->get($this->cacheKeyProfiles);
        $profileIds = array_unique($profileIds);

        foreach ($profileIds as $profileId) {
            $cacheKey = $this->getCacheKey($profileId);
            $this->cache->delete($cacheKey);
        }
    }

    /**
     * Загрузка полномочий неавторизованного пользователя.
     *
     * @return void
     */
    public function addUnauthorizedUserPermissions()
    {
        $this->operation->updateUnauthorizedUserPermissions($this->permissions);

        $this->setCacheValue(null, $this->permissions);
    }

    /**
     * Сеттер для установки конфигураций правил проверки.
     *
     * @param array $rules массив конфигураций правил.
     *
     * @return static
     * @throws InvalidConfigException исключение, для случая, если правило повторно назначается на полномочие.
     */
    public function setRules(array $rules)
    {
        foreach ($rules as $rule) {
            if ($rule instanceof RuleInterface) {
                $this->setRuleAdapter($rule);
            } elseif (is_array($rule) && isset($rule['class'], $rule['permissionList'])) {
                $this->setRuleConfiguration($rule);
            }
        }

        return $this;
    }

    /**
     * Метод назначает правило проверки полномочий.
     *
     * @param RuleInterface $rule назначаемое правило.
     *
     * @return void
     * @throws InvalidConfigException возможное исключение, для случая когда для проверки полномочия уже установлено правило.
     */
    private function setRuleAdapter(RuleInterface $rule)
    {
        $permissionList = (array)$rule->getPermissionList();
        foreach ($permissionList as $permission) {
            if ($this->hasRule($permission)) {
                throw new InvalidConfigException(sprintf('Service already have Rule assigned with "%s" permission.', $permission));
            }
            $this->ruleAdapters[$permission] = $rule;
        }
    }

    /**
     * Метод устанавливает кофигурацию правил для обработки полномочий.
     *
     * @param array $rule конфигурация правила.
     *
     * @return void
     * @throws InvalidConfigException возможное исключение, для случая когда для проверки полномочия уже установлена конфигурация.
     */
    private function setRuleConfiguration(array $rule)
    {
        foreach ((array)$rule['permissionList'] as $permission) {
            if ($this->hasRule($permission)) {
                throw new InvalidConfigException(sprintf('Service already have Rule assigned with "%s" permission.', $permission));
            }
            $this->rulesConfiguration[$permission] = $rule;
        }
    }

    /**
     * Возвращает список всех разрешений.
     *
     * @return array
     */
    public function getPermissionsList()
    {
        return $this->permissionsList;
    }

    /**
     * Добавляет разрешение в список.
     *
     * @param array $permissions массив разрешений формата 'разрешение' => 'описание'.
     *
     * @return AuthorizationComponent
     */
    public function setPermissionsList(array $permissions)
    {
        $this->permissionsList = ArrayHelper::merge($this->permissionsList, $permissions);
        return $this;
    }

    /**
     * Возвращает название роли неавторизованного пользователя.
     *
     * @return null|string
     */
    public function getGuestRole()
    {
        return $this->guestRole;
    }

    /**
     * Устанавилвает название роли неавторизованного пользователя.
     *
     * @param string $guestRole название роли неавторизованного пользователя.
     *
     * @return static
     */
    public function setGuestRole($guestRole)
    {
        $this->guestRole = $guestRole;
        return $this;
    }

    /**
     * Метод добавляет список разрешений.
     *
     * @param array $permissions Список разрешений.
     *
     * @return void
     */
    public function addPermissions(array $permissions)
    {
        $this->permissions = ArrayHelper::merge($this->permissions, $permissions);
    }
}
