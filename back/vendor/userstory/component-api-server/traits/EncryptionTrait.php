<?php

namespace Userstory\ComponentApiServer\traits;

use yii;
use yii\base\InvalidParamException;

/**
 * Class CryptBehavior.
 * Трейт для базовых операций шифрования.
 *
 * @package Userstory\ComponentApiServer\traits
 */
trait EncryptionTrait
{
    /**
     * Включено ли шифрование данных.
     *
     * @var boolean
     */
    protected $enableEncryption = false;

    /**
     * Свойство содержит путь к файлу публичного или приватного ключа.
     *
     * @var string|null
     */
    protected $keyPath;

    /**
     * Сеттер для задания активности состояния шифрования: включено или нет.
     *
     * @param boolean $isEnabled Включено или нет.
     *
     * @return static
     */
    protected function setEnableEncryption($isEnabled)
    {
        $this->enableEncryption = $isEnabled;

        return $this;
    }

    /**
     * Геттер активности состояния шифрования.
     *
     * @return static
     */
    protected function getEnableEncryption()
    {
        return $this->enableEncryption;
    }

    /**
     * Сеттер для задания пути к файлу с публичным или приватным ключом.
     *
     * @param string $path Путь к файлу.
     *
     * @throws InvalidParamException Исключение, если путь указан неверно.
     *
     * @return static
     */
    protected function setKeyPath($path)
    {
        $this->keyPath = 'file://' . Yii::getAlias($path);

        return $this;
    }

    /**
     * Метод зашифровывает переданные данные.
     *
     * @param mixed $data Данные для шифрования.
     *
     * @return mixed
     */
    abstract public function encrypt($data);

    /**
     * Метод расшифровывает переданные данные.
     *
     * @param mixed $data Данные для расшифровывания.
     *
     * @return mixed
     */
    abstract public function decrypt($data);
}
