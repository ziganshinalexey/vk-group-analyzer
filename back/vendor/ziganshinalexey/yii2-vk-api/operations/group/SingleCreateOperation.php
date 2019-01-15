<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\operations\group;

use Userstory\ComponentBase\events\CreateOperationEvent;
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
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\SingleCreateOperationInterface;
use Ziganshinalexey\Yii2VkApi\traits\group\DatabaseHydratorTrait;

/**
 * Операция создания новой сущности "ВК группа".
 */
class SingleCreateOperation extends Component implements SingleCreateOperationInterface
{
    use ObjectWithDbConnectionTrait;
    use DatabaseHydratorTrait;
    use ObjectWithQueryCacheTrait;

    /**
     * Сущности, над которыми нужно выполнить операцию.
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
     * Метод подготавливает запрос для добавления сущности в базу данных.
     *
     * @param GroupInterface $item Список сущностей для вставки в базу данных.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return Command
     */
    protected function createInsertQuery(GroupInterface $item): Command
    {
        $hydrator   = $this->getGroupDatabaseHydrator();
        $insertData = $hydrator->extract($item);

        return $this->getDbConnection()->createCommand()->insert(GroupActiveRecord::tableName(), $insertData);
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
        $result = $this->getResultPrototype()->copy();
        $item   = $this->getGroup();
        $result->setGroup($item);

        if (! $this->validateGroup($item)) {
            $result->addError('system', 'Item contains invalid data');
            return $result;
        }

        $transaction = $this->getDbConnection()->beginTransaction();

        $insertCommand = $this->createInsertQuery($item);
        if (! $insertCommand->execute()) {
            $transaction->rollBack();
            $result->addError('Group', 'Can not insert item list in database');
            return $result;
        }
        $this->flushCache();
        $lastInsertedId = (int)$this->getDbConnection()->getLastInsertID();
        $item->setId($lastInsertedId);

        $event = Yii::createObject([
            'class'                  => CreateOperationEvent::class,
            'dataTransferObjectList' => [$this->getGroup()],
        ]);
        $this->trigger(self::DO_EVENT, $event);
        $transaction->commit();
        return $result;
    }

    /**
     * Метод возвращает сущности, над которыми нужно выполнить операцию.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return GroupInterface
     */
    public function getGroup(): GroupInterface
    {
        if (null === $this->group) {
            throw new InvalidConfigException(__METHOD__ . '() Item can not be empty');
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
     * Метод устанавливает сущности, над которыми необходимо выполнить операцию.
     *
     * @param GroupInterface $item Новое значение.
     *
     * @throws InvalidConfigException В случае если в аргументе что-то отличное от GroupInterface.
     *
     * @return SingleCreateOperationInterface
     */
    public function setGroup(GroupInterface $item): SingleCreateOperationInterface
    {
        if (! $item instanceof GroupInterface) {
            throw new InvalidConfigException(__METHOD__ . '() Can set only objects, witch implement ' . GroupInterface::class);
        }
        $this->group = $item;
        return $this;
    }

    /**
     * Метод устанавливает валидатор ДТО сущности.
     *
     * @param DTOValidatorInterface $validator Новое значение.
     *
     * @return SingleCreateOperationInterface
     */
    public function setGroupValidator(DTOValidatorInterface $validator): SingleCreateOperationInterface
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * Метод устанавливает объект прототипа ответа команды.
     *
     * @param OperationResultInterface $value Новое значение.
     *
     * @return SingleCreateOperationInterface
     */
    public function setResultPrototype(OperationResultInterface $value): SingleCreateOperationInterface
    {
        $this->resultPrototype = $value;
        return $this;
    }

    /**
     * Метод выполняет валидацию переданного списка сущностей.
     *
     * @param GroupInterface $item Список сущностей для валидации.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return bool
     */
    protected function validateGroup(GroupInterface $item): bool
    {
        $result    = true;
        $validator = $this->getGroupValidator();

        if (! $validator->validateObject($item)) {
            $item->addErrors($validator->getErrors());
            $result = false;
        }

        return $result;
    }
}
