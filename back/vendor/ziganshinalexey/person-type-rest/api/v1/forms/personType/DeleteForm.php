<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\api\v1\forms\personType;

use Userstory\ComponentBase\exceptions\NotFoundException;
use Userstory\Yii2Forms\forms\rest\AbstractDeleteRestForm;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;
use Ziganshinalexey\PersonType\traits\personType\PersonTypeComponentTrait;

/**
 * Форма данных для REST-метода удаления сущности "Тип личности".
 */
class DeleteForm extends AbstractDeleteRestForm
{
    use PersonTypeComponentTrait;

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
     * @return PersonTypeInterface|null
     */
    public function run(array $params = []): ?PersonTypeInterface
    {
        if (! $this->validate()) {
            return null;
        }

        if (! $item = $this->getPersonTypeComponent()->findOne()->byId($this->getId())->doOperation()) {
            throw new NotFoundException('Сущность не найдена', 404);
        }

        $result = $this->getPersonTypeComponent()->deleteMany()->byId([$this->getId()])->doOperation();
        if (! $result->isSuccess()) {
            $this->addErrors($result->getErrors());
            return null;
        }

        return $item;
    }
}
