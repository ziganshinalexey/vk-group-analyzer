<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\api\v1\forms\keyword;

use Userstory\ComponentBase\exceptions\NotFoundException;
use Userstory\Yii2Forms\forms\rest\AbstractUpdateRestForm;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\traits\keyword\KeywordComponentTrait;

/**
 * Форма данных для REST-метода обновления сущности "Ключевое фраза".
 */
class UpdateForm extends AbstractUpdateRestForm
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
            throw new InvalidConfigException(__METHOD__ . '() Прототип для формы не задан.');
        }
        return $this->prototype;
    }

    /**
     * Осуществлет основное действие формы - добавление элемента.
     *
     * @param array $params Параметры формы для выполнения её действия.
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     * @throws NotFoundException      Если сущность не найдена.
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

        if (! $this->getKeywordComponent()->findOne()->byId($this->getId())->doOperation()) {
            throw new NotFoundException('Сущность не найдена', 404);
        }

        $result = $this->getKeywordComponent()->updateOne($this->getPrototype())->doOperation();

        if (! $result->isSuccess()) {
            $this->addErrors($result->getErrors());
            return null;
        }

        return $this->getKeywordComponent()->findOne()->byId($this->getId())->doOperation();
    }
}
