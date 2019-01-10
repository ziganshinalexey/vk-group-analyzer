<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\operations\keyword;

use Userstory\ComponentBase\events\CreateOperationEvent;
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
use Ziganshinalexey\Keyword\interfaces\keyword\operations\SingleCreateOperationInterface;
use Ziganshinalexey\Keyword\traits\keyword\DatabaseHydratorTrait;

/**
 * Операция создания новой сущности "Ключевое фраза".
 */
class SingleCreateOperation extends Component implements SingleCreateOperationInterface
{
    use ObjectWithDbConnectionTrait;
    use DatabaseHydratorTrait;
    use ObjectWithQueryCacheTrait;

    /**
     * Сущности, над которыми нужно выполнить операцию.
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
     * Метод подготавливает запрос для добавления сущности в базу данных.
     *
     * @param KeywordInterface $item Список сущностей для вставки в базу данных.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return Command
     */
    protected function createInsertQuery(KeywordInterface $item): Command
    {
        $hydrator   = $this->getKeywordDatabaseHydrator();
        $insertData = $hydrator->extract($item);

        return $this->getDbConnection()->createCommand()->insert(KeywordActiveRecord::tableName(), $insertData);
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
        $item   = $this->getKeyword();
        $result->setKeyword($item);

        if (! $this->validateKeyword($item)) {
            $result->addError('system', 'Item contains invalid data');
            return $result;
        }

        $transaction = $this->getDbConnection()->beginTransaction();

        $insertCommand = $this->createInsertQuery($item);
        if (! $insertCommand->execute()) {
            $transaction->rollBack();
            $result->addError('Keyword', 'Can not insert item list in database');
            return $result;
        }
        $this->flushCache();
        $lastInsertedId = (int)$this->getDbConnection()->getLastInsertID();
        $item->setId($lastInsertedId);

        $event = Yii::createObject([
            'class'                  => CreateOperationEvent::class,
            'dataTransferObjectList' => [$this->getKeyword()],
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
     * @return KeywordInterface
     */
    public function getKeyword(): KeywordInterface
    {
        if (null === $this->keyword) {
            throw new InvalidConfigException(__METHOD__ . '() Item can not be empty');
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
     * Метод устанавливает сущности, над которыми необходимо выполнить операцию.
     *
     * @param KeywordInterface $item Новое значение.
     *
     * @throws InvalidConfigException В случае если в аргументе что-то отличное от KeywordInterface.
     *
     * @return SingleCreateOperationInterface
     */
    public function setKeyword(KeywordInterface $item): SingleCreateOperationInterface
    {
        if (! $item instanceof KeywordInterface) {
            throw new InvalidConfigException(__METHOD__ . '() Can set only objects, witch implement ' . KeywordInterface::class);
        }
        $this->keyword = $item;
        return $this;
    }

    /**
     * Метод устанавливает валидатор ДТО сущности.
     *
     * @param DTOValidatorInterface $validator Новое значение.
     *
     * @return SingleCreateOperationInterface
     */
    public function setKeywordValidator(DTOValidatorInterface $validator): SingleCreateOperationInterface
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
     * @param KeywordInterface $item Список сущностей для валидации.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return bool
     */
    protected function validateKeyword(KeywordInterface $item): bool
    {
        $result    = true;
        $validator = $this->getKeywordValidator();

        if (! $validator->validateObject($item)) {
            $item->addErrors($validator->getErrors());
            $result = false;
        }

        return $result;
    }
}
