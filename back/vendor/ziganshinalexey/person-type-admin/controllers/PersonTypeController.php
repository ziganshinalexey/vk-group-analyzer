<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeAdmin\controllers;

use Userstory\ComponentBase\controllers\AbstractController;
use Userstory\ComponentBase\traits\AjaxValidationTrait;
use Userstory\ComponentBase\traits\ControllerTrait;
use Userstory\User\traits\UserProfileTrait;
use yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Ziganshinalexey\PersonType\entities\PersonTypeActiveRecord;
use Ziganshinalexey\PersonType\traits\personType\PersonTypeComponentTrait;
use Ziganshinalexey\PersonTypeAdmin\traits\personType\PersonTypeAdminComponentTrait;

/**
 * Административный контроллер для работы с сущностью "Тип личности".
 */
class PersonTypeController extends AbstractController
{
    use ControllerTrait;
    use AjaxValidationTrait;
    use PersonTypeComponentTrait;
    use PersonTypeAdminComponentTrait;
    use UserProfileTrait;

    /**
     * Действие для создания новой сущности "Тип личности".
     *
     * @throws Exception                Если не удалось корректно завершить транзакцию.
     * @throws InvalidArgumentException Если http-код ответа не верный.
     * @throws InvalidConfigException   Если компонент не зарегистрирован.
     * @throws InvalidParamException    Соответсвующий view не найден.
     *
     * @return Response|string
     */
    public function actionCreate()
    {
        $form = $this->getPersonTypeAdminComponent()->create();
        $form->setDto($this->getPersonTypeComponent()->getPersonTypePrototype());
        if (Yii::$app->request->getIsPost()) {
            $this->performAjaxValidation($form);
            /* @noinspection NotOptimalIfConditionsInspection */
            if ($form->load(Yii::$app->request->post()) && $form->run()) {
                $category    = PersonTypeActiveRecord::TRANSLATE_CATEGORY . '.Flash';
                $translation = Yii::t($category, 'successfullyCreated', 'Тип личности успешно создан');
                Yii::$app->session->setFlash('success', $translation);

                return $this->redirect([
                    'update',
                    'id' => $form->id,
                ]);
            }
        }

        return $this->defaultRender([
            'model' => $form,
        ]);
    }

    /**
     * Действие для удаления имеющейся сущности "Тип личности".
     *
     * @param string $id Идентификатор удаляемой сущности.
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     * @throws NotFoundHttpException  Если удаляемый элемент не найден.
     *
     * @return Response
     */
    public function actionDelete($id): Response
    {
        $item = $this->getPersonTypeComponent()->findOne()->byId((int)$id)->doOperation();
        if (! $item) {
            throw new NotFoundHttpException();
        }
        $form = $this->getPersonTypeAdminComponent()->delete();
        $form->setDto($item);

        if (Yii::$app->request->getIsPost() && $form->run()) {
            $category    = PersonTypeActiveRecord::TRANSLATE_CATEGORY . '.Flash';
            $translation = Yii::t($category, 'successfullyDeleted', 'Тип личности успешно удален.');
            Yii::$app->session->setFlash('success', $translation);
        }
        return $this->redirect(['index']);
    }

    /**
     * Действие для отображения списка всех сущностей "Тип личности".
     *
     * @throws InvalidArgumentException Если http-код ответа не верный.
     * @throws InvalidConfigException   Если компонент не зарегистрирован.
     * @throws InvalidParamException    Соответсвующий view не найден.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $form     = $this->getPersonTypeAdminComponent()->find();
        $params   = (array)Yii::$app->request->getQueryParams();
        $provider = $form->run($params);

        return $this->defaultRender([
            'dataProvider' => $provider,
            'searchModel'  => $form,
        ]);
    }

    /**
     * Действие для обновления имеющейся сущности "Тип личности".
     *
     * @param string $id Идентификатор обновляемой сущности.
     *
     * @throws Exception                Если не удалось корректно завершить транзакцию.
     * @throws InvalidArgumentException Если http-код ответа не верный.
     * @throws InvalidConfigException   Если компонент не зарегистрирован.
     * @throws InvalidParamException    Соответсвующий view не найден.
     * @throws NotFoundHttpException    Если удаляемый элемент не найден.
     *
     * @return Response|string
     */
    public function actionUpdate($id)
    {
        $item = $this->getPersonTypeComponent()->findOne()->byId((int)$id)->doOperation();
        if (! $item) {
            throw new NotFoundHttpException();
        }
        $form = $this->getPersonTypeAdminComponent()->update();
        $form->setDto($item);

        /* @noinspection NotOptimalIfConditionsInspection */
        if ($form->load(Yii::$app->request->post()) && $form->run()) {
            $category    = PersonTypeActiveRecord::TRANSLATE_CATEGORY . '.Flash';
            $translation = Yii::t($category, 'successfullyUpdated', 'Тип личности успешно обновлен.');
            Yii::$app->session->setFlash('success', $translation);
            return $this->redirect([
                'view',
                'id' => $form->id,
            ]);
        }

        return $this->defaultRender([
            'model' => $form,
        ]);
    }

    /**
     * Действие для отображения одной сущности "Тип личности".
     *
     * @param string $id ИД просматриваемой сущности.
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     * @throws InvalidParamException  Соответсвующий view не найден.
     * @throws NotFoundHttpException  Если просматриваемый элемент не найден.
     *
     * @return string
     */
    public function actionView($id): string
    {
        $item = $this->getPersonTypeComponent()->findOne()->byId((int)$id)->doOperation();
        if (! $item) {
            throw new NotFoundHttpException('Просматриваемый элемент не найден');
        }

        $model = $this->getPersonTypeAdminComponent()->view();
        $model->setDto($item);

        return $this->defaultRender([
            'creatorIdRelation' => $this->getUserProfileComponent()->findById($item->getCreatorId()),
            'updaterIdRelation' => $this->getUserProfileComponent()->findById($item->getUpdaterId()),
            'model'             => $model,
        ]);
    }

    /**
     * Метод определяет конфигурацию поведения и прав текущего контроллера.
     *
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow'   => 1,
                        'roles'   => ['Admin.PersonType.PersonType.List'],
                        'verbs'   => ['GET'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow'   => 1,
                        'roles'   => ['Admin.PersonType.PersonType.Create'],
                        'verbs'   => [
                            'POST',
                            'GET',
                        ],
                    ],
                    [
                        'actions' => ['update'],
                        'allow'   => 1,
                        'roles'   => ['Admin.PersonType.PersonType.Update'],
                        'verbs'   => [
                            'POST',
                            'GET',
                        ],
                    ],
                    [
                        'actions' => ['view'],
                        'allow'   => 1,
                        'roles'   => ['Admin.PersonType.PersonType.View'],
                        'verbs'   => ['GET'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow'   => 1,
                        'roles'   => ['Admin.PersonType.PersonType.Delete'],
                        'verbs'   => [
                            'POST',
                            'GET',
                        ],
                    ],
                ],
            ],
        ];
    }
}
