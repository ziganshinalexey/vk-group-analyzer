<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordAdmin\forms\keyword;

use Userstory\Yii2Forms\forms\AbstractFindForm;
use yii\base\InvalidConfigException;
use yii\data\ArrayDataProvider;
use Ziganshinalexey\Keyword\entities\KeywordActiveRecord;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\MultiFindOperationInterface;
use Ziganshinalexey\Keyword\traits\keyword\KeywordComponentTrait;
use Ziganshinalexey\KeywordAdmin\traits\keyword\KeywordAdminComponentTrait;

/**
 * Класс формы для поиска сущности "Ключевое фраза".
 */
class FindForm extends AbstractFindForm
{
    use KeywordComponentTrait;
    use KeywordAdminComponentTrait;

    /**
     * Возвращает объект админского компонента.
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return mixed
     */
    public function getAdminComponent()
    {
        return $this->getKeywordAdminComponent();
    }

    /**
     * Возвращает дата-провайдер для отображения списка в таблице.
     *
     * @param array $models Массив моделей для отображения.
     *
     * @return ArrayDataProvider
     */
    protected function getDataProvider(array $models): ArrayDataProvider
    {
        return new ArrayDataProvider([
            'allModels'  => $models,
            'key'        => 'id',
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort'       => [
                'attributes' => [],
            ],
        ]);
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
     * В операции поиска устанавливает критерии фильтрации.
     *
     * @param MultiFindOperationInterface|mixed $findOperation Операция поиска.
     *
     * @throws InvalidConfigException Если аргумент не имплементирует интерфейс операции поиска.
     *
     * @return void
     */
    protected function makeFilter($findOperation): void
    {
        if (! $findOperation instanceof MultiFindOperationInterface) {
            throw new InvalidConfigException('$findOperation must implements of MultiFindOperationInterface');
        }
    }

    /**
     * Возвращает правила валидации для формы фильтра.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                ['id'],
                'integer',
                'min'         => 1,
                'max'         => 2147483647,
                'skipOnEmpty' => 1,
            ],
            [
                ['personTypeId'],
                'integer',
                'min' => -2147483648,
                'max' => 2147483647,
            ],
            [
                ['text'],
                'string',
                'max' => 65535,
            ],
        ];
    }
}
