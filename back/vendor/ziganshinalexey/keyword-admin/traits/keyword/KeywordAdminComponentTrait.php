<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordAdmin\traits\keyword;

use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\KeywordAdmin\interfaces\keyword\AdminComponentInterface;

/**
 * Трейт, содержащий логику доступа к компоненту админки "Ключевое фраза".
 */
trait KeywordAdminComponentTrait
{
    /**
     * Экземпляр объекта компонента админки "Ключевое фраза".
     *
     * @var AdminComponentInterface|null
     */
    protected $keywordAdminComponent;

    /**
     * Метод возвращает объект компонента админки "Ключевое фраза".
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return AdminComponentInterface
     */
    public function getKeywordAdminComponent(): AdminComponentInterface
    {
        if (! $this->keywordAdminComponent) {
            $this->keywordAdminComponent = Yii::$app->get('keywordAdmin');
        }
        return $this->keywordAdminComponent;
    }

    /**
     * Метод устанавливает объект компонента "Ключевое фраза".
     *
     * @param AdminComponentInterface $component Новое значение компонента.
     *
     * @return void
     */
    public function setKeywordAdminComponent(AdminComponentInterface $component): void
    {
        $this->keywordAdminComponent = $component;
    }
}
