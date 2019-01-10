<?php

namespace Userstory\ModuleAdmin\traits;

use Userstory\ComponentBase\entities\AbstractRelationActiveRecord as RelationActiveRecord;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\ModuleAdmin\widgets\ActiveForm\ActiveForm;
use yii\base\Model;

/**
 * Class AjaxValidateFormRelations.
 * Трейт содержит операции для ajax валидации формы, содержащей зависимые сущности.
 * Модель с данными должна быть наследуема от класса RelationActiveRecord.
 *
 * @package UserstoryKips\ModuleProduct\traits
 */
trait AjaxValidationFormRelationsTrait
{
    /**
     * Метод производит валидацию модели и ее связанных элементов.
     *
     * @param Model|mixed $model      Модель для валидации.
     * @param mixed       $attributes Список атрибутов.
     *
     * @return array
     */
    public static function formValidate($model, $attributes = null)
    {
        $result = ActiveForm::validate($model, $attributes);

        if (! $model instanceof RelationActiveRecord) {
            return $result;
        }

        /* @var RelationActiveRecord $model */
        /* @var Model[] $relations */
        $relations = array_intersect_key($model->relatedRecords, array_flip($model->getDefinedRelations()));

        foreach ($relations as $relation) {
            if (is_array($relation)) {
                foreach ($relation as $key => $item) {
                    $itemResults = ActiveForm::validate($item);
                    $subResult   = [];
                    foreach ($itemResults as $itemKey => $itemValue) {
                        $subKey             = str_replace('-', '-' . $key . '-', $itemKey);
                        $subResult[$subKey] = $itemValue;
                    }
                    $result = ArrayHelper::merge($result, $subResult);
                }
            } else {
                $result = ArrayHelper::merge($result, ActiveForm::validate($relation));
            }
        }

        return $result;
    }

    /**
     * Метод возвращает список связанных сущностей.
     *
     * @return array
     */
    public function getDefinedRelations()
    {
        return $this->definedRelations;
    }
}
