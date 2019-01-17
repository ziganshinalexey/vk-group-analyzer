<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\operations\user;

use Userstory\ComponentHydrator\traits\ObjectWithDtoHydratorTrait;
use Userstory\Yii2Dto\interfaces\results\DtoListResultInterface;
use Userstory\Yii2Dto\traits\WithDtoListResultTrait;
use Userstory\Yii2Dto\traits\WithDtoTrait;
use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\httpclient\Exception;
use yii\httpclient\Response;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\MultiFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\traits\WithHttpClientTrait;

/**
 * Операция поиска сущностей "ВК пользователь" на основе фильтра.
 */
class MultiFindOperation extends Model implements MultiFindOperationInterface
{
    use WithDtoListResultTrait;
    use WithDtoTrait;
    use ObjectWithDtoHydratorTrait;
    use WithHttpClientTrait;

    protected const VERSION = '5.92';

    /**
     * Метод содержит идентификатор пользователя.
     *
     * @var string|null
     */
    protected $userScreenName;

    /**
     * Свойство содержит ключ доступа к апи.
     *
     * @var string|null
     */
    protected $accessToken;

    /**
     * Метод задает идентификатор пользователя.
     *
     * @param string $value
     *
     * @return MultiFindOperationInterface
     */
    public function setUserScreenName(string $value): MultiFindOperationInterface
    {
        $this->userScreenName = $value;
        return $this;
    }

    /**
     * Метод задает ключ доступа к апи.
     *
     * @param string $value
     *
     * @return MultiFindOperationInterface
     */
    public function setAccessToken(string $value): MultiFindOperationInterface
    {
        $this->accessToken = $value;
        return $this;
    }

    /**
     * Метод возвращает идентификатор пользователя.
     *
     * @return int
     */
    protected function getUserScreenName(): string
    {
        return (string)$this->userScreenName;
    }

    /**
     * Метод возвращает токен для вк.
     *
     * @return string
     *
     * @throws InvalidConfigException
     */
    protected function getAccessToken(): string
    {
        return (string)$this->accessToken;
    }

    /**
     * Метод возвращает токен для вк.
     *
     * @return array
     *
     * @throws InvalidConfigException
     */
    protected function getUserFieldList(): array
    {
        if (! isset(Yii::$app->params['vkUserFieldList'])) {
            throw new InvalidConfigException('user field list doesn\'t exists.');
        }
        return (array)Yii::$app->params['vkUserFieldList'];
    }

    /**
     * Метод возвращает все сущности по заданному фильтру.
     *
     * @return DtoListResultInterface
     *
     * @throws ExtendsMismatchException Исключение генерируется если установлен неправильный объект-результат.
     * @throws InvalidConfigException Если построение запроса сломалось.
     * @throws Exception Если получение кода ответа не удалось.
     */
    public function doOperation(): DtoListResultInterface
    {
        $result = $this->getResult();

        /* @var Response $response */
        $response = $this->getHttpClient()->createRequest()->setData([
            'user_ids'     => $this->getUserScreenName(),
            'v'            => static::VERSION,
            'access_token' => $this->getAccessToken(),
            'fields'       => $this->getUserFieldList(),
        ])->send();

        $data = $response->getData();
        if (! $response->getIsOk() || ! isset($data['response'])) {
            $result->addUSError('Пользователь не найден.');
            return $result;
        }

        $result->setDtoList([$this->getUserDto($data['response'])]);
        return $result;
    }

    /**
     * Метод возвращает заполенный объект пользователя.
     *
     * @param array $data Данные ответа.
     *
     * @return UserInterface
     *
     * @throws ExtendsMismatchException Исключение генерируется если установлен неправильный объект-результат.
     */
    protected function getUserDto(array $data): UserInterface
    {
        $prototype = $this->getDto();
        $hydrator  = $this->getDtoHydrator();

        return $hydrator->hydrate($data, $prototype);
    }
}
