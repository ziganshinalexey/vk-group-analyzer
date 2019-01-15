<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\operations\user;

use Userstory\ComponentBase\events\UpdateOperationEvent;
use Userstory\ComponentBase\interfaces\DTOValidatorInterface;
use Userstory\Database\traits\ObjectWithDbConnectionTrait;
use Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait;
use yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\Command;
use yii\db\Exception;
use Ziganshinalexey\Yii2VkApi\entities\UserActiveRecord;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\OperationResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\SingleUpdateOperationInterface;
use Ziganshinalexey\Yii2VkApi\traits\user\DatabaseHydratorTrait;

/**
 * Операция общновления имеющейся сущности "ВК пользователь".
 */
class SingleUpdateOperation extends Component implements SingleUpdateOperationInterface
{
    use ObjectWithDbConnectionTrait;
    use DatabaseHydratorTrait;
    use ObjectWithQueryCacheTrait;

    /**
     * Прототип объекта-ответа команды.
     *
     * @var OperationResultInterface|null
     */
    protected $resultPrototype;

    /**
     * Сущность, над которой нужно выполнить операцию.
     *
     * @var UserInterface|null
     */
    protected $user;

    /**
     * Объект-валидатора ДТО сущности.
     *
     * @var DTOValidatorInterface|null
     */
    protected $validator;

    /**
     * Метод подготавливает запрос для обновления сущности в базе данных.
     *
     * @param UserInterface $item Сущность для выполнения операции.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return Command
     */
    protected function createUpdateQuery(UserInterface $item): Command
    {
        $updateData = $this->getUserDatabaseHydrator()->extract($item);

        return $this->getDbConnection()->createCommand()->update(UserActiveRecord::tableName(), $updateData, [
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
        $item   = $this->getUser();
        $result->setUser($item);

        $validator = $this->getUserValidator();
        if (! $validator->validateObject($item)) {
            $item->addErrors($validator->getErrors());
            $result->addErrors($validator->getErrors());
            return $result;
        }

        $transaction = $this->getDbConnection()->beginTransaction();

        $updateCommand = $this->createUpdateQuery($item);
        if (! $updateCommand->execute()) {
            $transaction->rollBack();
            $result->addError('User', 'Can not update item in database');
            return $result;
        }
        $this->flushCache();

        $event = Yii::createObject([
            'class'              => UpdateOperationEvent::class,
            'dataTransferObject' => $this->getUser(),
        ]);
        $this->trigger(self::DO_EVENT, $event);
        $transaction->commit();
        return $result;
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
     * Метод возвращает сущность, над которой нужэно выполнить операцию.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        if (null === $this->user) {
            throw new InvalidConfigException(__METHOD__ . '() User can not be null');
        }
        return $this->user;
    }

    /**
     * Метод возвращает валидатор ДТО сущности.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return DTOValidatorInterface
     */
    public function getUserValidator(): DTOValidatorInterface
    {
        if (null === $this->validator) {
            throw new InvalidConfigException(__METHOD__ . '() Validator object can not be null');
        }
        return $this->validator;
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

    /**
     * Метод устанавливает сущность, над которой необходимо выполнить операцию.
     *
     * @param UserInterface $value Новое значение.
     *
     * @return SingleUpdateOperationInterface
     */
    public function setUser(UserInterface $value): SingleUpdateOperationInterface
    {
        $this->user = $value;
        return $this;
    }

    /**
     * Метод устанавливает валидатор ДТО сущности.
     *
     * @param DTOValidatorInterface $validator Новое значение.
     *
     * @return SingleUpdateOperationInterface
     */
    public function setUserValidator(DTOValidatorInterface $validator): SingleUpdateOperationInterface
    {
        $this->validator = $validator;
        return $this;
    }
}
