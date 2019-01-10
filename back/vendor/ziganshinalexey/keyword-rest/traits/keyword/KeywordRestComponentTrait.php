<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\traits\keyword;

use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\KeywordRest\interfaces\keyword\RestComponentInterface;

/**
 * Трейт, содержащий логику доступа к компоненту "Ключевое фраза".
 */
trait KeywordRestComponentTrait
{
    /**
     * Экземпляр объекта компонента "Ключевое фраза".
     *
     * @var RestComponentInterface|null
     */
    protected $keywordRestComponent;

    /**
     * Метод возвращает объект компонента "Ключевое фраза".
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return RestComponentInterface
     */
    public function getKeywordRestComponent(): RestComponentInterface
    {
        if (! $this->keywordRestComponent) {
            $this->keywordRestComponent = Yii::$app->get('keywordRest');
        }
        return $this->keywordRestComponent;
    }

    /**
     * Метод устанавливает объект компонента "Ключевое фраза".
     *
     * @param RestComponentInterface $component Новое значение компонента.
     *
     * @return void
     */
    public function setKeywordRestComponent(RestComponentInterface $component): void
    {
        $this->keywordRestComponent = $component;
    }
}
