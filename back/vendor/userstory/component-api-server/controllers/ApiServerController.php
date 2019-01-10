<?php

namespace Userstory\ComponentApiServer\controllers;

use yii;
use yii\web\Response;
use yii\base\InvalidRouteException;

/**
 * Class ApiServerController.
 * Класс контроллера компонента для обработки поступающих API запросов.
 *
 * @package Userstory\ComponentApiServer\controllers
 */
class ApiServerController extends BaseApiController
{
    /**
     * Действие для обработки запросов POST.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @throws InvalidRouteException Ислючение, если роут пользовательского действия не найден.
     *
     * @return Response
     */
    public function restActionPost(array $routeParams = [], array $queryParams = [])
    {
        return $this->runUserAction('post', $routeParams, $queryParams);
    }

    /**
     * Действие для обработки API запроса над ресурсом: получение списка ресурсов.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @throws InvalidRouteException Ислючение, если роут пользовательского действия не найден.
     *
     * @return Response
     */
    public function restActionIndex(array $routeParams = [], array $queryParams = [])
    {
        return $this->runUserAction('index', $routeParams, $queryParams);
    }

    /**
     * Действие для обработки API запроса над ресурсом: создание нового ресурса.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @throws InvalidRouteException Ислючение, если роут пользовательского действия не найден.
     *
     * @return Response
     */
    public function restActionCreate(array $routeParams = [], array $queryParams = [])
    {
        return $this->runUserAction('create', $routeParams, $queryParams);
    }

    /**
     * Действие для обработки API запроса над ресурсом: получить данные ресурса.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @throws InvalidRouteException Ислючение, если роут пользовательского действия не найден.
     *
     * @return Response
     */
    public function restActionView(array $routeParams = [], array $queryParams = [])
    {
        return $this->runUserAction('view', $routeParams, $queryParams);
    }

    /**
     * Действие для обработки API запроса над ресурсом: обновление ресурса.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @throws InvalidRouteException Ислючение, если роут пользовательского действия не найден.
     *
     * @return Response
     */
    public function restActionUpdate(array $routeParams = [], array $queryParams = [])
    {
        return $this->runUserAction('update', $routeParams, $queryParams);
    }

    /**
     * Действие для обработки API запроса над ресурсом: удаление ресурса.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @throws InvalidRouteException Ислючение, если роут пользовательского действия не найден.
     *
     * @return Response
     */
    public function restActionDelete(array $routeParams = [], array $queryParams = [])
    {
        return $this->runUserAction('delete', $routeParams, $queryParams);
    }

    /**
     * Действие для обработки API запроса над подресурсом: получение списка подресурсов.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @throws InvalidRouteException Ислючение, если роут пользовательского действия не найден.
     *
     * @return Response
     */
    public function restActionSubIndex(array $routeParams = [], array $queryParams = [])
    {
        return $this->runUserAction('index', $routeParams, $queryParams);
    }

    /**
     * Действие для обработки API запроса над подресурсом: создание нового подресурса.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @throws InvalidRouteException Ислючение, если роут пользовательского действия не найден.
     *
     * @return Response
     */
    public function restActionSubCreate(array $routeParams = [], array $queryParams = [])
    {
        return $this->runUserAction('create', $routeParams, $queryParams);
    }

    /**
     * Действие для обработки API запроса над подресурсом: получить данные подресурса.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @throws InvalidRouteException Ислючение, если роут пользовательского действия не найден.
     *
     * @return Response
     */
    public function restActionSubView(array $routeParams = [], array $queryParams = [])
    {
        return $this->runUserAction('view', $routeParams, $queryParams);
    }

    /**
     * Действие для обработки API запроса над подресурсом: обновление подресурса.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @throws InvalidRouteException Ислючение, если роут пользовательского действия не найден.
     *
     * @return Response
     */
    public function restActionSubUpdate(array $routeParams = [], array $queryParams = [])
    {
        return $this->runUserAction('update', $routeParams, $queryParams);
    }

    /**
     * Действие для обработки API запроса над подресурсом: удаление подресурса.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @throws InvalidRouteException Ислючение, если роут пользовательского действия не найден.
     *
     * @return Response
     */
    public function restActionSubDelete(array $routeParams = [], array $queryParams = [])
    {
        return $this->runUserAction('delete', $routeParams, $queryParams);
    }

    /**
     * Действие для обработки API запроса: вывода информации о всех доступных методах API.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @inherit
     *
     * @return Response
     */
    public function restActionInfo(array $routeParams = [], array $queryParams = [])
    {
        return Yii::$app->apiServer->getInfo();
    }

    /**
     * Действие для обработки API запроса: вывода информации о всех доступных методах одной версии API.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @inherit
     *
     * @return Response
     */
    public function restActionInfoVersion(array $routeParams = [], array $queryParams = [])
    {
        return Yii::$app->apiServer->getInfoVersion($routeParams['version']);
    }

    /**
     * Действие для обработки API запроса: вывода информации о текущем протоколе запроса.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @inherit
     *
     * @return Response
     */
    public function restActionVersion(array $routeParams = [], array $queryParams = [])
    {
        return Yii::$app->apiServer->getProtocolVersion();
    }

    /**
     * Действие для обработки API запроса: вывода информации о текущем протоколе запроса.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @inherit
     *
     * @return void
     */
    public function restActionOptions(array $routeParams = [], array $queryParams = [])
    {
        Yii::$app->response->send();
    }
}
