<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\operations\keyword;

use Userstory\ComponentBase\events\UpdateOperationEvent;
use Userstory\ComponentBase\interfaces\DTOValidatorInterface;
use Userstory\Database\traits\ObjectWithDbConnectionTrait;
use Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait;
use yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\Command;
use yii\db\Exception;
use Ziganshinalexey\Keyword\entities\KeywordActiveRecord;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\OperationResultInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\SingleUpdateOperationInterface;
use Ziganshinalexey\Keyword\traits\keyword\DatabaseHydratorTrait;

/**
 * Операция общновления имеющейся сущности "Ключевое фраза".
 */
class SingleUpdateOperation extends Component implements SingleUpdateOperationInterface
{
    use ObjectWithDbConnectionTrait;
    use DatabaseHydratorTrait;
    use ObjectWithQueryCacheTrait;

    /**
     * Сущность, над которой нужно выполнить операцию.
     *
     * @var KeywordInterface|null
     */
    protected $keyword;

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
     * @param KeywordInterface $item Сущность для выполнения операции.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return Command
     */
    protected function createUpdateQuery(KeywordInterface $item): Command
    {
        $updateData = $this->getKeywordDatabaseHydrator()->extract($item);

        return $this->getDbConnection()->createCommand()->update(KeywordActiveRecord::tableName(), $updateData, [
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
        $item   = $this->getKeyword();
        $result->setKeyword($item);

        $validator = $this->getKeywordValidator();
        if (! $validator->validateObject($item)) {
            $item->addErrors($validator->getErrors());
            $result->addErrors($validator->getErrors());
            return $result;
        }

        $transaction = $this->getDbConnection()->beginTransaction();

        $updateCommand = $this->createUpdateQuery($item);
        if (! $updateCommand->execute()) {
            $transaction->rollBack();
            $result->addError('Keyword', 'Can not update item in database');
            return $result;
        }
        $this->flushCache();

        $event = Yii::createObject([
            'class'              => UpdateOperationEvent::class,
            'dataTransferObject' => $this->getKeyword(),
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
     * @return KeywordInterface
     */
    public function getKeyword(): KeywordInterface
    {
        if (null === $this->keyword) {
            throw new InvalidConfigException(__METHOD__ . '() Keyword can not be null');
        }
        return $this->keyword;
    }

    /**
     * Метод возвращает валидатор ДТО сущности.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return DTOValidatorInterface
     */
    public function getKeywordValidator(): DTOValidatorInterface
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
     * @param KeywordInterface $value Новое значение.
     *
     * @return SingleUpdateOperationInterface
     */
    public function setKeyword(KeywordInterface $value): SingleUpdateOperationInterface
    {
        $this->keyword = $value;
        return $this;
    }

    /**
     * Метод устанавливает валидатор ДТО сущности.
     *
     * @param DTOValidatorInterface $validator Новое значение.
     *
     * @return SingleUpdateOperationInterface
     */
    public function setKeywordValidator(DTOValidatorInterface $validator): SingleUpdateOperationInterface
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
