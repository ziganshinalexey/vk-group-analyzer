<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\operations\user;

use Userstory\ComponentBase\events\CreateOperationEvent;
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
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\SingleCreateOperationInterface;
use Ziganshinalexey\Yii2VkApi\traits\user\DatabaseHydratorTrait;

/**
 * Операция создания новой сущности "ВК пользователь".
 */
class SingleCreateOperation extends Component implements SingleCreateOperationInterface
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
     * Сущности, над которыми нужно выполнить операцию.
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
     * Метод подготавливает запрос для добавления сущности в базу данных.
     *
     * @param UserInterface $item Список сущностей для вставки в базу данных.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return Command
     */
    protected function createInsertQuery(UserInterface $item): Command
    {
        $hydrator   = $this->getUserDatabaseHydrator();
        $insertData = $hydrator->extract($item);

        return $this->getDbConnection()->createCommand()->insert(UserActiveRecord::tableName(), $insertData);
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
        $item   = $this->getUser();
        $result->setUser($item);

        if (! $this->validateUser($item)) {
            $result->addError('system', 'Item contains invalid data');
            return $result;
        }

        $transaction = $this->getDbConnection()->beginTransaction();

        $insertCommand = $this->createInsertQuery($item);
        if (! $insertCommand->execute()) {
            $transaction->rollBack();
            $result->addError('User', 'Can not insert item list in database');
            return $result;
        }
        $this->flushCache();
        $lastInsertedId = (int)$this->getDbConnection()->getLastInsertID();
        $item->setId($lastInsertedId);

        $event = Yii::createObject([
            'class'                  => CreateOperationEvent::class,
            'dataTransferObjectList' => [$this->getUser()],
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
     * Метод возвращает сущности, над которыми нужно выполнить операцию.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        if (null === $this->user) {
            throw new InvalidConfigException(__METHOD__ . '() Item can not be empty');
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
     * @return SingleCreateOperationInterface
     */
    public function setResultPrototype(OperationResultInterface $value): SingleCreateOperationInterface
    {
        $this->resultPrototype = $value;
        return $this;
    }

    /**
     * Метод устанавливает сущности, над которыми необходимо выполнить операцию.
     *
     * @param UserInterface $item Новое значение.
     *
     * @throws InvalidConfigException В случае если в аргументе что-то отличное от UserInterface.
     *
     * @return SingleCreateOperationInterface
     */
    public function setUser(UserInterface $item): SingleCreateOperationInterface
    {
        if (! $item instanceof UserInterface) {
            throw new InvalidConfigException(__METHOD__ . '() Can set only objects, witch implement ' . UserInterface::class);
        }
        $this->user = $item;
        return $this;
    }

    /**
     * Метод устанавливает валидатор ДТО сущности.
     *
     * @param DTOValidatorInterface $validator Новое значение.
     *
     * @return SingleCreateOperationInterface
     */
    public function setUserValidator(DTOValidatorInterface $validator): SingleCreateOperationInterface
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * Метод выполняет валидацию переданного списка сущностей.
     *
     * @param UserInterface $item Список сущностей для валидации.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return bool
     */
    protected function validateUser(UserInterface $item): bool
    {
        $result    = true;
        $validator = $this->getUserValidator();

        if (! $validator->validateObject($item)) {
            $item->addErrors($validator->getErrors());
            $result = false;
        }

        return $result;
    }
}
