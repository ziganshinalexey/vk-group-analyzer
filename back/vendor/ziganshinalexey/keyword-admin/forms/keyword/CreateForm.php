<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordAdmin\forms\keyword;

use Userstory\Yii2Forms\forms\AbstractCreateForm;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Keyword\entities\KeywordActiveRecord;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\traits\keyword\KeywordComponentTrait;
use Ziganshinalexey\Keyword\validators\keyword\KeywordValidator;
use function array_merge;

/**
 * Класс формы для создания сущности "Ключевое фраза".
 */
class CreateForm extends AbstractCreateForm
{
    use KeywordComponentTrait;

    /**
     * Возвращает первый элемент из списка созданных.
     *
     * @param mixed $result Результат выполнения операции.
     *
     * @return KeywordInterface
     */
    public function getResultItem($result): KeywordInterface
    {
        return $result->getKeyword();
    }

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
