<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\operations\user;

use Userstory\ComponentHydrator\traits\ObjectWithDtoHydratorTrait;
use Userstory\Yii2Dto\interfaces\results\DtoListResultInterface;
use Userstory\Yii2Dto\traits\WithDtoListResultTrait;
use Userstory\Yii2Dto\traits\WithDtoTrait;
use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use yii\base\InvalidConfigException;
use yii\base\Model;
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

    /**
     * Метод содержит идентификатор пользователя.
     *
     * @var string|null
     */
    protected $userScreenName;

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
     * Метод возвращает идентификатор пользователя.
     *
     * @return int
     */
    protected function getUserScreenName(): string
    {
        return (string)$this->userScreenName;
    }

    /**
     * Метод возвращает все сущности по заданному фильтру.
     *
     * @return DtoListResultInterface
     *
     * @throws ExtendsMismatchException Исключение генерируется если установлен неправильный объект-результат.
     */
    public function doOperation(): DtoListResultInterface
    {
        return $this->getResult();
    }
}
