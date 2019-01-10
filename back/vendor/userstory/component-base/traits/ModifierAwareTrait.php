<?php

namespace Userstory\ComponentBase\traits;

use Userstory\ModuleUser\entities\UserAuth;
use Userstory\ModuleUser\entities\UserProfile;
use yii;
use yii\base\InvalidConfigException;
use yii\console\Application as ConsoleApplication;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * Class ModifierAwareTrait.
 * Трейт, объявляющий связи с автором, изменившим, а также объявляет метод beforeSave для автоматической подстановки значений.
 *
 * @package Userstory\ComponentBase\models
 *
 * @property integer     $creatorId
 * @property string      $createDate
 * @property integer     $updaterId
 * @property string      $updateDate
 *
 * @property UserProfile $creator
 * @property UserProfile $updater
 *
 * @method boolean     getIsNewRecord ();
 * @method ActiveQuery hasOne($class, array $link) see [[BaseActiveRecord::hasOne()]] for more info
 */
trait ModifierAwareTrait
{
    /**
     * Метод, автоматически устанавливающий автора и изменяющего пользователя.
     *
     * @param boolean $insert создается запись или меняется.
     *
     * @return boolean
     */
    public function beforeSave($insert)
    {
        $now = new Expression('now()');
        if ($insert) {
            $this->creatorId  = $this->creatorId ? : $this->getAuthenticatedUserProfileId();
            $this->createDate = $now;
        }
        $this->updaterId  = $this->updaterId ? : $this->getAuthenticatedUserProfileId();
        $this->updateDate = $now;

        return parent::beforeSave($insert);
    }

    /**
     * Получение и выдача идишника текущего аутентифицированного юзера.
     *
     * @return integer
     */
    private function getAuthenticatedUserProfileId()
    {
        if (Yii::$app instanceof ConsoleApplication) {
            return null;
        }

        $userAuthClass = UserAuth::class;

        /* @var UserAuth $auth */
        if (null === ($auth = Yii::$app->user->getIdentity())) {
            return null;
        }

        if ($auth instanceof $userAuthClass) {
            return $auth->profileId ? $auth->profile->id : null;
        }

        return $auth->getId();
    }

    /**
     * Метод объявляет связь с профилем пользователя, создавшего сущность.
     *
     * @return ActiveQuery
     *
     * @throws InvalidConfigException не настроен компонент authenticationService.
     */
    public function getCreator()
    {
        return $this->hasOne(Yii::$app->get('authenticationService')->getUserProfileClass(), ['id' => 'creatorId']);
    }

    /**
     * Метод объявляет связь с профилем пользователя, изменившего сущность.
     *
     * @return ActiveQuery
     *
     * @throws InvalidConfigException не настроен компонент authenticationService.
     */
    public function getUpdater()
    {
        return $this->hasOne(Yii::$app->get('authenticationService')->getUserProfileClass(), ['id' => 'updaterId']);
    }
}
