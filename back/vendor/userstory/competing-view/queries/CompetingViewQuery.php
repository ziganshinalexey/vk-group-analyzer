<?php

namespace Userstory\CompetingView\queries;

use Userstory\CompetingView\entities\CompetingView;
use yii\db\ActiveQuery;

/**
 * Класс модели построителя запросов для класса @see CompetingView.
 *
 * @package UserStory\ModuleFaq\models\queries
 */
class CompetingViewQuery extends ActiveQuery
{
    /**
     * Удаляет все записи старше определенного срока.
     *
     * @param integer $delay Время жизни записи.
     *
     * @return integer количество удаленных записей
     */
    public function deleteOlder($delay)
    {
        return CompetingView::deleteAll('viewDate<:viewDate', [':viewDate' => time() - $delay]);
    }

    /**
     * Добавляет условие фильтрации по сущности и ИД сущности.
     *
     * @param string $entityName Название сущности.
     * @param mixed  $entityId   ИД сущности.
     *
     * @return CompetingViewQuery
     */
    public function filterByEntity($entityName, $entityId)
    {
        return $this->andWhere([
            'entityName' => $entityName,
            'entityId'   => $entityId,
        ]);
    }

    /**
     * Добавляет условие фильтрации по пользователю.
     *
     * @param integer $userId ИД пользователя.
     *
     * @return CompetingViewQuery
     */
    public function filterByUser($userId)
    {
        return $this->andWhere(['userId' => $userId]);
    }

    /**
     * Добавляет условие фильтрации "НЕ" по пользователю.
     *
     * @param integer $userId ИД пользователя.
     *
     * @return CompetingViewQuery
     */
    public function filterByNotUser($userId)
    {
        return $this->andWhere([
            '!=',
            'userId',
            $userId,
        ]);
    }

    /**
     * Добавляет условие фильтрации по времени жизни.
     *
     * @param integer $delay Время жизни записи.
     *
     * @return CompetingViewQuery
     */
    public function filterByDelay($delay)
    {
        return $this->andWhere([
            '>=',
            'viewDate',
            time() - $delay,
        ]);
    }
}
