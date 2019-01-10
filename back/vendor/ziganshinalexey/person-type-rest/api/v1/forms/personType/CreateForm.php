<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\api\v1\forms\personType;

use Userstory\Yii2Forms\forms\rest\AbstractCreateRestForm;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;
use Ziganshinalexey\PersonType\traits\personType\PersonTypeComponentTrait;

/**
 * Форма данных для REST-метода создания сущности "Тип личности".
 */
class CreateForm extends AbstractCreateRestForm
{
    use PersonTypeComponentTrait;

    /**
     * Метод возвращает объект ДТО для работы с формой.
     *
     * @throws InvalidConfigException Генерирует если прототип формы не задан.
     *
     * @return PersonTypeInterface
     */
    public function getPrototype(): PersonTypeInterface
    {
        if (! $this->prototype instanceof PersonTypeInterface) {
            throw new InvalidConfigException(' Property "$this->prototype" must implement interface PersonTypeInterface::class');
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
     * @return PersonTypeInterface|null
     */
    public function run(array $params = []): ?PersonTypeInterface
    {
        if (! $this->validate()) {
            return null;
        }

        $result = $this->getPersonTypeComponent()->createOne($this->getPrototype())->doOperation();
        $item   = $result->getPersonType();
        if (null !== $item && ! $result->isSuccess()) {
            $this->addErrors($item->getErrors());
            return null;
        }

        return $item;
    }
}
