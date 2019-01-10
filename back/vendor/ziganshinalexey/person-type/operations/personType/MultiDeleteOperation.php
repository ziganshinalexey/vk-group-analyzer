<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\operations\personType;

use Userstory\ComponentBase\events\DeleteOperationEvent;
use Userstory\Database\traits\ObjectWithDbConnectionTrait;
use Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait;
use yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\Command;
use yii\db\Exception;
use Ziganshinalexey\PersonType\entities\PersonTypeActiveRecord;
use Ziganshinalexey\PersonType\interfaces\personType\dto\OperationResultInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\MultiDeleteOperationInterface;
use function is_int;

/**
 * Операция удаления экземпляра сущности "Тип личности".
 */
class MultiDeleteOperation extends Component implements MultiDeleteOperationInterface
{
    use ObjectWithDbConnectionTrait;
    use ObjectWithQueryCacheTrait;

    /**
     * Фильтр для удаления данных.
     *
     * @var array
     */
    protected $filter = [];

    /**
     * Прототип объекта-ответа команды.
     *
     * @var OperationResultInterface|null
     */
    protected $resultPrototype;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "Тип личности".
     *
     * @param int $id Атрибут "Идентификатор" сущности "Тип личности".
     *
     * @return MultiDeleteOperationInterface
     */
    public function byId(int $id): MultiDeleteOperationInterface
    {
        $this->filter = array_merge($this->filter, ['id' => $id]);
        return $this;
    }

    /**
     * Дообваляет фильтр для удаления по ИД.
     *
     * @param array $id Список ИД для удаления.
     *
     * @throws InvalidConfigException Исключение генерируется в случае если список передан в неверном формате.
     *
     * @return MultiDeleteOperationInterface
     */
    public function byIds(array $id): MultiDeleteOperationInterface
    {
        foreach ($id as $item) {
            if (! is_int($item)) {
                throw new InvalidConfigException(__METHOD__ . '() Id list must contains only integer values');
            }
        }
        $this->filter = array_merge($this->filter, ['id' => $id]);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "Тип личности".
     *
     * @param string $name Атрибут "Название" сущности "Тип личности".
     *
     * @return MultiDeleteOperationInterface
     */
    public function byName(string $name): MultiDeleteOperationInterface
    {
        $this->filter = array_merge($this->filter, ['name' => $name]);
        return $this;
    }

    /**
     * Метод подготавливает запрос для удаления сущности из базы данных.
     *
     * @param array $filter Фильтр для создания команды удаления.
     *
     * @return Command
     */
    protected function createDeleteQuery(array $filter): Command
    {
        return $this->getDbConnection()->createCommand()->delete(PersonTypeActiveRecord::tableName(), $filter);
    }

    /**
     * Метод выполняет операцию.
     *
     * @throws Exception              Если выполнение команды не удалось.
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return OperationResultInterface
     */
    public function doOperation(): OperationResultInterface
    {
        $result = $this->getResultPrototype();

        $transaction = $this->getDbConnection()->beginTransaction();
        $this->createDeleteQuery($this->getFilter())->execute();
        $this->flushCache();

        $event = Yii::createObject([
            'class'        => DeleteOperationEvent::class,
            'deleteFilter' => $this->getFilter(),
        ]);
        $this->trigger(self::DO_EVENT, $event);
        $transaction->commit();
        return $result;
    }

    /**
     * Метод возвращает фильтр для удаления.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return array
     */
    protected function getFilter(): array
    {
        if (empty($this->filter)) {
            throw new InvalidConfigException(__METHOD__ . '() Filter can not be empty');
        }
        return $this->filter;
    }

    /**
     * Метод возвращает объект-результат ответа команды.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return OperationResultInterface
     */
    public function getResultPrototype(): OperationResultInterface
    {
        if (null === $this->resultPrototype) {
            throw new InvalidConfigException(__METHOD__ . '() Operation result object can not be null');
        }
        return $this->resultPrototype;
    }

    /**
     * Метод устанавливает объект прототипа ответа команды.
     *
     * @param OperationResultInterface $value Новое значение.
     *
     * @return MultiDeleteOperationInterface
     */
    public function setResultPrototype(OperationResultInterface $value): MultiDeleteOperationInterface
    {
        $this->resultPrototype = $value;
        return $this;
    }
}
