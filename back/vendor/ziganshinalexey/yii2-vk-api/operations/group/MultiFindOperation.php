<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\operations\group;

use Userstory\ComponentHydrator\traits\ObjectWithDtoHydratorTrait;
use Userstory\Yii2Dto\interfaces\results\DtoListResultInterface;
use Userstory\Yii2Dto\traits\WithDtoListResultTrait;
use Userstory\Yii2Dto\traits\WithDtoTrait;
use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\httpclient\Exception;
use yii\httpclient\Response;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\MultiFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\traits\WithHttpClientTrait;

/**
 * Операция поиска сущностей "ВК группа" на основе фильтра.
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
     * @var int|null
     */
    protected $userId;

    /**
     * Свойство содержит ключ доступа к апи.
     *
     * @var string|null
     */
    protected $accessToken;

    /**
     * Метод задает идентификатор пользователя.
     *
     * @param int $value
     *
     * @return MultiFindOperationInterface
     */
    public function setUserId(int $value): MultiFindOperationInterface
    {
        $this->userId = $value;
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
    protected function getUserId(): int
    {
        return (int)$this->userId;
    }

    /**
     * Метод возвращает токен для вк.
     *
     * @return string
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
    protected function getGroupFieldList(): array
    {
        if (! isset(Yii::$app->params['vkGroupFieldList'])) {
            throw new InvalidConfigException('user field list doesn\'t exists.');
        }
        return (array)Yii::$app->params['vkGroupFieldList'];
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
            'user_id'      => $this->getUserId(),
            'v'            => static::VERSION,
            'access_token' => $this->getAccessToken(),
            'extended'     => true,
            'fields'       => $this->getGroupFieldList(),
        ])->send();

        $data = $response->getData();
        if (! $response->getIsOk() || ! isset($data['response']['items'])) {
            $result->addUSError('Группы не найдены.');
            return $result;
        }

        $result->setDtoList($this->getGroupDto($data['response']['items']));
        return $result;
    }

    /**
     * Метод возвращает заполенный объект пользователя.
     *
     * @param array $data Данные ответа.
     *
     * @return GroupInterface[]
     *
     * @throws ExtendsMismatchException Исключение генерируется если установлен неправильный объект-результат.
     */
    protected function getGroupDto(array $data): array
    {
        $result   = [];
        $hydrator = $this->getDtoHydrator();
        foreach ($data as $groupInfo) {
            $prototype = $this->getDto()->copy();
            $result[]  = $hydrator->hydrate($groupInfo, $prototype);
        }

        return $result;
    }
}
