<?php

declare( strict_types = 1 );

namespace Userstory\Yii2Forms\forms\rest;

use Userstory\Yii2Forms\interfaces\rest\CreateFormInterface;
use yii\base\InvalidConfigException;

/**
 * Абстрактной класс формы для создания одной DTO.
 */
abstract class AbstractCreateRestForm extends AbstractRestForm implements CreateFormInterface
{
    /**
     * Переопределенный метод загрузки формы.
     *
     * @param array|null  $data     Данные для загрузки.
     * @param string|null $formName Название формы.
     *
     * @return boolean
     *
     * @inherit
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     */
    public function load($data, $formName = null): bool
    {
        $hydrator  = $this->getHydrator();
        $prototype = $this->getPrototype();
        $prototype = $hydrator->hydrate($data, $prototype);

        $this->setPrototype($prototype);
        return true;
    }
}
