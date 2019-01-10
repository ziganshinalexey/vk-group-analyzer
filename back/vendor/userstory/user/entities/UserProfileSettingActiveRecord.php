<?php

namespace Userstory\User\entities;

use Userstory\ComponentBase\traits\ModifierAwareTrait;
use Userstory\ComponentFieldset\entities\AbstractFieldset;
use Userstory\User\components\AuthenticationComponent;
use yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * Class UserProfileSettingActiveRecord.
 * Класс, расширяющий свойства профиля пользователя.
 *
 * @property UserProfileActiveRecord $profile
 * @property integer                 $personalInn
 * @property integer                 $personalSnils
 *
 * @package Userstory\User\entities
 */
class UserProfileSettingActiveRecord extends AbstractFieldset
{
    use ModifierAwareTrait;

    /**
     * Метод определяет название набора полей.
     *
     * @return string
     */
    public function getFieldsetName()
    {
        return 'profile_setting';
    }

    /**
     * Метод определяет название таблицы, связанной с данными.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%profile_setting}}';
    }

    /**
     * Геттер для связанных данных, следует использовать свойство profile.
     *
     * @throws InvalidConfigException Генерируется во внутренних вызовах.
     *
     * @return ActiveQuery
     */
    public function getProfile()
    {
        /* @var AuthenticationComponent $authenticationService */
        $authenticationService = Yii::$app->authenticationService;

        return $this->hasOne($authenticationService->userProfileClass, ['id' => 'relationId'])->inverseOf(
            'additionalProperties'
        );
    }
}
