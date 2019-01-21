<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordAdmin\forms\keyword;

use Userstory\Yii2Forms\forms\AbstractUpdateForm;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Keyword\entities\KeywordActiveRecord;
use Ziganshinalexey\Keyword\hydrators\KeywordDatabaseHydrator;
use Ziganshinalexey\Keyword\traits\keyword\KeywordComponentTrait;
use Ziganshinalexey\Keyword\validators\keyword\KeywordValidator;

/**
 * Класс формы для обновления сущности "Ключевое фраза".
 */
class UpdateForm extends AbstractUpdateForm
{
    use KeywordComponentTrait;

    /**
     * Инициализация объекта формы обновления.
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return void
     */
    public function init(): void
    {
        parent::init();
        $this->setDtoComponent($this->getKeywordComponent());
        $this->setActiveRecordClass(KeywordActiveRecord::class);
    }

    /**
     * @param array $data
     * @param null  $formName
     * @return bool
     * @throws InvalidConfigException
     * @throws \Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException
     */
    public function load($data, $formName = null)
    {
        $hydrator = new KeywordDatabaseHydrator();
        $hydrator->hydrate($data[$this->formName()], $this->getDto());
        return true;
    }

    /**
     * Данный метод возвращает массив, содержащий правила валидации атрибутов.
     *
     * @return array
     */
    public function rules(): array
    {
        return KeywordValidator::getRules();
    }
}
