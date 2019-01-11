<?php

declare(strict_types = 1);

namespace app\api\v1\forms\vk;

use yii\base\Model;

/**
 * Форма данных для REST-метода выборки сущности "Ключевое фраза".
 */
class AnalyzeForm extends Model
{
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
        if (false === preg_match('/^https:\/\/vk.com\/[a-z0-9_]{5,32}$/i', $this->$attribute)) {
            $this->addError($attribute, 'Ссылка неверно указана.');
        }
    }

    /**
     * Осуществлет основное действие формы - просмотр элемента.
     *
     * @return null
     */
    public function run()
    {
        if (! $this->validate()) {
            return null;
        }

        return null;
    }
}
