<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\traits;

use function array_keys;
use function get_object_vars;

/**
 * Трейт ДТО, хранящий исходные значения атрибутов.
 */
trait DtoWithOldAttributesTrait
{
    use WithOldAttributesTrait;

    /**
     * Метод завершает инициализацию ДТО.
     * Данный метод может вызываться например операциями поиска после загрузки данных в ДТО.
     *
     * @param bool $force Выполнять ли операцию повторно.
     *
     * @return void
     *
     * @inherit
     */
    public function completeInitialization(bool $force = false): void
    {
        $dataAttributeList = get_object_vars($this);
        unset($dataAttributeList['errorCollection']);
        unset($dataAttributeList['collectionYiiHydrator']);
        unset($dataAttributeList['errorPrototype']);
        unset($dataAttributeList['errorsComponentTrait']);
        unset($dataAttributeList['initializationCompleted']);
        unset($dataAttributeList['oldAttributeValueList']);
        $dataAttributeList = array_keys($dataAttributeList);
        $this->saveAttributeValues($dataAttributeList, $force);
        parent::completeInitialization($force);
    }
}
