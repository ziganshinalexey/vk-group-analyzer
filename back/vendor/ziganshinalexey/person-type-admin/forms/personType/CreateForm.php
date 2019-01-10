<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeAdmin\forms\personType;

use Userstory\Yii2Forms\forms\AbstractCreateForm;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonType\entities\PersonTypeActiveRecord;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;
use Ziganshinalexey\PersonType\traits\personType\PersonTypeComponentTrait;
use Ziganshinalexey\PersonType\validators\personType\PersonTypeValidator;
use function array_merge;

/**
 * Класс формы для создания сущности "Тип личности".
 */
class CreateForm extends AbstractCreateForm
{
    use PersonTypeComponentTrait;

    /**
     * Возвращает первый элемент из списка созданных.
     *
     * @param mixed $result Результат выполнения операции.
     *
     * @return PersonTypeInterface
     */
    public function getResultItem($result): PersonTypeInterface
    {
        return $result->getPersonType();
    }

    /**
     * Инициализация объекта формы обновления.
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return void
     */
    public function init(): void
    {
        parent::init();
        $this->setDtoComponent($this->getPersonTypeComponent());
        $this->setActiveRecordClass(PersonTypeActiveRecord::class);
    }

    /**
     * Данный метод возвращает массив, содержащий правила валидации атрибутов.
     *
     * @return array
     */
    public function rules(): array
    {
        return PersonTypeValidator::getRules();
    }
}
