<?php

namespace Userstory\UserAdmin\forms;

use Userstory\User\entities\UserProfileActiveRecord;
use yii;
use yii\base\InvalidParamException;
use yii\base\Model;

/**
 * Class ProfileForm.
 * Класс формы редактирования профиля пользователя.
 *
 * @property string  $firstName
 * @property string  $lastName
 * @property string  $secondName
 * @property integer $phone
 * @property string  $email
 *
 * @package Userstory\UserAdmin\forms
 */
class ProfileForm extends Model
{
    /**
     * Свойство формы для имени пользователя.
     *
     * @var string|null
     */
    protected $firstName;

    /**
     * Свойство формы для фамилии пользователя.
     *
     * @var string|null
     */
    protected $lastName;

    /**
     * Свойство формы для фамилии пользователя.
     *
     * @var string|null
     */
    protected $secondName;

    /**
     * Свойство формы для телефона пользователя.
     *
     * @var integer|null
     */
    protected $phone;

    /**
     * Свойство формы для email пользователя.
     *
     * @var string|null
     */
    protected $email;

    /**
     * Формы проверки аутентификационных пар.
     *
     * @var AuthForm[]|null
     */
    protected $userAuth;

    /**
     * Редактируемый профиль пользователя.
     *
     * @var UserProfileActiveRecord|null
     */
    protected $userProfile;

    /**
     * Метод возвращает имя пользователя.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Метод задает имя пользователя.
     *
     * @param string $firstName Значение для установки.
     *
     * @return static
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Метод возвращает фамилию пользователя.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Метод задает фамилию пользователя.
     *
     * @param string $lastName Значение для установки.
     *
     * @return static
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * Метод возвращает отчество пользователя.
     *
     * @return string
     */
    public function getSecondName()
    {
        return $this->secondName;
    }

    /**
     * Метод задает отчество пользователя.
     *
     * @param string $secondName Значение для установки.
     *
     * @return static
     */
    public function setSecondName($secondName)
    {
        $this->secondName = $secondName;
        return $this;
    }

    /**
     * Метод возвращает телефон пользователя.
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Метод задает телефон пользователя.
     *
     * @param integer|null $phone Значение для установки.
     *
     * @return static
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Метод возвращает email пользователя.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Метод задает email пользователя.
     *
     * @param string $email Значение для установки.
     *
     * @return static
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Определение наименования атрибутов.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return array_merge_recursive(parent::attributeLabels(), [
            'firstName'  => Yii::t('User.Admin.ProfileForm', 'firstName', 'Имя'),
            'lastName'   => Yii::t('User.Admin.ProfileForm', 'lastName', 'Фамилия'),
            'secondName' => Yii::t('User.Admin.ProfileForm', 'secondName', 'Отчество'),
            'email'      => Yii::t('User.Admin.ProfileForm', 'email', 'E-mail адрес'),
            'phone'      => Yii::t('User.Admin.ProfileForm', 'phone', 'Телефон'),
        ]);
    }

    /**
     * Определение правил валидации формы профиля пользователя.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'firstName',
                    'lastName',
                    'phone',
                ],
                'required',
            ],
            [
                [
                    'firstName',
                    'lastName',
                    'secondName',
                ],
                'string',
                'max' => 50,
            ],
            [
                ['email'],
                'string',
                'max' => 100,
            ],
            [
                ['email'],
                'email',
            ],
            [
                ['phone'],
                'filter',
                'filter' => function($value) {
                    return preg_replace('/\D+/', '', $value);
                },
            ],
            [
                ['phone'],
                'match',
                'pattern' => '/^(?:\+?\d{11,12}|\+?\d\s?\(\d{3}\)\s\d{3}(?:\-\d{2}){2})$/',
            ],
        ];
    }

    /**
     * Метод устанавливает и инициирует форму редактирования профиля пользователя.
     *
     * @param UserProfileActiveRecord $userProfile редактируемый профиль пользователя.
     *
     * @return static
     */
    public function setEditEntity(UserProfileActiveRecord $userProfile)
    {
        $this->userProfile = $userProfile;

        $this->setAttributes($userProfile->getAttributes(), false);

        $this->userAuth = [];
        foreach ($this->userProfile->auth as $auth) {
            $this->userAuth[$auth->id] = Yii::createObject(AuthForm::class);
            $this->userAuth[$auth->id]->setAttributes($auth->getAttributes(), false);
            $this->userAuth[$auth->id]->canChangeLogin    = $auth->canChangeLogin();
            $this->userAuth[$auth->id]->canChangePassword = $auth->canChangePassword();
        }

        return $this;
    }

    /**
     * Перегруженный метод родителя. Необходим для заполнения AuthForm`ы данными.
     *
     * @param array|mixed $data     данные полученные от пользователя.
     * @param string|null $formName имя формы.
     *
     * @return boolean
     */
    public function load($data, $formName = null)
    {
        $authEnabled = false;
        foreach ($this->userProfile->auth as $auth) {
            if (($authEnabled = $auth->canChangeLogin()) || $auth->canChangePassword()) {
                break;
            }
        }

        return parent::load($data, $formName) && (! $authEnabled || AuthForm::loadMultiple($this->userAuth, $data));
    }

    /**
     * Перегруженный метод валидации формы, необходим для валидации подчиненной AuthForm формы.
     *
     * @param array|null|null $attributeNames список проверяемых атрибутов.
     * @param boolean         $clearErrors    флаг, сообщающий, что необходимо очистить предыдущие ошибки.
     *
     * @throws InvalidParamException не найден сценарий для валидации.
     *
     * @return boolean
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        return parent::validate($attributeNames, $clearErrors) && AuthForm::validateMultiple($this->userAuth);
    }

    /**
     * Основной метод, осуществляет валидацию данных и сохраняет значения форм.
     *
     * @return boolean
     */
    public function updateProfile()
    {
        if ($this->validate()) {
            $this->userProfile->setAttributes($this->getAttributes(), false);
            $result = $this->userProfile->save(false);
            if (! $result) {
                return $result;
            }
            foreach ($this->userProfile->auth as $auth) {
                if (! isset($this->userAuth[$auth->id])) {
                    continue;
                }
                $updateFields = [];
                if ($auth->canChangeLogin()) {
                    $updateFields[] = 'login';
                }
                if (! empty($this->userAuth[$auth->id]->password) && $auth->canChangePassword()) {
                    $updateFields[]                          = 'passwordHash';
                    $this->userAuth[$auth->id]->passwordHash = Yii::$app->security->generatePasswordHash($this->userAuth[$auth->id]->password);
                }
                if (! empty($updateFields)) {
                    $auth->setAttributes($this->userAuth[$auth->id]->getAttributes(), false);
                    $result = $auth->save(false, $updateFields);
                    if (! $result) {
                        return $result;
                    }
                }
            }
            return true;
        }

        return false;
    }

    /**
     * Геттер, возвращает пары аутентификации редактируемого профиля.
     *
     * @return AuthForm[]
     */
    public function getAuthForms()
    {
        return $this->userAuth;
    }
}
