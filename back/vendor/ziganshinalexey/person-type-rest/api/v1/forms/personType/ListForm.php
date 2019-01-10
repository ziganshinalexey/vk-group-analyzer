<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\api\v1\forms\personType;

use Userstory\Yii2Exceptions\exceptions\typeMismatch\ExtendsMismatchException;
use Userstory\Yii2Forms\forms\rest\AbstractListRestForm;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;
use Ziganshinalexey\PersonType\interfaces\personType\filters\MultiFilterInterface;
use Ziganshinalexey\PersonType\traits\personType\PersonTypeComponentTrait;
use Ziganshinalexey\PersonTypeRest\interfaces\personType\ListFormInterface;
use function count;

/**
 * Форма данных для REST-метода выборки списка сущностей "Тип личности".
 */
class ListForm extends AbstractListRestForm implements ListFormInterface
{
    use PersonTypeComponentTrait;

    /**
     * Метод возвращает объект фильтра для формы выборки.
     *
     * @throws InvalidConfigException Генерирует в случае отсутствия фильта.
     *
     * @return MultiFilterInterface
     */
    public function getFilter(): MultiFilterInterface
    {
        if (null === $this->filter) {
            throw new InvalidConfigException(__METHOD__ . '() Фильтр формы должен быть задан . ');
        }
        if (! $this->filter instanceof MultiFilterInterface) {
            throw new InvalidConfigException(__METHOD__ . '() Класс фильтра должен реализовать ' . MultiFilterInterface::class);
        }
        return $this->filter;
    }

    /**
     * Осуществлет основное действие формы - добавление элемента.
     *
     * @param array $params Параметры формы для выполнения её действия.
     *
     * @throws ExtendsMismatchException Исключение генерируется в случае, если передан ДТО неподдерживаемого типа.
     * @throws InvalidConfigException   Если компонент не зарегистрирован.
     *
     * @inherit
     *
     * @return PersonTypeInterface[]|null
     */
    public function run(array $params = [])
    {
        if (! $this->getFilterValidator()->validateObject($this->getFilter())) {
            $this->addErrors($this->getFilterValidator()->getErrors());
            return null;
        }

        $findOperation = $this->getPersonTypeComponent()->findMany();
        $this->getFilter()->applyFilter($findOperation);
        $list = $findOperation->sortById()->doOperation();

        if ($this->getFilter()->getLimit() && count($list) > $this->getFilter()->getLimit()) {
            $this->more = true;
            array_pop($list);
        } else {
            $this->more = false;
        }

        return $list;
    }
}
