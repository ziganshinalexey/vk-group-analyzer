<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordAdmin\forms\keyword;

use Userstory\Yii2Forms\forms\AbstractViewForm;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Keyword\entities\KeywordActiveRecord;
use Ziganshinalexey\Keyword\traits\keyword\KeywordComponentTrait;
use Ziganshinalexey\Keyword\validators\keyword\KeywordValidator;

/**
 * Класс админской модели работы с сущностью "Ключевое фраза".
 */
class ViewForm extends AbstractViewForm
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
     * Данный метод возвращает массив, содержащий правила валидации атрибутов.
     *
     * @return array
     */
    public function rules(): array
    {
        return KeywordValidator::getRules();
    }
}
