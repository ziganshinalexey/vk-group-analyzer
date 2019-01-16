<?php

declare(strict_types = 1);

namespace app\api\v1\forms\vk;

use yii\base\InvalidConfigException;
use yii\base\Model;
use Ziganshinalexey\Yii2VkApi\traits\user\UserComponentTrait;
use function preg_match;
use function strripos;
use function substr;

/**
 * Форма данных для REST-метода выборки сущности "Ключевое фраза".
 */
class AnalyzeForm extends Model
{
    use UserComponentTrait;

    /**
     * Свойство содержит урл пользователя в вк.
     *
     * @var string|null
     */
    protected $vkUrl;

    /**
     * Метод возвращает урл пользователя в вк.
     *
     * @return string|null
     */
    public function getVkUrl(): ?string
    {
        return $this->vkUrl;
    }

    /**
     * Переопределенный метод возвращает правила валидации формы.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                'vkUrl',
                'required',
            ],
            [
                'vkUrl',
                'string',
                'max' => 255,
            ],
            [
                'vkUrl',
                'customVkUrlValidate',
            ],
        ];
    }

    /**
     * Кастомный метод валидации урла пользователя.
     *
     * @param string $attribute Название атрибута.
     *
     * @return void
     */
    public function customVkUrlValidate(string $attribute): void
    {
        if (! preg_match('/^https:\/\/vk.com\/[a-z0-9_]{5,32}$/i', $this->$attribute)) {
            $this->addError($attribute, 'Ссылка неверно указана.');
        }
    }

    /**
     * Осуществлет основное действие формы - просмотр элемента.
     *
     * @return array|null
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     */
    public function run(): ?array
    {
        if (! $this->validate()) {
            return null;
        }

        $userId = $this->parseUserScreenName();
        $result = $this->getUserComponent()->findMany()->setUserScreenName($userId)->doOperation();
        if (! $result->isSuccess()) {
            $this->addErrors($result->getYiiErrors());
            return null;
        }

        $userList = $result->getDtoList();
        return [
            'user' => array_shift($userList),
        ];
    }

    protected function parseUserScreenName()
    {
        return substr((string)$this->getVkUrl(), strripos((string)$this->getVkUrl(), '/') + 1);
    }
}
