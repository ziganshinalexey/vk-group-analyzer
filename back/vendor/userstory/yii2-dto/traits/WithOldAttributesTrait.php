<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\traits;

use function array_keys;
use function array_key_exists;
use function get_object_vars;
use function in_array;
use function method_exists;
use function ucfirst;
use Userstory\Yii2Exceptions\exceptions\types\ValueIsEmptyException;

/**
 * Трейт объекта, хранящий исходные значения атрибутов.
 */
trait WithOldAttributesTrait
{
    /**
     * Исходные значения атрибутов объекта.
     *
     * @var array
     */
    protected $oldAttributeValueList = [];

    /**
     * Метод сохраняет текущее значение атрибутов объекта.
     *
     * @param array $attributeList Список атрибутов, значения которых нужно сохранять.
     * @param bool  $force         Сохранить поверх уже существующей копии.
     *
     * @return void
     */
    protected function saveAttributeValues(array $attributeList = [], bool $force = false): void
    {
        if (! $force && ! empty($this->oldAttributeValueList)) {
            return;
        }

        $this->oldAttributeValueList = get_object_vars($this);
        if (empty($attributeList)) {
            return;
        }

        foreach ($this->oldAttributeValueList as $attribute => $value) {
            if (! in_array($attribute, $attributeList)) {
                unset($this->oldAttributeValueList[$attribute]);
            }
        }
    }

    /**
     * Метод откатывает значения атрибутов до сохраненного состояния.
     *
     * @param array $attributeList Список атрибутов для отката. Если пустой, откатит все сохраненные атрибуты.
     * @param bool  $useSetter     Предпочтительно использовать сеттер для установки старого значения атрибута.
     *
     * @return void
     */
    protected function revertAttributeValues(array $attributeList = [], bool $useSetter = false): void
    {
        if (empty($this->oldAttributeValueList)) {
            return;
        }

        $attributeList = ! empty($attributeList) ? $attributeList : array_keys($this->oldAttributeValueList);
        foreach ($attributeList as $attribute) {
            if (! array_key_exists($attribute, $this->oldAttributeValueList)) {
                continue;
            }
            $value = $this->oldAttributeValueList[$attribute];
            if ($useSetter) {
                $setterName = 'set' . ucfirst($attribute);
                if (method_exists($this, $setterName)) {
                    $this->$setterName($value);
                    continue;
                }
            }
            $this->$attribute = $value;
        }
    }

    /**
     * Метод отвечает на вопрос менялось ли значение атрибута или нет.
     *
     * @param string $attribute Атрибут для проверки.
     *
     * @return bool
     */
    protected function isAttributeChanged(string $attribute): bool
    {
        if (empty($this->oldAttributeValueList)) {
            return false;
        }
        if (! array_key_exists($attribute, $this->oldAttributeValueList)) {
            return false;
        }
        $oldValue = $this->oldAttributeValueList[$attribute];
        return $oldValue !== $this->$attribute;
    }

    /**
     * Метод возвращает старое значение атрибута.
     *
     * @param string $attribute Атрибут для возвращаения значения.
     *
     * @return mixed
     *
     * @throws ValueIsEmptyException Исключение генерируется в случае, если старое значение атрибута не может быть получено.
     */
    protected function getOldAttributeValue(string $attribute)
    {
        if (empty($this->oldAttributeValueList)) {
            throw new ValueIsEmptyException('Old value for attribute "' . $attribute . '" can not be found');
        }
        if (! array_key_exists($attribute, $this->oldAttributeValueList)) {
            throw new ValueIsEmptyException('Old value for attribute "' . $attribute . '" can not be found');
        }
        return $this->oldAttributeValueList[$attribute];
    }
}
