<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordAdmin\controllers;

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
use Ziganshinalexey\Keyword\entities\KeywordActiveRecord;
use Ziganshinalexey\Keyword\traits\keyword\KeywordComponentTrait;
use Ziganshinalexey\KeywordAdmin\traits\keyword\KeywordAdminComponentTrait;
use Ziganshinalexey\PersonType\traits\personType\PersonTypeComponentTrait;

/**
 * Административный контроллер для работы с сущностью "Ключевое фраза".
 */
class KeywordController extends AbstractController
{
    use ControllerTrait;
    use AjaxValidationTrait;
    use KeywordComponentTrait;
    use KeywordAdminComponentTrait;
    use PersonTypeComponentTrait;
    use UserProfileTrait;

    /**
     * Действие для создания новой сущности "Ключевое фраза".
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
        $form = $this->getKeywordAdminComponent()->create();
        $form->setDto($this->getKeywordComponent()->getKeywordPrototype());
        if (Yii::$app->request->getIsPost()) {
            $this->performAjaxValidation($form);
            /* @noinspection NotOptimalIfConditionsInspection */
            if ($form->load(Yii::$app->request->post()) && $form->run()) {
                $category    = KeywordActiveRecord::TRANSLATE_CATEGORY . '.Flash';
                $translation = Yii::t($category, 'successfullyCreated', 'Ключевое фраза успешно создан');
                Yii::$app->session->setFlash('success', $translation);

                return $this->redirect([
                    'update',
                    'id' => $form->id,
                ]);
            }
        }

        return $this->defaultRender([
            'personTypeList' => $this->getPersonTypeComponent()->findMany()->sortById()->doOperation(),
            'model'          => $form,
        ]);
    }

    /**
     * Действие для удаления имеющейся сущности "Ключевое фраза".
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
        $item = $this->getKeywordComponent()->findOne()->byId((int)$id)->doOperation();
        if (! $item) {
            throw new NotFoundHttpException();
        }
        $form = $this->getKeywordAdminComponent()->delete();
        $form->setDto($item);

        if (Yii::$app->request->getIsPost() && $form->run()) {
            $category    = KeywordActiveRecord::TRANSLATE_CATEGORY . '.Flash';
            $translation = Yii::t($category, 'successfullyDeleted', 'Ключевое фраза успешно удален.');
            Yii::$app->session->setFlash('success', $translation);
        }
        return $this->redirect(['index']);
    }

    /**
     * Действие для отображения списка всех сущностей "Ключевое фраза".
     *
     * @throws InvalidArgumentException Если http-код ответа не верный.
     * @throws InvalidConfigException   Если компонент не зарегистрирован.
     * @throws InvalidParamException    Соответсвующий view не найден.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $form     = $this->getKeywordAdminComponent()->find();
        $params   = (array)Yii::$app->request->getQueryParams();
        $provider = $form->run($params);

        return $this->defaultRender([
            'dataProvider' => $provider,
            'searchModel'  => $form,
        ]);
    }

    /**
     * Действие для обновления имеющейся сущности "Ключевое фраза".
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
        $item = $this->getKeywordComponent()->findOne()->byId((int)$id)->doOperation();
        if (! $item) {
            throw new NotFoundHttpException();
        }
        $form = $this->getKeywordAdminComponent()->update();
        $form->setDto($item);

        /* @noinspection NotOptimalIfConditionsInspection */
        if ($form->load(Yii::$app->request->post()) && $form->run()) {
            $category    = KeywordActiveRecord::TRANSLATE_CATEGORY . '.Flash';
            $translation = Yii::t($category, 'successfullyUpdated', 'Ключевое фраза успешно обновлен.');
            Yii::$app->session->setFlash('success', $translation);
            return $this->redirect([
                'view',
                'id' => $form->id,
            ]);
        }

        return $this->defaultRender([
            'personTypeList' => $this->getPersonTypeComponent()->findMany()->sortById()->doOperation(),
            'model'          => $form,
        ]);
    }

    /**
     * Действие для отображения одной сущности "Ключевое фраза".
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
        $item = $this->getKeywordComponent()->findOne()->byId((int)$id)->doOperation();
        if (! $item) {
            throw new NotFoundHttpException('Просматриваемый элемент не найден');
        }

        $model = $this->getKeywordAdminComponent()->view();
        $model->setDto($item);

        return $this->defaultRender([
            'personType' => $this->getPersonTypeComponent()->findOne()->byId($item->getPersonTypeId())->doOperation(),
            'model'      => $model,
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
                        'roles'   => ['Admin.Keyword.Keyword.List'],
                        'verbs'   => ['GET'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow'   => 1,
                        'roles'   => ['Admin.Keyword.Keyword.Create'],
                        'verbs'   => [
                            'POST',
                            'GET',
                        ],
                    ],
                    [
                        'actions' => ['update'],
                        'allow'   => 1,
                        'roles'   => ['Admin.Keyword.Keyword.Update'],
                        'verbs'   => [
                            'POST',
                            'GET',
                        ],
                    ],
                    [
                        'actions' => ['view'],
                        'allow'   => 1,
                        'roles'   => ['Admin.Keyword.Keyword.View'],
                        'verbs'   => ['GET'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow'   => 1,
                        'roles'   => ['Admin.Keyword.Keyword.Delete'],
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
