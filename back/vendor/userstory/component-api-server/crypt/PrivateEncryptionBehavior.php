<?php

namespace Userstory\ComponentApiServer\crypt;

use Userstory\ComponentApiServer\components\ApiServerComponent;
use Userstory\ComponentApiServer\traits\EncryptionTrait;
use yii;
use yii\base\Behavior;
use yii\base\ErrorException;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class PrivateEncryptionBehavior.
 * Класс поведения для реализации механизма шифрования обмена данными между SaaS и игровым сервером.
 *
 * @package Userstory\ComponentApiClient\crypt
 */
class PrivateEncryptionBehavior extends Behavior
{
    use EncryptionTrait;

    /**
     * Метод возвращает обработчики на родительские события.
     *
     * @return array
     */
    public function events()
    {
        return ArrayHelper::merge(parent::events(), [
            ApiServerComponent::EVENT_API_BEFORE_ACTION => 'decryptRequest',
            ApiServerComponent::EVENT_API_REQUEST       => 'encryptResponse',
        ]);
    }

    /**
     * Метод обрабатывает событие api запроса: расшифровывает данные запроса.
     *
     * @return void
     */
    public function decryptRequest()
    {
        $data = Yii::$app->request->getBodyParam(0);
        Yii::$app->request->setBodyParams($this->decrypt($data));
    }

    /**
     * Метод обрабатывает событие api запроса: зашифровывает данные ответа.
     *
     * @return void
     */
    public function encryptResponse()
    {
        $data = Yii::$app->response->data;

        Yii::$app->response->data    = null;
        Yii::$app->response->content = $this->encrypt(Json::encode($data));
    }

    /**
     * Метод зашифровывает переданные данные.
     *
     * @param mixed $data Данные для шифрования.
     *
     * @throws ErrorException Исключение при ошибке шифрования.
     *
     * @return mixed
     */
    public function encrypt($data)
    {
        if (empty($data) || ! $this->isEnabledEncryption()) {
            return $data;
        }

        $encryptingData = serialize($data);
        $privateKey     = openssl_pkey_get_private($this->keyPath);

        if (! $privateKey) {
            throw new ErrorException('Failed to get private key');
        }

        $keyDetails = openssl_pkey_get_details($privateKey);
        $blockSize  = ceil($keyDetails['bits'] / 8) - 11;
        $output     = '';

        $encryptingData = str_split($encryptingData, $blockSize);

        foreach ($encryptingData as $key => $block) {
            $encrypted = '';
            if (! openssl_private_encrypt($block, $encrypted, $privateKey)) {
                throw new ErrorException('Failed to encrypting data');
            }

            $output .= $encrypted;

            unset($encryptingData[$key]);
        }

        openssl_free_key($privateKey);

        return base64_encode($output);
    }

    /**
     * Метод расшифровывает переданные данные.
     *
     * @param mixed $data Данные для расшифровывания.
     *
     * @throws ErrorException Исключение при ошибке шифрования.
     *
     * @return mixed
     */
    public function decrypt($data)
    {
        if (empty($data) || ! $this->isEnabledEncryption()) {
            return $data;
        }

        $decryptingData = base64_decode($data);
        $privateKey     = openssl_pkey_get_private($this->keyPath);

        if (! $privateKey) {
            throw new ErrorException('Failed to get private key');
        }

        $keyDetails = openssl_pkey_get_details($privateKey);
        $blockSize  = ceil($keyDetails['bits'] / 8);
        $output     = '';

        $decryptingData = str_split($decryptingData, $blockSize);

        foreach ($decryptingData as $key => $block) {
            $decrypted = '';
            if (! openssl_private_decrypt($block, $decrypted, $privateKey)) {
                throw new ErrorException('Failed to decrypting data');
            }

            $output .= $decrypted;

            unset($decryptingData[$key]);
        }

        openssl_free_key($privateKey);

        return unserialize($output);
    }

    /**
     * Метод проверяет включено ли шифрование.
     *
     * @return boolean
     */
    protected function isEnabledEncryption()
    {
        /* @var ApiServerComponent $apiServer */
        $apiServer        = Yii::$app->apiServer;
        $globalEncryption = $this->enableEncryption;

        if (null === $apiServer->action) {
            return $globalEncryption;
        }

        $actionEncryption = $apiServer->action->enableEncryption;

        return ( true === $actionEncryption ) || ( null === $actionEncryption && $globalEncryption );
    }
}
