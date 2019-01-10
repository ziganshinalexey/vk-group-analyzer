<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\api\v1\forms\keyword;

use Userstory\ComponentBase\exceptions\NotFoundException;
use Userstory\Yii2Forms\forms\rest\AbstractDeleteRestForm;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\traits\keyword\KeywordComponentTrait;

/**
 * Форма данных для REST-метода удаления сущности "Ключевое фраза".
 */
class DeleteForm extends AbstractDeleteRestForm
{
    use KeywordComponentTrait;

    /**
     * Осуществлет основное действие формы - удаление элемента.
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

        if (! $item = $this->getKeywordComponent()->findOne()->byId($this->getId())->doOperation()) {
            throw new NotFoundException('Сущность не найдена', 404);
        }

        $result = $this->getKeywordComponent()->deleteMany()->byId([$this->getId()])->doOperation();
        if (! $result->isSuccess()) {
            $this->addErrors($result->getErrors());
            return null;
        }

        return $item;
    }
}
