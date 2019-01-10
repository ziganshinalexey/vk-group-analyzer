<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\api\v1\forms\keyword;

use Userstory\Yii2Forms\forms\rest\AbstractCreateRestForm;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\traits\keyword\KeywordComponentTrait;

/**
 * Форма данных для REST-метода создания сущности "Ключевое фраза".
 */
class CreateForm extends AbstractCreateRestForm
{
    use KeywordComponentTrait;

    /**
     * Метод возвращает объект ДТО для работы с формой.
     *
     * @throws InvalidConfigException Генерирует если прототип формы не задан.
     *
     * @return KeywordInterface
     */
    public function getPrototype(): KeywordInterface
    {
        if (! $this->prototype instanceof KeywordInterface) {
            throw new InvalidConfigException(' Property "$this->prototype" must implement interface KeywordInterface::class');
        }
        return $this->prototype;
    }

    /**
     * Осуществлет основное действие формы - добавление элемента.
     *
     * @param array $params Параметры формы для выполнения её действия.
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @inherit
     *
     * @return KeywordInterface|null
     */
    public function run(array $params = []): ?KeywordInterface
    {
        if (! $this->validate()) {
            return null;
        }

        $result = $this->getKeywordComponent()->createOne($this->getPrototype())->doOperation();
        $item   = $result->getKeyword();
        if (null !== $item && ! $result->isSuccess()) {
            $this->addErrors($item->getErrors());
            return null;
        }

        return $item;
    }
}
