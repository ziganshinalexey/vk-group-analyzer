<?php

namespace Userstory\ComponentBase\traits;

use Userstory\ComponentBase\entities\AbstractRelationActiveRecord;
use Userstory\ModuleAdmin\widgets\ActiveForm\ActiveForm;
use yii;
use yii\base\Model;
use yii\web\Response;

/**
 * Trait AjaxValidationTrait.
 * Трейт для валидации форм по аякс-запросу.
 *
 * @package app\models\traits
 */
trait AjaxValidationTrait
{
    /**
     * Метод производит проверку модели для Ajax запросов.
     *
     * @param Model $model Модель для валидации.
     *
     * @return mixed
     */
    protected function performAjaxValidation(Model $model)
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model instanceof AbstractRelationActiveRecord && method_exists($model, 'formValidate')) {
                Yii::$app->response->data = $model::formValidate($model);
            } else {
                Yii::$app->response->data = ActiveForm::validate($model);
            }
            Yii::$app->end();
        }
    }
}
