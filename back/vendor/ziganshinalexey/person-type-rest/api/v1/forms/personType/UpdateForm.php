<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\api\v1\forms\personType;

use Userstory\ComponentBase\exceptions\NotFoundException;
use Userstory\Yii2Forms\forms\rest\AbstractUpdateRestForm;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;
use Ziganshinalexey\PersonType\traits\personType\PersonTypeComponentTrait;

/**
 * Форма данных для REST-метода обновления сущности "Тип личности".
 */
class UpdateForm extends AbstractUpdateRestForm
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
     * @return PersonTypeInterface|null
     */
    public function run(array $params = []): ?PersonTypeInterface
    {
        if (! $this->validate()) {
            return null;
        }

        if (! $this->getPersonTypeComponent()->findOne()->byId($this->getId())->doOperation()) {
            throw new NotFoundException('Сущность не найдена', 404);
        }

        $result = $this->getPersonTypeComponent()->updateOne($this->getPrototype())->doOperation();

        if (! $result->isSuccess()) {
            $this->addErrors($result->getErrors());
            return null;
        }

        return $this->getPersonTypeComponent()->findOne()->byId($this->getId())->doOperation();
    }
}
