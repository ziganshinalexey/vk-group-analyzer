<?php

namespace Userstory\User\entities;

use Userstory\ComponentBase\traits\ModifierAwareTrait;
use yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Класс для модели Присвоение ролей. Содержит основные методы для работы.
 *
 * @property integer                 $id
 * @property integer                 $roleId
 * @property integer                 $profileId
 * @property integer                 $isActive
 *
 * @property AuthRoleActiveRecord    $role
 * @property UserProfileActiveRecord $profile
 */
class AuthAssignmentActiveRecord extends ActiveRecord
{
    use ModifierAwareTrait;

    /**
     * Активное означает активное состояние связи.
     */
    const ACTIVE_STATE = 1;

    /**
     * Активное означает не активное состояние связи.
     */
    const NOT_ACTIVE_STATE = 0;

    /**
     * Метод возвращает шаблон имени таблицы СУБД.
     *
     * @throws InvalidConfigException Генерируется в родителе в случае, компонент authManager не существует.
     *
     * @return string
     */
    public static function tableName()
    {
        return Yii::$app->get('authManager')->authAssignment;
    }

    /**
     * Метод возвращает правила валидации.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'roleId',
                    'profileId',
                    'isActive',
                ],
                'required',
            ],
            [
                [
                    'roleId',
                    'profileId',
                    'isActive',
                ],
                'integer',
            ],
            [
                ['roleId'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => AuthRoleActiveRecord::className(),
                'targetAttribute' => ['roleId' => 'id'],
            ],
            [
                ['profileId'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => UserProfileActiveRecord::className(),
                'targetAttribute' => ['profileId' => 'id'],
            ],
            [
                'isActive',
                'filter',
                'filter' => function($value) {
                    return (bool)$value;
                },
            ],
        ];
    }

    /**
     * Метод возвращает заголовки для аттрибутов.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id'        => Yii::t('User.Assignment.Attribute', 'id', 'ID'),
            'roleId'    => Yii::t('User.Assignment.Attribute', 'roleId', 'Роль'),
            'profileId' => Yii::t('User.Assignment.Attribute', 'profileId', 'Профиль'),
            'isActive'  => Yii::t('User.Assignment.Attribute', 'isActive', 'Активен'),
        ];
    }

    /**
     * Связь с ролями авториазции.
     *
     * @return ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(AuthRoleActiveRecord::className(), ['id' => 'roleId']);
    }

    /**
     * Связь с профилями пользователей.
     *
     * @return ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(UserProfileActiveRecord::className(), ['id' => 'profileId']);
    }

    /**
     * Выполняется перед вызовом удаления модели.
     *
     * @return boolean
     */
    public function beforeDelete()
    {
        if ('admin' === $this->role->name && $this->profile->isLastAdmin()) {
            return false;
        }
        return parent::beforeDelete();
    }

    /**
     * Выполняется перед вызовом сохранения модели.
     *
     * @param boolean $insert означает происходит вставка или сохранение значения.
     *
     * @return boolean
     */
    public function beforeSave($insert)
    {
        if (! parent::beforeSave($insert)) {
            return false;
        }

        $adminId = UserProfileActiveRecord::getRoleId('admin');

        // Если изменения не касаются ролей 'admin', то тогда выходим.
        if ($insert || $adminId !== $this->oldAttributes['roleId']) {
            return true;
        }

        $isLastAdmin = $this->profile->isLastAdmin();

        // Если старая роль админ, то нужно дополнительные проверки
        if (! $this->beforeSaveAdditionalAdminCheck($isLastAdmin)) {
            return false;
        }

        $wasActive = (bool)self::ACTIVE_STATE === (bool)$this->oldAttributes['isActive'];
        if ($isLastAdmin && (bool)self::ACTIVE_STATE !== (bool)$this->isActive && $wasActive) {
            $this->addError('isActive', 'Невозможно отключить последнего, активного администратора.');
            return false;
        }

        return true;
    }

    /**
     * Дополнительная проверки на изменение роли или пользователя привязки.
     *
     * @param boolean $isLastAdmin передается результат вызова isLastAdmin.
     *
     * @return boolean
     */
    protected function beforeSaveAdditionalAdminCheck($isLastAdmin)
    {
        $isRoleChanged = array_key_exists('roleId', $this->oldAttributes) && ($this->oldAttributes['roleId'] !== $this->roleId);
        $isUserChanged = array_key_exists('profileId', $this->oldAttributes) && ($this->oldAttributes['profileId'] !== $this->profileId);

        // ** Роль не изменилась и пользователь не изменился. **
        // Все ок.
        // ** Роль не изменилась, а изменился пользователь. **
        // Значит права админа передали другому пользователю.
        // ** Роль изменилась, а пользователь не изменился. **
        // Если этот пользователь последний админ, то изменять его роль нельзя.
        if ($isRoleChanged) {
            if (! $isUserChanged && $isLastAdmin) {
                $this->addError('roleId', 'Невозможно отключить последнего, активного администратора.');
                return false;
            }
            // ** Роль изменилась и изменился пользователь. **
            // Тогда проверяем был ли старый пользователь последним админом.
            if ($isUserChanged) {
                $oldUser = UserProfileActiveRecord::findOne($this->oldAttributes['profileId']);
                if ($oldUser->isLastAdmin()) {
                    $this->addError('roleId', 'Невозможно отключить последнего, активного администратора.');
                    $this->addError('profileId', 'Невозможно отключить последнего, активного администратора.');
                    return false;
                }
            }
        }

        return true;
    }
}
