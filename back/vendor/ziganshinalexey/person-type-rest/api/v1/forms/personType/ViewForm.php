<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\api\v1\forms\personType;

use Userstory\ComponentBase\exceptions\NotFoundException;
use Userstory\Yii2Forms\forms\rest\AbstractViewRestForm;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;
use Ziganshinalexey\PersonType\traits\personType\PersonTypeComponentTrait;

/**
 * Форма данных для REST-метода выборки сущности "Тип личности".
 */
class ViewForm extends AbstractViewRestForm
{
    use PersonTypeComponentTrait;

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
     * @return PersonTypeInterface|null
     */
    public function run(array $params = []): ?PersonTypeInterface
    {
        if (! $this->validate()) {
            return null;
        }

        $item = $this->getPersonTypeComponent()->findOne()->byId($this->getId())->doOperation();
        if (! $item) {
            throw new NotFoundException('Сущность не найдена', 404);
        }

        return $item;
    }
}
