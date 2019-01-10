<?php

namespace Userstory\UserAdmin\controllers;

use Userstory\ComponentBase\controllers\AbstractController;
use Userstory\User\entities\AuthAssignmentActiveRecord;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Class AuthAssignmentController.
 * Контроллер для работы с присвоением ролей.
 *
 * @package Userstory\UserAdmin\controllers
 */
class AuthAssignmentController extends AbstractController
{
    /**
     * Определение уровня доступа к действиям контроллера.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class'        => AccessControl::class,
                'denyCallback' => [
                    $this,
                    'defaultDenyCallback',
                ],
                'rules'        => [
                    [
                        'actions' => [
                            'index',
                            'view',
                        ],
                        'allow'   => true,
                        'roles'   => ['User.RoleAssignment.Read'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow'   => true,
                        'roles'   => ['User.RoleAssignment.Create'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow'   => true,
                        'roles'   => ['User.RoleAssignment.Update'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow'   => true,
                        'roles'   => ['User.RoleAssignment.Delete'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Стартовая страница контроллера.
     *
     * @return string
     *
     * @throws InvalidParamException вьюха не найдена.
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AuthAssignmentActiveRecord::find(),
        ]);

        return $this->defaultRender([
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Страница используемая для просмотра записи.
     *
     * @param integer $id Идентификатор записи.
     *
     * @throws NotFoundHttpException возможное исключение для случая, когда подходящая модель не найдена.
     * @throws InvalidParamException вьюха не найдена.
     *
     * @return string
     */
    public function actionView($id)
    {
        return $this->defaultRender([
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Метод поиска экземпляра модели.
     *
     * @param integer $id Идентификатор записи.
     *
     * @throws NotFoundHttpException исключение для случая, когда подходящая модель не найдена.
     *
     * @return AuthAssignmentActiveRecord
     */
    protected function findModel($id)
    {
        if (($model = AuthAssignmentActiveRecord::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
