<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\filters\user;

use Userstory\ComponentBase\traits\FilterTrait;
use Ziganshinalexey\Yii2VkApi\interfaces\user\filters\MultiFilterInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\filters\MultiFilterOperationInterface;

/**
 * Класс реализует методы применения фильтра к операции.
 */
class MultiFilter extends BaseFilter implements MultiFilterInterface
{
    use FilterTrait;

    /**
     * Метод применяет фильтр к операции над списком сущностей.
     *
     * @param MultiFilterOperationInterface $operation Обект реализующий методы фильтров операции.
     *
     * @return MultiFilterOperationInterface
     */
    public function applyFilter(MultiFilterOperationInterface $operation): MultiFilterOperationInterface
    {
        if ($this->getId()) {
            $operation->byId((int)$this->getId());
        }
        if ($this->getFirstName()) {
            $operation->byFirstName((string)$this->getFirstName(), 'like');
        }
        if ($this->getLastName()) {
            $operation->byLastName((string)$this->getLastName(), 'like');
        }
        if ($this->getUniversityName()) {
            $operation->byUniversityName((string)$this->getUniversityName(), 'like');
        }
        if ($this->getFacultyName()) {
            $operation->byFacultyName((string)$this->getFacultyName(), 'like');
        }
        if ($this->getPhoto()) {
            $operation->byPhoto((string)$this->getPhoto(), 'like');
        }
        if ($this->getOffset()) {
            $operation->offset($this->getOffset());
        }
        if ($this->getLimit()) {
            $operation->limit($this->getLimit() + 1);
        }
        return $operation;
    }

    /**
     * Метод устанавливает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setFacultyName(string $value): MultiFilterInterface
    {
        $this->facultyName = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Имя" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setFirstName(string $value): MultiFilterInterface
    {
        $this->firstName = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "ВК пользователь".
     *
     * @param int $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setId(int $value): MultiFilterInterface
    {
        $this->id = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Фамилия" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setLastName(string $value): MultiFilterInterface
    {
        $this->lastName = $value;
        return $this;
    }

    /**
     * Метод задает лимит выводимых записей.
     *
     * @param int $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setLimit(int $value): MultiFilterInterface
    {
        $this->limit = $value;
        return $this;
    }

    /**
     * Метод задает номер записи, с которой нуобходимо сделать выборку.
     *
     * @param int $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setOffset(int $value): MultiFilterInterface
    {
        $this->offset = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setPhoto(string $value): MultiFilterInterface
    {
        $this->photo = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Университет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setUniversityName(string $value): MultiFilterInterface
    {
        $this->universityName = $value;
        return $this;
    }
}
