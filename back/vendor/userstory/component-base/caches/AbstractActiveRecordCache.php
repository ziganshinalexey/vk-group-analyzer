<?php

namespace Userstory\ComponentBase\caches;

use Exception;
use Userstory\ComponentBase\interfaces\ActiveRecordCacheInterface;
use Userstory\ComponentBase\interfaces\DataModelInterface;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use yii;
use yii\db\ActiveRecordInterface;

/**
 * Класс AbstractActiveRecordCache реализовывает базовые методы для кеширования модели данных.
 *
 * @deprecated Очень медленно работает сброс кеша при большом количестве данных в кеше. Не рекомендую использовать.
 *
 * @package Userstory\ComponentBase\caches
 */
class AbstractActiveRecordCache extends AbstractCache implements ActiveRecordCacheInterface
{
    /**
     * Свойство хранит объект гидратора.
     *
     * @var HydratorInterface|null
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     */
    protected $hydrator;

    /**
     * Свойство хранит объект для преобразования данных.
     *
     * @var DataModelInterface|null
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     */
    protected $modelInstance;

    /**
     * Метод задает значение объекту для преобразования данных.
     *
     * @param DataModelInterface $value Новое значение.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     *
     * @return void
     */
    public function setModelInstance(DataModelInterface $value)
    {
        $this->modelInstance = $value;
    }

    /**
     * Метод возвращает значение объекта для преобразования данных.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     *
     * @return DataModelInterface
     */
    public function getModelInstance()
    {
        return $this->modelInstance;
    }

    /**
     * Метод задает значение для объекта гидратора.
     *
     * @param HydratorInterface $value Новое значение.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     *
     * @return void
     */
    public function setHydrator(HydratorInterface $value)
    {
        $this->hydrator = $value;
    }

    /**
     * Метод возвращает значение объекта гидратора.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     *
     * @return HydratorInterface
     */
    public function getHydrator()
    {
        return $this->hydrator;
    }

    /**
     * Метод очистки кеша по данным из модели.
     *
     * @param ActiveRecordInterface $model Объект сущности.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     *
     * @return void
     */
    public function clearCacheByModel(ActiveRecordInterface $model)
    {
        $newData = $model->getAttributes();
        $oldData = $model->getOldAttributes();

        $partKeyList = [];
        foreach ($newData as $attribute => $value) {
            $partKeyList[] = sprintf('%s-%s-', $attribute, preg_replace('%[^a-zа-я\d]%i', '', $value));
            if (isset($oldData[$attribute])) {
                $partKeyList[] = sprintf('%s-%s-', $attribute, preg_replace('%[^a-zа-я\d]%i', '', $oldData[$attribute]));
            }
        }
        $partKeyList = array_unique($partKeyList);

        foreach ($partKeyList as $partKey) {
            $foulKeyList = $this->findKey($partKey);
            if (empty($foulKeyList)) {
                continue;
            }
            foreach ($foulKeyList as $foulKey) {
                $this->flushByKey($foulKey);
            }
        }
        $this->flushByKey($this->cacheKeyPrefix . '-all-');
    }

    /**
     * Метод получения модели из кеша.
     *
     * @param string $cacheKey Ключ по которому получаем данные из кеша.
     *
     * @return false|DataModelInterface[]
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     *
     * @throws Exception, Генерирует в случае отсутстввия данных в кеше с таким именем формы.
     */
    protected function getData($cacheKey)
    {
        if (false === ( $data = Yii::$app->cache->get($cacheKey) )) {
            return false;
        }

        $result = [];
        foreach ($data as $postData) {
            if (empty($postData)) {
                continue;
            }
            $dataModel = $this->getModelInstance()->copy();
            if (! isset($postData[$dataModel->formName()])) {
                throw new Exception();
            }
            $this->getHydrator()->hydrate($postData[$dataModel->formName()], $dataModel);
            $result[] = $dataModel;
        }

        return $result;
    }

    /**
     * Метод кладет данные в кеш.
     *
     * @param string $cacheKey Имя ключа кеширования.
     * @param mixed  $value    Кешированное значение.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     *
     * @return boolean
     */
    protected function putData($cacheKey, $value)
    {
        if (empty($value)) {
            return Yii::$app->cache->set($cacheKey, $value);
        }

        $data = [];
        foreach ($value as $item) {
            if (empty($item)) {
                continue;
            }
            $data[] = [$item->formName() => $this->getHydrator()->extract($item)];
        }
        return Yii::$app->cache->set($cacheKey, $data);
    }
}
