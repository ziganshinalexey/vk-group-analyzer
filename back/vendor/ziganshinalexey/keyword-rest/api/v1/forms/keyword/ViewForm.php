<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\api\v1\forms\keyword;

use Userstory\ComponentBase\exceptions\NotFoundException;
use Userstory\Yii2Forms\forms\rest\AbstractViewRestForm;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\traits\keyword\KeywordComponentTrait;

/**
 * Форма данных для REST-метода выборки сущности "Ключевое фраза".
 */
class ViewForm extends AbstractViewRestForm
{
    use KeywordComponentTrait;

    /**
     * Осуществлет основное действие формы - просмотр элемента.
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

        $item = $this->getKeywordComponent()->findOne()->byId($this->getId())->doOperation();
        if (! $item) {
            throw new NotFoundException('Сущность не найдена', 404);
        }

        return $item;
    }
}
