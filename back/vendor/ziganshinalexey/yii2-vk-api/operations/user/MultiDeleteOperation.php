<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\operations\user;

use Userstory\ComponentBase\events\DeleteOperationEvent;
use Userstory\Database\traits\ObjectWithDbConnectionTrait;
use Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait;
use yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\Command;
use yii\db\Exception;
use Ziganshinalexey\Yii2VkApi\entities\UserActiveRecord;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\OperationResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\MultiDeleteOperationInterface;
use function is_int;

/**
 * Операция удаления экземпляра сущности "ВК пользователь".
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
     * Задает критерий фильтрации выборки по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $facultyName Атрибут "Факультет" сущности "ВК пользователь".
     *
     * @return MultiDeleteOperationInterface
     */
    public function byFacultyName(string $facultyName): MultiDeleteOperationInterface
    {
        $this->filter = array_merge($this->filter, ['facultyName' => $facultyName]);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Имя" сущности "ВК пользователь".
     *
     * @param string $firstName Атрибут "Имя" сущности "ВК пользователь".
     *
     * @return MultiDeleteOperationInterface
     */
    public function byFirstName(string $firstName): MultiDeleteOperationInterface
    {
        $this->filter = array_merge($this->filter, ['firstName' => $firstName]);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "ВК пользователь".
     *
     * @param int $id Атрибут "Идентификатор" сущности "ВК пользователь".
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
     * Задает критерий фильтрации выборки по атрибуту "Фамилия" сущности "ВК пользователь".
     *
     * @param string $lastName Атрибут "Фамилия" сущности "ВК пользователь".
     *
     * @return MultiDeleteOperationInterface
     */
    public function byLastName(string $lastName): MultiDeleteOperationInterface
    {
        $this->filter = array_merge($this->filter, ['lastName' => $lastName]);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $photo Атрибут "Факультет" сущности "ВК пользователь".
     *
     * @return MultiDeleteOperationInterface
     */
    public function byPhoto(string $photo): MultiDeleteOperationInterface
    {
        $this->filter = array_merge($this->filter, ['photo' => $photo]);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Университет" сущности "ВК пользователь".
     *
     * @param string $universityName Атрибут "Университет" сущности "ВК пользователь".
     *
     * @return MultiDeleteOperationInterface
     */
    public function byUniversityName(string $universityName): MultiDeleteOperationInterface
    {
        $this->filter = array_merge($this->filter, ['universityName' => $universityName]);
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
        return $this->getDbConnection()->createCommand()->delete(UserActiveRecord::tableName(), $filter);
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
