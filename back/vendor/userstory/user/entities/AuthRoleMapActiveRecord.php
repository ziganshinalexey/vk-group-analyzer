<?php

namespace Userstory\User\entities;

use Userstory\ComponentBase\traits\ModifierAwareTrait;
use yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Класс модели для таблицы "{{%us_auth_role_map}}".
 *
 * @property integer              $id
 * @property integer              $roleId
 * @property string               $authSystem
 * @property string               $roleOuter
 *
 * @property AuthRoleActiveRecord $role
 */
class AuthRoleMapActiveRecord extends ActiveRecord
{
    use ModifierAwareTrait;

    /**
     * Возвращает название таблицы для модели.
     *
     * @throws InvalidConfigException Генерируется в родителе в случае, компонент authManager не существует.
     *
     * @return string
     */
    public static function tableName()
    {
        return Yii::$app->get('authManager')->authRoleMap;
    }

    /**
     * Правила валидации модели.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'roleId',
                    'authSystem',
                    'roleOuter',
                ],
                'required',
            ],
            [
                [
                    'roleId',
                    'creatorId',
                    'updaterId',
                ],
                'integer',
            ],
            [
                [
                    'createDate',
                    'updateDate',
                ],
                'safe',
            ],
            [
                ['authSystem'],
                'string',
                'max' => 50,
            ],
            [
                ['roleOuter'],
                'string',
                'max' => 255,
            ],
            [
                ['roleId'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => AuthRoleActiveRecord::class,
                'targetAttribute' => ['roleId' => 'id'],
            ],
        ];
    }

    /**
     * Полное именование атрибутов модели.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('User.AuthRoleMap.Attribute', 'id', 'ID'),
            'roleId'     => Yii::t('User.AuthRoleMap.Attribute', 'roleId', 'Роль'),
            'authSystem' => Yii::t('User.AuthRoleMap.Attribute', 'authSystem', 'Система аутентификации'),
            'roleOuter'  => Yii::t('User.AuthRoleMap.Attribute', 'roleOuter', 'Внешняя роль'),
        ];
    }

    /**
     * Связь данных мапинга с ролью.
     *
     * @return AuthRoleActiveRecord|ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(AuthRoleActiveRecord::class, ['id' => 'roleId']);
    }
}
