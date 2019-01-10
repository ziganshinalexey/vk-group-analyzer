<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\traits\keyword;

use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Keyword\interfaces\keyword\ComponentInterface;

/**
 * Трейт, содержащий логику доступа к компоненту "Ключевое фраза".
 */
trait KeywordComponentTrait
{
    /**
     * Экземпляр объекта компонента "Ключевое фраза".
     *
     * @var ComponentInterface|null
     */
    protected $keywordComponent;

    /**
     * Метод возвращает объект компонента "Ключевое фраза".
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return ComponentInterface
     */
    public function getKeywordComponent(): ComponentInterface
    {
        if (! $this->keywordComponent) {
            $this->keywordComponent = Yii::$app->get('keyword');
        }
        return $this->keywordComponent;
    }

    /**
     * Метод устанавливает объект компонента "Ключевое фраза".
     *
     * @param ComponentInterface $component Новое значение компонента.
     *
     * @return void
     */
    public function setKeywordComponent(ComponentInterface $component): void
    {
        $this->keywordComponent = $component;
    }
}
