Модуль управления пользователями
================================

Описание
--------

Содержит сервисы аутентификации (с возможностью использования кастомных адаптеров) и авторизации; модели, контроллеры
и вьюхи для управления ролями и их разрешениями; миграции для создания таблиц профилей, пользователей, данных для аутентификации,
таблиц для ролей, разрешений и связующих таблиц.

Пример конфигурации
-------------------
```php
return [
    'components' => [
        'authManager'           => [
            'class'           => \Userstory\ModuleUser\components\AuthorizationComponent::class,
            'permissionsList' => [
                'Admin.Access'                => 'Доступ к админстративному модулю',
                'Admin.User.Create'           => 'Разрешение на создание пользователей',
                'Admin.User.Read'             => 'Разрешение на чтение пользователей',
                'Admin.User.Update'           => 'Разрешение на редактирование пользователей',
                'Admin.User.Delete'           => 'Разрешение на удаление пользователя',
                'Admin.Role.Read'             => 'Разрешение на чтение ролей',
                'Admin.Role.Create'           => 'Разрешение на создание ролей',
                'Admin.Role.Update'           => 'Разрешение на редактирование ролей',
                'Admin.Role.Delete'           => 'Разрешение на удаление ролей',
                'Admin.RoleAssignment.Read'   => 'Разрешение на чтение связей ролей и пользователей',
                'Admin.RoleAssignment.Create' => 'Разрешение на назначение роли пользователю',
                'Admin.RoleAssignment.Update' => 'Разрешение на реадктирование ролей пользователя',
                'Admin.RoleAssignment.Delete' => 'Разрешение на удаление ролей пользователя',
                'Admin.RolePermission.Read'   => 'Разрешение на получение полномочий ролей',
                'Admin.RolePermission.Create' => 'Разрешение на создание полномочия роли',
                'Admin.RolePermission.Update' => 'Разрешение на обновление полномочия роли',
                'Admin.RolePermission.Delete' => 'Разрешение на удаления полномочия роли',
            ],
        ],
        'authenticationService' => [
            'class' => \Userstory\ModuleUser\components\AuthenticationComponent::class,
        ],
        'user'                  => [
            'class'           => \Userstory\ModuleUser\web\USUser::class,
            'identityClass'   => \Userstory\ModuleUser\entities\UserAuth::class,
            'enableAutoLogin' => true,
            'loginUrl'        => ['/login'],
        ],
    ],
    'modules'    => [
        'admin' => [
            'controllerMap' => [
                'auth-role'            => [
                    'class'   => Userstory\ModuleUser\controllers\AuthRoleController::class,
                    'layout'  => '@vendor/userstory/module-admin/views/layouts/main',
                    'viewMap' => [
                        'index'  => '@vendor/userstory/module-user/views/auth-role/index',
                        'view'   => '@vendor/userstory/module-user/views/auth-role/view',
                        'update' => '@vendor/userstory/module-user/views/auth-role/update',
                        'create' => '@vendor/userstory/module-user/views/auth-role/create',
                    ],
                ],
                'auth-assignment'      => [
                    'class'   => Userstory\ModuleUser\controllers\AuthAssignmentController::class,
                    'layout'  => '@vendor/userstory/module-admin/views/layouts/main',
                    'viewMap' => [
                        'index'  => '@vendor/userstory/module-user/views/auth-assignment/index',
                        'view'   => '@vendor/userstory/module-user/views/auth-assignment/view',
                        'update' => '@vendor/userstory/module-user/views/auth-assignment/update',
                        'create' => '@vendor/userstory/module-user/views/auth-assignment/create',
                    ],
                ],
                'auth-role-permission' => [
                    'class'   => Userstory\ModuleUser\controllers\AuthRolePermissionController::class,
                    'layout'  => '@vendor/userstory/module-admin/views/layouts/main',
                    'viewMap' => [
                        'index'  => '@vendor/userstory/module-user/views/auth-role-permission/index',
                        'view'   => '@vendor/userstory/module-user/views/auth-role-permission/view',
                        'update' => '@vendor/userstory/module-user/views/auth-role-permission/update',
                        'create' => '@vendor/userstory/module-user/views/auth-role-permission/create',
                    ],
                ],
            ],
        ],
    ],
];
```

Правила авторизации
-------------------

Для написания правил, определяющих доступ пользователя к определенным разрешениям предоставляется интерфейс
`Userstory\ModuleUser\components\Authorization\RuleInterface`. Он определяет методы `getPermissionList()` и 
`setPermissionList($permissionList)` для получения и задания списка проверяемых разрешений и метод
`isGranted($profileId, $permission, $context = null)`, где `$profileId` - ИД профиля, `$permission` - разрешение,
а `$context` - массив с контекстом. Для удобства существует абстрактный класс `Userstory\ModuleUser\components\Authorization\AbstractRule`,
 в котором определены `getPermissionList()` и `setPermissionList($permissionList)`.
 Пример применения правила в конфиге из `module-publications`:
 ```php
 <?php
 return [
     'components'    => [
         'authManager'  => [
             'permissionsList' => [
                 'Admin.Publications.Create'         => 'Разрешение на создание новости для админа',
                 'Admin.Publications.Read'           => 'Разрешение на просмотр новости для админа',
                 'Admin.Publications.Update'         => 'Разрешение на редактирование новости для админа',
                 'Admin.Publications.Delete'         => 'Разрешение на удаление новости для админа',
                 'Admin.PublicationsCategory.Create' => 'Разрешение на создание категории для админа',
                 'Admin.PublicationsCategory.Read'   => 'Разрешение на просмотр категории для админа',
                 'Admin.PublicationsCategory.Update' => 'Разрешение на редактирование категории',
                 'Admin.PublicationsCategory.Delete' => 'Разрешение на удаление категории для админа',
                 'User.Publications.Create'          => 'Разрешение на создание новости для пользователя',
                 'User.Publications.Read'            => 'Разрешение на просмотр новости для пользователя',
                 'User.Publications.Update'          => 'Разрешение на ред-ие новости для пользователя',
                 'User.Publications.Delete'          => 'Разрешение на удаление новости для пользователя',
                 'User.PublicationsCategory.Read'    => 'Разрешение на просмотр категори для пользователя',
             ],
             'rules'           => [
                 [
                     'class'          => \Userstory\ModulePublications\Authorization\UserCanView::class,
                     'permissionList' => [
                         'User.Publications.Create',
                         'User.Publications.Read',
                         'User.Publications.Update',
                         'User.Publications.Delete',
                         'User.PublicationsCategory.Read',
                         'Admin.Publications.Update',
                         'Admin.Publications.Delete',
                     ],
                 ],
             ],
         ],
     ]
 ];
 ```

Реализация правила на примере `Userstory\ModulePublications\Authorization\UserCanView`:
```php
<?php

namespace Userstory\ModulePublications\Authorization;

use Userstory\ModulePublications\models\Category;
use Userstory\ModulePublications\models\News;
use Userstory\ModuleUser\interfaces\RuleInterface;
use yii\base\BaseObject;

/**
 * Проверка полномочий у пользователя.
 *
 * @property array $permissionList
 *
 * @package Userstory\ModulePublications\Authorization
 */
class UserCanView extends BaseObject implements RuleInterface
{
    /**
     * Список полномочий пользователя.
     *
     * @var array
     */
    protected $permissionList = [
        'User.Publications.Create',
        'User.Publications.Read',
        'User.Publications.Update',
        'User.Publications.Delete',
        'User.PublicationsCategory.Read',
        'Admin.Publications.Update',
        'Admin.Publications.Delete',
    ];

    /**
     * Проверка полномочий пользователя.
     *
     * @param integer    $profileId  ид пользователя.
     * @param string     $permission поверяемое полномочие.
     * @param array|null $context    контекст, относительно которого проверяет полномочие.
     *
     * @return boolean
     */
    public function isGranted($profileId, $permission, $context = null)
    {
        if (in_array($permission, $this->permissionList)) {
            $hasModel = isset( $context['model'] ) && ( $context['model'] instanceof News || $context['model'] instanceof Category );
            return ! $hasModel || $profileId === $context['model']->creatorId;
        }
        return false;
    }

    /**
     * Метод возвращает полномочия.
     *
     * @return array
     */
    public function getPermissionList()
    {
        return $this->permissionList;
    }

    /**
     * Метод устанавливает полномочия.
     *
     * @param array|string $permissionList список полномочий.
     *
     * @return void
     */
    public function setPermissionList($permissionList)
    {
        $this->permissionList = (array)$permissionList;
    }
}
```

# Управление ролями.

- По умолчанию список допустимых ролей находится в таблице `{{%auth_role}}`.
- Список разрешений для каждой роли в таблице `{{%auth_role_permission}}`
- Список разрешений для пользователей хранится в таблице `{{%auth_role_assignment}}`.

### CRUD ролей.
- Управление ролями в разделе администрирования.
  Страница по умолчанию - `/admin/auth-role`.
  В данном разделе вы можете создавать, просматривать, редактировать и удалять роли.

- Управление ролями программно.
   Модель ActiveRecord - Userstory\ModuleUser\entities\AuthRole.
   Атрибуты: name, canModified, description.
   Если атрибут canModified == true, роль нельзя ни удалить, ни редактировать.


### Разрешения для ролей.
- В разделе администрирования.
 Страница по умолчанию - `/admin/auth-role-permission`.
 В данном разделе вы можете создавать, просматривать, редактировать и удалять разрешения для   ролей.

- Программно.
 модель ActiveRecord - Userstory\ModuleUser\entities\AuthRolePermission.
 атрибуты: roleId, permission, isGlobal.

### Пользователи и роли.
- Присвоение ролей в разделе администрирования.
Страница по умолчанию - `/admin/auth-assignment`.
На данной странице вы можете просмотреть роли пользователей, редактировать и присваивать роли для пользователей.

- Присвоение ролей программно.
  модель ActiveRecord - Userstory\ModuleUser\entities\AuthAssignment.
  атрибуты: roleId, profileId, isActive

- Узнать, обладает ли пользователь определенными правами:
```php
Yii::$app->get('AuthorizationService')->checkAccess({profileId}, {permission})
```
или
```php
Yii::$app->user->can({permission})
```
где `{permission}` - имя полномочия
`{profileId}` - идентификатор пользователя.


Адаптеры аутентификации
-----------------------

В `module-user` предусмотрен механизм, предусматривающий подключение кастомных адаптеров аутентификации. Для этого предоставлены интерфейс
`Userstory\ModuleUser\interfaces\AdapterInterface` и абстрактный класс `Userstory\ModuleUser\interfaces\AdapterInterface`
определяющий общие геттеры и сеттеры. Основным методом является `authenticate()`, который пробует аутентифицировать юзера и возвращает
`Userstory\ModuleUser\models\Result`. 
Для примера может послужить `Userstory\ModuleUser\adapters\Authentication\DefaultAdapter`:
```php
<?php

namespace Userstory\ModuleUser\components\Authentication\Adapter;

use Userstory\ModuleUser\models\Result;
use Userstory\ModuleUser\entities\UserAuth;
use yii\db\Expression;

/**
 * Class DefaultAdapter.
 * Класс, реализующий внутресистемный адаптер аутентификации.
 *
 * @package Userstory\ModuleUser\components\Authentication\Adapter
 */
class DefaultAdapter extends AbstractAdapter
{
    /**
     * Метод возвращает имя адаптера.
     *
     * @return string
     */
    public function getName()
    {
        return 'default';
    }

    /**
     * Метод проверяет, актуальна ли информация пользователя.
     *
     * @param UserAuth $user проверяемый пользователь.
     *
     * @return mixed
     */
    public function isActual(UserAuth $user)
    {
        return true;
    }

    /**
     * Метод осуществляет проверку аутентификации внутренними средствами.
     *
     * @throws \yii\base\InvalidParamException Генерируется если логин/пароль не верны.
     *
     * @return Result
     */
    public function authenticate()
    {
        $userAuth = UserAuth::find()
                            ->where(['authSystem' => 'default'])
                            ->andWhere(new Expression('lower(login) = lower(:login)'), ['login' => $this->identity])
                            ->one();
        if (! $userAuth instanceof UserAuth) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null, [Result::FAILURE_IDENTITY_NOT_FOUND => 'Identity not found']);
        }

        if (Yii::$app->get('authenticationService')->validatePassword($this->credential, $userAuth->passwordHash)) {
            return new Result(Result::SUCCESS, $userAuth);
        }
        return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, [Result::FAILURE_CREDENTIAL_INVALID => 'Credential invalid.']);
    }
}

```
Пример добавлянеия адаптера в конфигурацию.
```php
return [
    'components' => [
        'authenticationService' => [
            'class' => \Userstory\ModuleUser\components\AuthenticationComponent::class,
            'adapters' => [
                [
                    'class' => DefaultAdapter::class,
                    'name'  => 'default',
                ],
                [
                    'class'    => MyAdapter::class,
                    'name'     => 'myAdapter',
                    'priority' => 2,
                ],
            ],
        ],
    ],
];
```