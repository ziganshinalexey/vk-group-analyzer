<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\interfaces\personType\filters;

/**
 * Интерфейс объявляет методы фильтрации операций.
 */
interface MultiFilterOperationInterface extends BaseFilterOperationInterface
{
    /**
     * Метод устанавливает лимит получаемых сущностей.
     *
     * @param int $limit Количество необходимых сущностей.
     *
     * @return MultiFilterOperationInterface
     */
    public function limit(int $limit);

    /**
     * Метод устанавливает смещение получаемых сущностей.
     *
     * @param int $offset Смещение в списке необходимых сущностей.
     *
     * @return MultiFilterOperationInterface
     */
    public function offset(int $offset);
}
