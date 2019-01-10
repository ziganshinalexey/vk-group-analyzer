<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeAdmin\forms\personType;

use Userstory\Yii2Forms\forms\AbstractFindForm;
use yii\base\InvalidConfigException;
use yii\data\ArrayDataProvider;
use Ziganshinalexey\PersonType\entities\PersonTypeActiveRecord;
use Ziganshinalexey\PersonType\interfaces\personType\operations\MultiFindOperationInterface;
use Ziganshinalexey\PersonType\traits\personType\PersonTypeComponentTrait;
use Ziganshinalexey\PersonTypeAdmin\traits\personType\PersonTypeAdminComponentTrait;

/**
 * Класс формы для поиска сущности "Тип личности".
 */
class FindForm extends AbstractFindForm
{
    use PersonTypeComponentTrait;
    use PersonTypeAdminComponentTrait;

    /**
     * Возвращает объект админского компонента.
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return mixed
     */
    public function getAdminComponent()
    {
        return $this->getPersonTypeAdminComponent();
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
        $this->setDtoComponent($this->getPersonTypeComponent());
        $this->setActiveRecordClass(PersonTypeActiveRecord::class);
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
                ['name'],
                'string',
                'max' => 255,
            ],
        ];
    }
}
