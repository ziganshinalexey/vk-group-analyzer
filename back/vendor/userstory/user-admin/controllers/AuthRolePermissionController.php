<?php

namespace Userstory\UserAdmin\controllers;

use Userstory\ComponentBase\controllers\AbstractController;
use Userstory\User\entities\AuthRolePermissionActiveRecord;
use Userstory\UserAdmin\forms\AuthRolePermissionForm;
use yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class AuthRolePermissionController.
 * Контроллер для работы с разрешениями ролей.
 *
 * @package Userstory\UserAdmin\controllers
 */
class AuthRolePermissionController extends AbstractController
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
                        'roles'   => ['User.RolePermission.Read'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow'   => true,
                        'roles'   => ['User.RolePermission.Create'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow'   => true,
                        'roles'   => ['User.RolePermission.Update'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow'   => true,
                        'roles'   => ['User.RolePermission.Delete'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Стартовая страница контроллера.
     *
     * @throws InvalidParamException Исключение генерируется во внутренних вызовах.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AuthRolePermissionActiveRecord::find(),
        ]);

        return $this->defaultRender([
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Страница используемая для просмотра записи.
     *
     * @param integer $roleId     Идентификатор записи.
     * @param string  $permission Название разрешения.
     *
     * @throws NotFoundHttpException возможное исключение для случая, когда подходящая модель не найдена.
     * @throws InvalidParamException вьюха не найдена.
     *
     * @return string
     */
    public function actionView($roleId, $permission)
    {
        return $this->defaultRender([
            'model' => $this->findRolePermission($roleId, $permission),
        ]);
    }

    /**
     * Страница используемая для создания записи.
     *
     * @throws InvalidParamException Исключение генерируется во внутренних вызовах.
     *
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new AuthRolePermissionActiveRecord();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'roleId'     => $model->roleId,
                'permission' => $model->permission,
            ]);
        }

        return $this->defaultRender([
            'model' => $model,
        ]);
    }

    /**
     * Страница редактирования записи.
     *
     * @param integer $roleId     Идентификатор записи.
     * @param string  $permission Название разрешения.
     *
     * @throws InvalidParamException Исключение генерируется во внутренних вызовах.
     *
     * @return string|Response
     */
    public function actionUpdate($roleId, $permission)
    {
        $model = $this->findRolePermission($roleId, $permission);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'roleId'     => $model->roleId,
                'permission' => $model->permission,
            ]);
        }

        return $this->defaultRender([
            'model' => $model,
        ]);
    }

    /**
     * Страница используемая для удаления записи.
     *
     * @param integer $roleId     идентификатор роли.
     * @param string  $permission название разрешения.
     *
     * @return Response
     */
    public function actionDelete($roleId, $permission)
    {
        $this->findRolePermission($roleId, $permission)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Метод поиска экземпляра модели.
     *
     * @param integer $roleId     Идентификатор роли.
     * @param string  $permission Название разрешения.
     *
     * @throws NotFoundHttpException Исключение, когда подходящая модель не найдена.
     *
     * @return AuthRolePermissionActiveRecord
     */
    protected function findRolePermission($roleId, $permission)
    {
        $model = AuthRolePermissionForm::getRolePermissionByIdAndName($roleId, $permission);

        if (null !== $model) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
