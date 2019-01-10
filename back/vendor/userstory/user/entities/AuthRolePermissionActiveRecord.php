<?php

namespace Userstory\User\entities;

use yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Класс для модели Разрешения ролей.
 * Содержит основные методы для работы.
 *
 * @property integer              $roleId
 * @property string               $permission
 * @property integer              $isGlobal
 *
 * @property AuthRoleActiveRecord $role
 */
class AuthRolePermissionActiveRecord extends ActiveRecord
{
    /**
     * Метод возвращает шаблон имени таблицы СУБД.
     *
     * @throws InvalidConfigException Генерируется в родителе в случае, компонент authManager не существует.
     *
     * @return string
     */
    public static function tableName()
    {
        return Yii::$app->get('authManager')->authRolePermission;
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
                    'permission',
                ],
                'required',
            ],
            [
                ['isGlobal'],
                'filter',
                'filter' => function($value) {
                    return (int)(bool)$value;
                },
            ],
            [
                [
                    'roleId',
                    'isGlobal',
                ],
                'integer',
            ],
            [
                ['permission'],
                'string',
                'max' => 50,
            ],
            [
                ['roleId'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => AuthRoleActiveRecord::class,
                'targetAttribute' => ['roleId' => 'id'],
            ],
            [
                ['permission'],
                'in',
                'range'   => array_keys(Yii::$app->authManager->permissionsList),
                'message' => 'Указано неизвестное системе полномочие.',
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
            'roleId'     => Yii::t('User.Permission.Attribute', 'roleId', 'Роль'),
            'permission' => Yii::t('User.Permission.Attribute', 'permission', 'Разрешения'),
            'isGlobal'   => Yii::t('User.Permission.Attribute', 'isGlobal', 'Глобальный'),
        ];
    }

    /**
     * Метод для получения с моделью связанной роли.
     *
     * @return AuthRoleActiveRecord|ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(AuthRoleActiveRecord::class, ['id' => 'roleId']);
    }
}
