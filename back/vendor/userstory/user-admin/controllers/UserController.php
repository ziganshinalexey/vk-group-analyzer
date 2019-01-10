<?php

namespace Userstory\UserAdmin\controllers;

use Exception;
use Userstory\ComponentBase\controllers\AbstractController;
use Userstory\User\entities\UserProfileActiveRecord;
use Userstory\UserAdmin\forms\UserProfileForm;
use Userstory\UserAdmin\traits\UserAdminComponentTrait;
use yii;
use yii\base\InvalidParamException;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class UserController.
 * Контроллер для управление пользователями системы.
 *
 * @package Userstory\UserAdmin\controllers
 */
class UserController extends AbstractController
{
    use UserAdminComponentTrait;

    /**
     * Определение уровня доступа к действиям контроллера.
     *
     * @throws ForbiddenHttpException Если нет доступа.
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
                    'accessDenyCallback',
                ],
                'rules'        => [
                    [
                        'actions' => [
                            'index',
                            'view',
                        ],
                        'allow'   => true,
                        'roles'   => ['User.Profile.Read'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow'   => true,
                        'roles'   => ['User.Profile.Create'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow'   => true,
                        'roles'   => ['User.Profile.Update'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow'   => true,
                        'roles'   => ['User.Profile.Delete'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Метод используется при контроле доступа в случае отказа.
     *
     * @throws NotFoundHttpException  Исключение, если не удалось перенаправить на страницу логина.
     * @throws ForbiddenHttpException Исключение генерируется во внутренних вызовах.
     *
     * @return void
     */
    public function accessDenyCallback()
    {
        $user = Yii::$app->getUser();
        if ($user->getIsGuest()) {
            $user->loginRequired();
            return;
        }

        throw new NotFoundHttpException('Not Found');
    }

    /**
     * Действие контроллера по умолчанию, отображающее список пользователей.
     *
     * @throws InvalidParamException Исключение генерируется во внутренних вызовах.
     *
     * @return string|Response
     */
    public function actionIndex()
    {
        $dataProvider = $this->getUserAdminComponent()->modelFactory->getDataProvider([
            'query' => UserProfileActiveRecord::find(),
            'sort'  => [
                'defaultOrder' => ['id' => SORT_ASC],
            ],
        ]);

        return $this->defaultRender([
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Действие контроллера, отображающего информацию о пользователе.
     *
     * @param integer $id уникальный идентификатор удалемой сущности.
     *
     * @throws NotFoundHttpException Исключение генерируется во внутренних вызовах.
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
     * Действие контроллера, регистрирующего нового пользователя.
     *
     * @throws InvalidParamException Исключение генерируется во внутренних вызовах.
     *
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = $this->getUserAdminComponent()->modelFactory->getUserProfileForm();

        if ($model->load(Yii::$app->request->post()) && $model->saveForm()) {
            return $this->redirect($this->getDefaultRedirect());
        }

        return $this->defaultRender([
            'model' => $model,
        ]);
    }

    /**
     * Действие контроллера вносящее изменения в профиль пользователя.
     *
     * @param integer $id уникальный идентификатор удалемой сущности.
     *
     * @throws NotFoundHttpException Исключение генерируется во внутренних вызовах.
     * @throws InvalidParamException Исключение генерируется во внутренних вызовах.
     *
     * @return string|Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->saveForm()) {
            return $this->redirect($this->getDefaultRedirect());
        }

        return $this->defaultRender([
            'model' => $model,
        ]);
    }

    /**
     * Действие контроллера удаляющее пользователя.
     *
     * @param integer $id уникальный идентификатор удалемой сущности.
     *
     * @throws UserException Исключение, если пользователя не удалось удалить по каким-либо причинам.
     * @throws Exception     Исключение, возникающее в случе ошибок при удалении.
     *
     * @return Response
     */
    public function actionDelete($id)
    {
        if (! $this->findModel($id)->delete()) {
            throw new UserException('Couldn\'t delete entry.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Метод осуществляет поиск изменяемой модели.
     *
     * @param integer $id уникальный идентификатор сущности.
     *
     * @throws NotFoundHttpException Исключение, возникающее если сущность не была найдена.
     *
     * @return UserProfileForm
     */
    protected function findModel($id)
    {
        if (null !== ( $model = UserProfileForm::getById($id) )) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
