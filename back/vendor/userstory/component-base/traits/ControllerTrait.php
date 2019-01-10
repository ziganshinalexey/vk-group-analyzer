<?php

namespace Userstory\ComponentBase\traits;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use yii;
use yii\base\Action;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Trait ControllerTrait.
 * Трейт для общих операций при работе с контроллерами.
 *
 * @package app\controllers\traits
 */
trait ControllerTrait
{
    /**
     * Список экшенов, доступных только по AJAX.
     *
     * @var array
     */
    protected $ajaxActions = [];

    /**
     * Метод возвращает параметры страницы при использовании табличного вывода.
     * Возвращает номер текущей страницы и количество элементов на страницы для корректной разбивки.
     * Необходим, когда после некоторых операций надо вернуться на ту же страницу.
     *
     * @param string|null $url Адрес для разбора параметров. Если не указан - берется адрес рефера.
     *
     * @return array
     */
    protected function getPageParams($url = null)
    {
        if (! $url) {
            $url = Yii::$app->request->referrer;
        }

        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $params);

        $page    = ArrayHelper::getValue($params, 'page', 1);
        $perPage = ArrayHelper::getValue($params, 'per-page', Yii::$app->params['defaultPageSize']);

        return [
            'page'     => $page,
            'per-page' => $perPage,
        ];
    }

    /**
     * Метод перенаправляет запрос на адрес рефа.
     *
     * @param string|null $referrer    Адрес рефа.
     * @param boolean     $replaceCode Заменить код редиректа при ajax запросе. Полезно при использовании PJAX.
     *
     * @return Response
     */
    protected function redirectReferrer($referrer = null, $replaceCode = true)
    {
        /* @var Controller $this */
        return $this->redirect($referrer ?: Yii::$app->request->referrer, $replaceCode && Yii::$app->request->isAjax ? 200 : 302);
    }

    /**
     * Сеттер задает список экшенов, доступных только по AJAX.
     *
     * @param array $actions Список экшенов для установки.
     *
     * @return static
     */
    protected function setAjaxActions(array $actions)
    {
        $this->ajaxActions = $actions;
        return $this;
    }

    /**
     * Метод проводит проверку перед выполнением экшена.
     *
     * @param Action|mixed $action Запрошенный экшен.
     *
     * @throws NotFoundHttpException Исключение, если экшн был запрошен не по AJAX.
     *
     * @return mixed
     */
    public function beforeAction($action)
    {
        $isAjaxOrPost = Yii::$app->request->isAjax || Yii::$app->request->isPost;

        if (! $isAjaxOrPost && ! empty($this->ajaxActions) && in_array($action->id, $this->ajaxActions, true)) {
            throw new NotFoundHttpException('The requested page does not exists!');
        }

        return parent::beforeAction($action);
    }

    /**
     * Метод удаляет GET парараметры запроса.
     *
     * @param array $names Название параметров для удаления.
     *
     * @return void
     */
    protected function unsetQueryParams(array $names)
    {
        $params = Yii::$app->request->getQueryParams();

        foreach ($names as $name) {
            unset($params[$name]);
        }

        Yii::$app->request->setQueryParams($params);
    }

    /**
     * Метод обновляет страницы при использовании провайдера данных.
     *
     * @param ActiveDataProvider|mixed $dataProvider Провайдер данных.
     *
     * @return void
     */
    protected function updateProviderPages($dataProvider)
    {
        $params  = Yii::$app->request->getQueryParams();
        $pageKey = $dataProvider->pagination->pageParam;

        if (isset($params[$pageKey])) {
            $params[$pageKey] ++;
            Yii::$app->request->setQueryParams($params);
        }

        $dataProvider->pagination->totalCount = $dataProvider->getTotalCount();
        $dataProvider->pagination->getPage(true);
    }
}
