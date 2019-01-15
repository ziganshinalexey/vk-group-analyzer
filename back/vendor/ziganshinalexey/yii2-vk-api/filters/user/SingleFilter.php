<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\filters\user;

use Ziganshinalexey\Yii2VkApi\interfaces\user\filters\SingleFilterInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\filters\SingleFilterOperationInterface;

/**
 * Класс реализует методы применения фильтра к операции.
 */
class SingleFilter extends BaseFilter implements SingleFilterInterface
{
    /**
     * Метод применяет фильтр к операции над одной сущности.
     *
     * @param SingleFilterOperationInterface $operation Обект реализующий методы фильтров операции.
     *
     * @return SingleFilterOperationInterface
     */
    public function applyFilter(SingleFilterOperationInterface $operation): SingleFilterOperationInterface
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
        return $operation;
    }

    /**
     * Метод устанавливает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setFacultyName(string $value): SingleFilterInterface
    {
        $this->facultyName = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Имя" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setFirstName(string $value): SingleFilterInterface
    {
        $this->firstName = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "ВК пользователь".
     *
     * @param int $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setId(int $value): SingleFilterInterface
    {
        $this->id = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Фамилия" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setLastName(string $value): SingleFilterInterface
    {
        $this->lastName = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setPhoto(string $value): SingleFilterInterface
    {
        $this->photo = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Университет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setUniversityName(string $value): SingleFilterInterface
    {
        $this->universityName = $value;
        return $this;
    }
}
