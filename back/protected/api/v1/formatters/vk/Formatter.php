<?php

declare(strict_types = 1);

namespace app\api\v1\formatters\vk;

use ReflectionException;
use Userstory\ComponentHydrator\formatters\ArrayFormatter;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;

/**
 * Форматтер данных для возврата из REST-метода создания сущности "Ключевое фраза".
 */
class Formatter extends ArrayFormatter
{
    /**
     * Метод преобразует объект в обычный массив и убирает данные, которых не должно быть в ответе.
     *
     * @param mixed $object Объект для форматирования.
     *
     * @throws ReflectionException Генерирует, если класс отсутствует.
     *
     * @inherit
     *
     * @return array
     */
    public function format($object): array
    {
        ['user' => $user] = $object;

        return [
            'user' => $this->formatUser($user),
        ];
    }

    /**
     * Метод возвращает пользовательские данные.
     *
     * @param UserInterface $user
     *
     * @return array
     */
    protected function formatUser(UserInterface $user): array
    {
        return [
            'id'             => $user->getId(),
            'photo'          => $user->getPhoto(),
            'firstName'      => $user->getFirstName(),
            'lastName'       => $user->getLastName(),
            'facultyName'    => $user->getFacultyName(),
            'universityName' => $user->getUniversityName(),
        ];
    }
}
