<?php

declare(strict_types = 1);

namespace app\api\v1\forms\vk;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\httpclient\Client;
use yii\httpclient\Exception;
use yii\httpclient\Response;

/**
 * Форма данных для REST-метода выборки сущности "Ключевое фраза".
 */
class AccessTokenForm extends Model
{
    /**
     * Свойство содержит урл пользователя в вк.
     *
     * @var string|null
     */
    protected $code;

    /**
     * Свойство содержит урл пользователя в вк.
     *
     * @var string|null
     */
    protected $redirectUrl;

    /**
     * Метод возвращает урл пользователя в вк.
     *
     * @return string|null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Метод возвращает урл пользователя в вк.
     *
     * @return string|null
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * Переопределенный метод возвращает правила валидации формы.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'code',
                    'redirectUrl',
                ],
                'required',
            ],
            [
                [
                    'code',
                    'redirectUrl',
                ],
                'string',
                'max' => 255,
            ],
        ];
    }

    /**
     * Осуществлет основное действие формы - просмотр элемента.
     *
     * @return array|null
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     * @throws Exception
     */
    public function run(): ?array
    {
        if (! $this->validate()) {
            return null;
        }

        $client = new Client();
        /* @var Response $response */
        $response = $client->createRequest()->setUrl('https://oauth.vk.com/access_token')->setMethod('GET')->setData([
            'client_id'     => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'code'          => $this->getCode(),
            'redirect_uri'  => $this->getRedirectUrl(),
        ])->send();

        $data = $response->getData();
        if (! $response->getIsOk() || ! isset($data['access_token'])) {
            $this->addError('system', 'access token not found');
            return null;
        }

        return [
            'accessToken' => $data['access_token'],
            'expiresIn'   => $data['expires_in'],
            'userId'      => $data['user_id'],
        ];
    }

    /**
     * Метод возвращает ключ приложения.
     *
     * @return string
     *
     * @throws InvalidConfigException
     */
    protected function getClientId(): string
    {
        if (! isset(Yii::$app->params['vkAppId'])) {
            throw new InvalidConfigException('vk application id is empty');
        }
        return (string)Yii::$app->params['vkAppId'];
    }

    /**
     * Метод возвращает секретное слово приложения.
     *
     * @return string
     *
     * @throws InvalidConfigException
     */
    protected function getClientSecret(): string
    {
        if (! isset(Yii::$app->params['vkSecureKey'])) {
            throw new InvalidConfigException('vk secret code is empty');
        }
        return (string)Yii::$app->params['vkSecureKey'];
    }
}
