<?php

namespace Userstory\UserAdmin\models;

use Userstory\ComponentBase\ModelView\AbstractModelView;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\web\Response;

/**
 * Класс LoginViewModel.
 * Преобразование данных для вьюшки логина.
 *
 * @package Userstory\UserAdmin\models
 */
class LoginViewModel extends AbstractModelView
{
    /**
     * Метод преобразует данные, переданные контроллером в данные передаваемые во вьюшку.
     *
     * @param mixed $data Данные, переданные контроллером.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     *
     * @return array
     */
    public function getViewData($data)
    {
        /* @var mixed $tokenAuthAdapter */
        $tokenAuthAdapter = isset($data['tokenAuthAdapter']) ? $data['tokenAuthAdapter'] : null;

        /* @var ActiveRecord $model */
        $model             = $data['model'];
        $token             = $tokenAuthAdapter ? $tokenAuthAdapter->getOpenToken() : '';
        $version           = $tokenAuthAdapter ? $tokenAuthAdapter->getLatestVersion() : '';
        $authenticationUri = $tokenAuthAdapter ? $tokenAuthAdapter->getAuthenticationUri() : '';
        $signature         = $tokenAuthAdapter ? $tokenAuthAdapter->getSignature([$token, $authenticationUri, $version]) : '';

        return [
            'needCorpAuthForm' => (bool)$tokenAuthAdapter,
            'authAdapter'      => [
                'authenticationUri' => $authenticationUri,
                'version'           => $version,
                'token'             => $token,
                'tokenServiceUri'   => $tokenAuthAdapter ? $tokenAuthAdapter->tokenServiceUri : '',
                'signature'         => $signature,
            ],
            'model'            => $model,
            'modelData'        => $model->toArray(),
            'errorsErrors'     => $model->getErrors(),
        ];
    }

    /**
     * Метод преобразует данные, переданные контроллером в данные передаваемые во вьюшку в формате JSON.
     *
     * @param mixed $data     Данные, переданные контроллером.
     * @param mixed $jsonType Форматы данных.
     *
     * @throws InvalidParamException ошибка при сериализации.
     * @throws InvalidConfigException бросает метод getViewData.
     *
     * @inherit
     *
     * @return string
     */
    public function getJsonData($data, $jsonType = Response::FORMAT_JSON)
    {
        return Json::encode($this->getViewData($data));
    }
}
