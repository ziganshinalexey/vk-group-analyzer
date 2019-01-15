<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\operations\group;

use Userstory\ComponentBase\events\UpdateOperationEvent;
use Userstory\ComponentBase\interfaces\DTOValidatorInterface;
use Userstory\Database\traits\ObjectWithDbConnectionTrait;
use Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait;
use yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\Command;
use yii\db\Exception;
use Ziganshinalexey\Yii2VkApi\entities\GroupActiveRecord;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\OperationResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\SingleUpdateOperationInterface;
use Ziganshinalexey\Yii2VkApi\traits\group\DatabaseHydratorTrait;

/**
 * Операция общновления имеющейся сущности "ВК группа".
 */
class SingleUpdateOperation extends Component implements SingleUpdateOperationInterface
{
    use ObjectWithDbConnectionTrait;
    use DatabaseHydratorTrait;
    use ObjectWithQueryCacheTrait;

    /**
     * Сущность, над которой нужно выполнить операцию.
     *
     * @var GroupInterface|null
     */
    protected $group;

    /**
     * Прототип объекта-ответа команды.
     *
     * @var OperationResultInterface|null
     */
    protected $resultPrototype;

    /**
     * Объект-валидатора ДТО сущности.
     *
     * @var DTOValidatorInterface|null
     */
    protected $validator;

    /**
     * Метод подготавливает запрос для обновления сущности в базе данных.
     *
     * @param GroupInterface $item Сущность для выполнения операции.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return Command
     */
    protected function createUpdateQuery(GroupInterface $item): Command
    {
        $updateData = $this->getGroupDatabaseHydrator()->extract($item);

        return $this->getDbConnection()->createCommand()->update(GroupActiveRecord::tableName(), $updateData, [
            'id' => $item->getId(),
        ]);
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
        $item   = $this->getGroup();
        $result->setGroup($item);

        $validator = $this->getGroupValidator();
        if (! $validator->validateObject($item)) {
            $item->addErrors($validator->getErrors());
            $result->addErrors($validator->getErrors());
            return $result;
        }

        $transaction = $this->getDbConnection()->beginTransaction();

        $updateCommand = $this->createUpdateQuery($item);
        if (! $updateCommand->execute()) {
            $transaction->rollBack();
            $result->addError('Group', 'Can not update item in database');
            return $result;
        }
        $this->flushCache();

        $event = Yii::createObject([
            'class'              => UpdateOperationEvent::class,
            'dataTransferObject' => $this->getGroup(),
        ]);
        $this->trigger(self::DO_EVENT, $event);
        $transaction->commit();
        return $result;
    }

    /**
     * Метод возвращает сущность, над которой нужэно выполнить операцию.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return GroupInterface
     */
    public function getGroup(): GroupInterface
    {
        if (null === $this->group) {
            throw new InvalidConfigException(__METHOD__ . '() Group can not be null');
        }
        return $this->group;
    }

    /**
     * Метод возвращает валидатор ДТО сущности.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return DTOValidatorInterface
     */
    public function getGroupValidator(): DTOValidatorInterface
    {
        if (null === $this->validator) {
            throw new InvalidConfigException(__METHOD__ . '() Validator object can not be null');
        }
        return $this->validator;
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
     * Метод устанавливает сущность, над которой необходимо выполнить операцию.
     *
     * @param GroupInterface $value Новое значение.
     *
     * @return SingleUpdateOperationInterface
     */
    public function setGroup(GroupInterface $value): SingleUpdateOperationInterface
    {
        $this->group = $value;
        return $this;
    }

    /**
     * Метод устанавливает валидатор ДТО сущности.
     *
     * @param DTOValidatorInterface $validator Новое значение.
     *
     * @return SingleUpdateOperationInterface
     */
    public function setGroupValidator(DTOValidatorInterface $validator): SingleUpdateOperationInterface
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * Метод устанавливает объект прототипа ответа команды.
     *
     * @param OperationResultInterface $value Новое значение.
     *
     * @return SingleUpdateOperationInterface
     */
    public function setResultPrototype(OperationResultInterface $value): SingleUpdateOperationInterface
    {
        $this->resultPrototype = $value;
        return $this;
    }
}
