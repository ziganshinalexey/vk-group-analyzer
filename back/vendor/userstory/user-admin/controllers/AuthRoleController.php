<?php

namespace Userstory\UserAdmin\controllers;

use Userstory\ComponentBase\controllers\AbstractController;
use Userstory\User\entities\AuthRoleActiveRecord;
use Userstory\UserAdmin\traits\UserAdminComponentTrait;
use yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class AuthRoleController.
 * Контроллер для работы с ролями.
 *
 * @package Userstory\UserAdmin\controllers
 */
class AuthRoleController extends AbstractController
{
    use UserAdminComponentTrait;

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
                        'roles'   => ['User.Role.Read'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow'   => true,
                        'roles'   => ['User.Role.Create'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow'   => true,
                        'roles'   => ['User.Role.Update'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow'   => true,
                        'roles'   => ['User.Role.Delete'],
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
        $dataProvider = $this->getUserAdminComponent()->modelFactory->getDataProvider([
            'query' => AuthRoleActiveRecord::find(),
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
     * @throws InvalidParamException Исключение генерируется во внутренних вызовах.
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
     * Действие для создания новой роли.
     *
     * @return Response|string
     */
    public function actionCreate()
    {
        $model = $this->getUserAdminComponent()->modelFactory->getRoleForm();

        if ($model->load(Yii::$app->request->post()) && $model->saveForm()) {
            return $this->redirect($this->getSuccessRedirect($model));
        }

        return $this->defaultRender($this->getRenderParams($model));
    }

    /**
     * Действие для обновления существующей роли.
     *
     * @param integer $id Идентификатор роли.
     *
     * @return string|Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->saveForm()) {
            return $this->redirect($this->getSuccessRedirect($model));
        }

        return $this->defaultRender($this->getRenderParams($model));
    }
}
