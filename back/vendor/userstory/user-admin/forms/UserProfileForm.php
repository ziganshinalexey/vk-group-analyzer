<?php

namespace Userstory\UserAdmin\forms;

use Exception as GlobalException;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\User\entities\AuthRoleActiveRecord as AuthRole;
use Userstory\User\entities\UserProfileActiveRecord;
use Userstory\UserAdmin\traits\UserAdminComponentTrait;
use yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\swiftmailer\Mailer;

/**
 * Class UserProfileForm.
 * Форма управления профилем пользователя.
 *
 * @property AuthAssignmentForm[] $assignments
 *
 * @package Userstory\UserAdmin\forms
 */
class UserProfileForm extends UserProfileActiveRecord
{
    use UserAdminComponentTrait;

    /**
     * Статичное свойство, в котором объявлена класс формы аутентификации.
     *
     * @var string
     */
    protected static $authClass = UserAuthForm::class;

    /**
     * Массив предзагруженных способов аутентификации.
     *
     * @var UserAuthForm[]|null
     */
    protected $userAuth;

    /**
     * Старое значение статуса для сравнения.
     *
     * @var boolean|null
     */
    protected $oldActiveState;

    /**
     * Список назначений для профиля.
     *
     * @var AuthAssignmentForm[]|null
     */
    protected $assignments;

    /**
     * Метод возвращает массив аутентификаций.
     *
     * @return UserAuthForm[]
     */
    public function getAuthForms()
    {
        if (null !== $this->userAuth) {
            return $this->userAuth;
        }

        if ($this->isNewRecord) {
            $this->userAuth[0]                    = new static::$authClass();
            $this->userAuth[0]->authSystem        = 'default';
            $this->userAuth[0]->canChangeLogin    = $this->userAuth[0]->canChangeLogin();
            $this->userAuth[0]->canChangePassword = $this->userAuth[0]->canChangePassword();
        } else {
            $this->userAuth = [];
            foreach ($this->auth as $auth) {
                $this->userAuth[$auth->id]                    = $auth;
                $this->userAuth[$auth->id]->canChangeLogin    = $auth->canChangeLogin();
                $this->userAuth[$auth->id]->canChangePassword = $auth->canChangePassword();
            }
        }

        return $this->userAuth;
    }

    /**
     * Перегруженный метод родителя. Необходим для заполнения UserAuthForm`ы данными.
     *
     * @param array|mixed $data     данные полученные от пользователя.
     * @param null|string $formName имя формы.
     *
     * @return boolean
     */
    public function load($data, $formName = null)
    {
        /* @var ActiveRecord $class */
        $class  = static::$authClass;
        $result = parent::load($data, $formName);
        return $result && $class::loadMultiple($this->getAuthForms(), $data) && AuthAssignmentForm::loadMultiple($this->getAssignments(), $data);
    }

    /**
     * Перегруженный метод валидации формы, необходим для валидации подчиненной AuthForm формы.
     *
     * @param array|null|null $attributeNames список проверяемых атрибутов.
     * @param boolean         $clearErrors    флаг, сообщающий, что необходимо очистить предыдущие ошибки.
     *
     * @throws InvalidParamException неизвестный сценарий.
     *
     * @return boolean
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        /* @var ActiveRecord $class */
        $class  = static::$authClass;
        $result = parent::validate($attributeNames, $clearErrors);
        return $result && $class::validateMultiple($this->getAuthForms()) && AuthAssignmentForm::validateMultiple($this->getAssignments());
    }

    /**
     * Сохранение предварительного старого значения статуса включенности юзера.
     * Перегружен из предка.
     *
     * @param mixed $insert Некие входные данные для перегрузки.
     *
     * @return mixed
     */
    public function beforeSave($insert)
    {
        $this->oldActiveState = isset($this->oldAttributes['isActive']) ? $this->oldAttributes['isActive'] : null;
        return parent::beforeSave($insert);
    }

    /**
     * Перегрузка метода, для образования связи с аутентификациями.
     *
     * @param boolean     $insert            вставка или обновление.
     * @param array|mixed $changedAttributes перечень обновляемых атрибутов.
     *
     * @throws InvalidParamException если не является массивом или объектом.
     * @throws yii\base\InvalidCallException не удалось связать модели методом link.
     * @throws Exception не установлен модуль sms-сообщений, но включен статус отправки уведомления на телефон.
     * @return void
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (0 !== count($this->userAuth)) {
            foreach ($this->userAuth as $auth) {
                if ($insert) {
                    $this->link('auth', $auth);
                } else {
                    $auth->save(false);
                }
            }
        }

        $this->needNotifyUser();
    }

    /**
     * Уведомление юзера о том, что его статут был изменен на включенный.
     *
     * @throws InvalidParamException если не является массивом или объектом.
     * @throws Exception если не установлен модуль отправки sms-сообщений, но включен статус отправки уведомления на телефон.
     *
     * @return boolean
     */
    private function needNotifyUser()
    {
        if (! $this->isActive || $this->oldActiveState) {
            return false;
        }

        $notifyOperation = $this->getUserAdminComponent()->notifyOperation;

        if ($this->email && $notifyOperation->isActivateEmail) {
            $emailFrom     = $notifyOperation->emailFrom;
            $emailFromName = $notifyOperation->emailFromName;
            $emailSubject  = $notifyOperation->emailSubject;
            $emailText     = $notifyOperation->emailText;

            /* @var Mailer $mailer */
            $mailer  = Yii::$app->queueMailer;
            $message = $mailer->compose();

            $message->setTo($this->email)->setFrom([$emailFrom => $emailFromName]);
            $message->setSubject($emailSubject)->setTextBody($emailText)->send();
        }

        $smsText = $notifyOperation->smsText;
        $smsSend = $notifyOperation->isActivateSms;

        if (! $smsSend || ! $this->phone || ! $smsText) {
            return true;
        }

        if (! ArrayHelper::getValue(Yii::$app->components, 'sms', false)) {
            throw new Exception('Для отпраки sms сообщений требуется модуль module-sms.');
        }

        Yii::$app->sms->send($this->phone, $smsText);

        return true;
    }

    /**
     * Ищет форму профиля юзера по его id.
     *
     * @param integer $id идентификатор юзера.
     *
     * @return static|null|mixed
     */
    public static function getById($id)
    {
        return static::find()->where(['id' => $id])->with('auth')->one();
    }

    /**
     * Геттер для получения связей с ролями для профиля.
     *
     * @return AuthAssignmentForm[]|ActiveQuery
     */
    public function getAuthAssignment()
    {
        return $this->hasMany(AuthAssignmentForm::class, ['profileId' => 'id'])->indexBy('roleId');
    }

    /**
     * Метод возвращает назначенные роли пользователя.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     *
     * @return AuthAssignmentForm[]
     */
    public function getAssignments()
    {
        if (null === $this->assignments) {
            $this->assignments = $this->authAssignment;

            /* @var AuthRole[] $otherRoles */
            $otherRoles = AuthRole::find()->where([
                'not in',
                'name',
                ArrayHelper::getColumn($this->assignments, 'role.name'),
            ])->all();

            foreach ($otherRoles as $role) {
                $this->assignments[$role->id] = Yii::createObject([
                    'class'     => AuthAssignmentForm::class,
                    'profileId' => $this->id,
                    'roleId'    => $role->id,
                    'isActive'  => false,
                ]);
            }

            ksort($this->assignments, SORT_NATURAL);
        }

        return $this->assignments;
    }

    /**
     * Метод сохраняет данные формы.
     *
     * @throws GlobalException Исключение, если возникли ошибки при сохранении данных.
     *
     * @return boolean
     */
    public function saveForm()
    {
        if (! $this->validate()) {
            return false;
        }

        $transaction = static::getDb()->beginTransaction();

        try {
            if ($this->save() && $this->saveAssignments()) {
                $transaction->commit();
            } else {
                $transaction->rollBack();
                return false;
            }
        } catch (GlobalException $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
    }

    /**
     * Метод сохраняет данные по назначенным ролям текущему профилю пользователя.
     *
     * @return boolean
     */
    protected function saveAssignments()
    {
        foreach ($this->getAssignments() as $assignment) {
            if ($assignment->isActive) {
                if ($assignment->isNewRecord) {
                    $assignment->profileId = $this->id;
                    $assignment->save(false);
                }
            } elseif (! $assignment->isNewRecord) {
                $assignment->delete();
            }
        }

        return true;
    }
}
