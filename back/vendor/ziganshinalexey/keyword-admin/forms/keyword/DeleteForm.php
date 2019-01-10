<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordAdmin\forms\keyword;

use Userstory\Yii2Forms\forms\AbstractDeleteForm;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Keyword\entities\KeywordActiveRecord;
use Ziganshinalexey\Keyword\traits\keyword\KeywordComponentTrait;
use Ziganshinalexey\Keyword\validators\keyword\KeywordValidator;

/**
 * Класс формы для удаления сущности "Ключевое фраза".
 */
class DeleteForm extends AbstractDeleteForm
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
