<?php

namespace Userstory\User\entities;

use Userstory\ComponentBase\traits\ModifierAwareTrait;
use yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Класс для модели Роли. Содержит основные методы для работы.
 *
 * @property integer                          $id
 * @property string                           $name
 * @property string                           $description
 * @property integer                          $canModified
 *
 * @property AuthAssignmentActiveRecord[]     $authAssignments
 * @property AuthRoleActiveRecord[]           $authRoleMaps
 * @property AuthRolePermissionActiveRecord[] $authRolePermissions
 */
class AuthRoleActiveRecord extends ActiveRecord
{
    use ModifierAwareTrait;

    /**
     * Метод возвращает шаблон имени таблицы СУБД.
     *
     * @throws InvalidConfigException Генерируется в родителе в случае, компонент authManager не существует.
     *
     * @return string
     */
    public static function tableName()
    {
        return Yii::$app->get('authManager')->authRole;
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
                ['canModified'],
                'default',
                'value' => 1,
            ],
            [
                [
                    'name',
                    'canModified',
                    'description',
                ],
                'required',
            ],
            [
                ['description'],
                'string',
            ],
            [
                ['canModified'],
                'integer',
            ],
            [
                ['name'],
                'string',
                'max' => 50,
            ],
            [
                ['name'],
                'unique',
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
            'id'          => Yii::t('User.AuthRole.Attribute', 'id', 'ID'),
            'name'        => Yii::t('User.AuthRole.Attribute', 'name', 'Роль'),
            'description' => Yii::t('User.AuthRole.Attribute', 'description', 'Описание'),
            'canModified' => Yii::t('User.AuthRole.Attribute', 'canModified', 'Изменяемое'),
            'creatorId'   => Yii::t('User.AuthRole.Attribute', 'creatorId', 'Создал'),
            'createDate'  => Yii::t('User.AuthRole.Attribute', 'createDate', 'Дата создания'),
            'updaterId'   => Yii::t('User.AuthRole.Attribute', 'updaterId', 'Изменил'),
            'updateDate'  => Yii::t('User.AuthRole.Attribute', 'updateDate', 'Дата изменения'),
        ];
    }

    /**
     * Не даём изменять роли с соответствующим флагом.
     *
     * @param boolean $insert Флаг на вставку. Если false, значит данные обновляются.
     *
     * @return boolean
     */
    public function beforeSave($insert)
    {
        if (! $this->isNewRecord && ! $this->oldAttributes['canModified']) {
            return false;
        }

        return parent::beforeSave($insert);
    }

    /**
     * Не даём удалять роли с соответствующим флагом.
     *
     * @return boolean
     */
    public function beforeDelete()
    {
        if (! $this->isNewRecord && ! $this->oldAttributes['canModified']) {
            return false;
        }
        return parent::beforeDelete();
    }

    /**
     * Получение списка связанных моделей.
     *
     * @return ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignmentActiveRecord::className(), ['roleId' => 'id']);
    }

    /**
     * Получение списка связанных моделей.
     *
     * @return ActiveQuery
     */
    public function getAuthRoleMaps()
    {
        return $this->hasMany(AuthRoleMapActiveRecord::className(), ['roleId' => 'id']);
    }

    /**
     * Получение списка связанных моделей.
     *
     * @return ActiveQuery
     */
    public function getAuthRolePermissions()
    {
        return $this->hasMany(AuthRolePermissionActiveRecord::className(), ['roleId' => 'id'])->indexBy('permission')->orderBy('permission');
    }
}
