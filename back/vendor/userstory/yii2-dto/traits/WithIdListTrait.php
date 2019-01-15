<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\traits;

use Userstory\Yii2Exceptions\exceptions\types\IntMismatchException;
use function is_int;

/**
 * Трейт объекта, который работает со списком ИД.
 */
trait WithIdListTrait
{
    /**
     * Список ИД сущностей для обработки.
     *
     * @var array
     */
    protected $idList = [];

    /**
     * Метод возвращает список ИД сущностей.
     *
     * @return array
     */
    public function getIdList(): array
    {
        return $this->idList;
    }

    /**
     * Мето устанавливает список ИД сущностей.
     *
     * @param int[] $idList Список ИД сущностей.
     *
     * @return static
     *
     * @throws IntMismatchException Ичключение генерируется в случае, если элемент списка ИД не целым числом.
     */
    public function setIdList(array $idList)
    {
        foreach ($idList as $id) {
            if (! is_int($id)) {
                throw new IntMismatchException('id list elements must be integer');
            }
        }
        $this->idList = $idList;
        return $this;
    }
}
