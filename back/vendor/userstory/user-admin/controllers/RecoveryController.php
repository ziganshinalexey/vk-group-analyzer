<?php

namespace Userstory\UserAdmin\controllers;

use Userstory\ComponentBase\controllers\AbstractController;
use Userstory\UserAdmin\forms\RecoveryForm;
use Userstory\UserAdmin\traits\UserAdminComponentTrait;
use yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * Class LoginController.
 * Контроллер по управлению восстановлением пароля.
 *
 * @package Userstory\UserAdmin\controllers
 */
class RecoveryController extends AbstractController
{
    use UserAdminComponentTrait;

    /**
     * Метод определяет поведения контроллера.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'option',
                            'change',
                            'success',
                        ],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Форма для ввода логин, емайла или номера телефона для восстановления пароля.
     *
     * @throws InvalidParamException вьюха не найдена.
     * @return string
     */
    public function actionIndex()
    {
        return $this->defaultRender([
            'model' => $this->getRecoveryForm(),
        ]);
    }

    /**
     * Форма выбора средства доставки кода для восстановления пароля.
     *
     * @return string
     *
     * @throws InvalidParamException Исключение генерируется во внутренних вызовах.
     */
    public function actionOption()
    {
        $result = [];
        $model  = $this->getRecoveryForm();

        $model->setScenario($model::SCENARIO_ENTER);

        /* @var array $result */
        if ($model->load(Yii::$app->request->post()) && true === ( $result = $model->option() )) {
            $this->redirect(Url::to([
                'recovery/change',
                'recoverySend' => $model->recoverySend,
            ]));
        }

        $this->viewMap['option'] = $this->viewMap['index'];

        return $this->defaultRender([
            'model'  => $model,
            'result' => $result,
        ]);
    }

    /**
     * Форма ввода кода и смена пароля.
     *
     * @param string  $hash         код для восстановления пароля.
     * @param integer $recoverySend тип отпраки кода.
     *
     * @throws InvalidParamException Исключение генерируется во внутренних вызовах.
     * @throws Exception             Исключение генерируется во внутренних вызовах.
     *
     * @return string
     */
    public function actionChange($hash = null, $recoverySend = null)
    {
        $model = $this->getRecoveryForm();
        $model->setScenario($model::SCENARIO_CHANGE);

        $model->recoveryCode = $hash;
        $model->recoverySend = $recoverySend ?: $model->recoverySend;

        if (null === $hash && Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if (! $model->recoveryCode) {
                $model->send();
            } elseif ($model->updatePassword()) {
                $this->redirect('success');
            }
        } elseif (null !== $hash) {
            $model->checkEmailRecoveryCode();
        }

        return $this->defaultRender([
            'model' => $model,
        ]);
    }

    /**
     * Информация об успешной смене пароля.
     *
     * @throws InvalidParamException Исключение генерируется во внутренних вызовах.
     *
     * @return string
     */
    public function actionSuccess()
    {
        return $this->defaultRender([]);
    }

    /**
     * Метод возвращает объект формы восстановления доступа.
     *
     * @return RecoveryForm
     */
    protected function getRecoveryForm()
    {
        return $this->getUserAdminComponent()->modelFactory->getRecoveryForm();
    }
}
