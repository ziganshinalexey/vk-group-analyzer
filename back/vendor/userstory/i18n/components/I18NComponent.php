<?php

namespace Userstory\I18n\components;

use Userstory\ComponentBase\traits\ModelsFactoryTrait;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotCloseException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotLockException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotOpenException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotUnlockException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotWriteException;
use Userstory\ComponentHelpers\helpers\exceptions\IsNotWritableException;
use Userstory\I18n\entities\LanguageActiveRecord;
use Userstory\I18n\interfaces\I18nFactoryInterface;
use Userstory\I18n\interfaces\LanguageInterface;
use Userstory\I18n\interfaces\MessageInterface;
use Userstory\I18n\interfaces\SourceMessageInterface;
use Userstory\I18n\translations\DbMessageSource;
use yii;
use yii\base\Exception;
use yii\base\ExitException;
use yii\base\InvalidConfigException;
use yii\base\InvalidValueException;
use yii\data\ArrayDataProvider;
use yii\i18n\I18N;
use yii\web\NotFoundHttpException;
use yii\web\RangeNotSatisfiableHttpException;

/**
 * Данный класс расширяет класс \yii\i18n\I18N.
 * В нем переопределяется метод translate(), что необходимо для добавления в базу данных сообщений и их переводов.
 *
 * @package Userstory\I18n\components
 */
class I18NComponent extends I18N
{
    use ModelsFactoryTrait {
        ModelsFactoryTrait::getModelFactory as getModelFactoryFromTrait;
    }

    /**
     * Свойство хранит язык по-умолчанию.
     *
     * @var LanguageInterface|null
     */
    protected $defaultLanguage;

    /**
     * Свойство хранит текущий язык.
     *
     * @var LanguageInterface|null
     */
    protected $currentLanguage;

    /**
     * Метод получает фабрику моделей для компонента метрик.
     *
     * @return I18nFactoryInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случе неверной конфигурации фабрики моделей.
     */
    public function getModelFactory()
    {
        $modelFactory = $this->getModelFactoryFromTrait();
        if (! $modelFactory instanceof I18nFactoryInterface) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . I18nFactoryInterface::class);
        }
        return $modelFactory;
    }

    /**
     * Данный метод возвращает идентификатора заданного по умолчанию языка или null, если язык по умолчанию не задан.
     *
     * @return integer|null
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getDefaultLanguageId()
    {
        $model = $this->getDefaultLanguage();
        if (empty($model)) {
            return null;
        }
        return $model->getId();
    }

    /**
     * Возвращает код языка по умолчанию.
     *
     * @return null|string
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getDefaultLanguageCode()
    {
        $model = $this->getDefaultLanguage();
        if (empty($model)) {
            return null;
        }
        return $model->getCode();
    }

    /**
     * Возвращает код текущего языка.
     *
     * @return string|null
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getCurrentLanguageCode()
    {
        $model = $this->getCurrentLanguage();
        if (empty($model)) {
            return null;
        }
        return $model->getCode();
    }

    /**
     * Возвращает Url текущего языка. Или, если не вышло - урл языка по умолчанию.
     *
     * @param boolean $default возвращать ли дефолтный урл, если ничего не вышло?.
     *
     * @return string|boolean
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getCurrentLanguageUrl($default = true)
    {
        $model = $this->getCurrentLanguage();
        if ($model) {
            return $model->getUrl();
        }
        if (! $default) {
            return false;
        }
        $model = $this->getDefaultLanguage();
        return $model->getUrl();
    }

    /**
     * Возвращает модель текущего языка.
     *
     * @return LanguageInterface
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getCurrentLanguage()
    {
        $url = preg_replace('/(\w+)\/?(.*)/', '$1', Yii::$app->request->url);
        $url = trim($url, '/');

        if (empty($this->currentLanguage)) {
            $this->currentLanguage = $this->getLanguageByUrl($url);
            if (empty($this->currentLanguage)) {
                $this->currentLanguage = $this->getDefaultLanguage();
            }
        }

        return $this->currentLanguage;
    }

    /**
     * Метод-прокси возвращает язык по его url.
     *
     * @param string $url URL для языка.
     *
     * @return LanguageInterface
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getLanguageByUrl($url)
    {
        return $this->getModelFactory()->getLanguageGetter()->byUrl($url)->one();
    }

    /**
     * Возвращает модель языка по Uri.
     *
     * @param string $url Урл языка.
     *
     * @return LanguageInterface
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getLanguageByUri($url)
    {
        $url = preg_replace('/(\w+)\/?(.*)/', '$1', $url);
        $url = trim($url, '/');

        return $this->getLanguageByUrl($url);
    }

    /**
     * Метод-прокси возвращает язык по умолчанию.
     *
     * @return LanguageInterface
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getDefaultLanguage()
    {
        if (empty($this->defaultLanguage)) {
            $this->defaultLanguage = $this->getModelFactory()->getLanguageGetter()->byDefault()->one();
        }
        return $this->defaultLanguage;
    }

    /**
     * Метод-прокси возвращает идентификатор языка, используя его код.
     *
     * @param string $code Код языка, Айди которого желаем получить.
     *
     * @return integer
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getLanguageIdByCode($code)
    {
        $model = $this->getModelFactory()->getLanguageGetter()->byCode($code)->one();

        if (empty($model)) {
            return $this->getDefaultLanguageId();
        }
        return $model->getId();
    }

    /**
     * Метод-прокси возвращает язык по его идентификатору.
     *
     * @param integer $id Айди языка, который будем возвращать.
     *
     * @return LanguageInterface
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getLanguageById($id)
    {
        return $this->getModelFactory()->getLanguageGetter()->byId($id)->one();
    }

    /**
     * Метод-прокси возвращает все активные языки.
     *
     * @return LanguageInterface[]
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getAllActiveLanguages()
    {
        return $this->getModelFactory()->getLanguageGetter()->byActive()->all();
    }

    /**
     * Метод-прокси возвращает все модели языков с стандартной сортировкой.
     *
     * @return LanguageInterface[]
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getLanguagesWithSort()
    {
        return $this->getModelFactory()->getLanguageGetter()->sort()->all();
    }

    /**
     * Метод-прокси сохранения языка через модель данных.
     *
     * @param LanguageInterface $language Модель данных.
     *
     * @return boolean
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function saveLanguageByDataModel(LanguageInterface $language)
    {
        return $this->getModelFactory()->getLanguageSaver()->saveByDataModel($language);
    }

    /**
     * Метод-прокси сохранения языка через сущность.
     *
     * @param LanguageActiveRecord $language Сущность языка.
     *
     * @return boolean
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function saveLanguageByEntityModel(LanguageActiveRecord $language)
    {
        return $this->getModelFactory()->getLanguageSaver()->saveByEntityModel($language);
    }

    /**
     * Метод-прокси для удаления языка по идентификатору.
     *
     * @param integer $id Идентификатор языка.
     *
     * @return boolean
     *
     * @throws NotFoundHttpException Генерирует в случае отсутствия языка.
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function deleteLanguageById($id)
    {
        return $this->getModelFactory()->getLanguageRemover()->deleteById($id);
    }

    /**
     * Метод создает сообщение-перевод.
     *
     * @param integer $id          Идентификатор сообщения.
     * @param integer $langId      Идентификатор языка.
     * @param string  $translation Необходимый перевод.
     *
     * @return MessageInterface
     *
     * @throws NotFoundHttpException Генерирует в случае отсутствия блока данных для перевода.
     * @throws InvalidConfigException  Генерирует при неверной конфигурации.
     */
    public function createMessage($id, $langId, $translation = '')
    {
        if (null === $sourceMessage = $this->getSourceMessageById($id)) {
            throw new NotFoundHttpException('Source message doesn\'t exists');
        }
        $model = $this->getModelFactory()->getMessageModel();
        $model->setId($id);
        $model->setLanguageId($langId);
        $model->sourceMessage = $sourceMessage;
        if ($translation) {
            $model->setTranslation($translation);
        }
        return $model;
    }

    /**
     * Устанавливает перевод сообщения, если сообщения нет, то создаёт его.
     *
     * @param integer $id          Идентификатор сообщения.
     * @param integer $langId      Идентификатор языка.
     * @param string  $translation Непосредственно Перевод.
     *
     * @return MessageInterface
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     * @throws NotFoundHttpException Генерирует если ресурс сообщения не найден.
     */
    public function setMessageTranslation($id, $langId, $translation)
    {
        if (empty($this->getSourceMessageById($id))) {
            throw new InvalidValueException('Source message doesn\'t exists');
        }

        $model = $this->getModelFactory()->getMessageGetter()->byLanguageId($langId)->byMessageId($id)->one();

        if (empty($model)) {
            $model = $this->createMessage($id, $langId);
        }

        $model->setTranslation($translation);
        return $model;
    }

    /**
     * Сохранения перевода через модель данных.
     *
     * @param MessageInterface $message    Модель данных.
     * @param boolean          $clearCache Флаг чистки кеша.
     *
     * @return boolean
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function saveMessageByDataModel(MessageInterface $message, $clearCache = true)
    {
        return $this->getModelFactory()->getMessageSaver()->saveByDataModel($message, $clearCache);
    }

    /**
     * Метод возвращает список алиасиов и их перевод на нужном языке.
     *
     * @param string  $category   Названием категории.
     * @param integer $languageId Идентификатор языка.
     *
     * @return array
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getMessagesWithTranslations($category, $languageId)
    {
        $modelList = $this->getModelFactory()->getMessageGetter()->byCategory($category)->byLanguageId($languageId)->all();

        $result = [];
        foreach ($modelList as $model) {
            $result[$model->getId()] = [
                'message'     => $model->sourceMessage->message,
                'translation' => $model->getTranslation(),
            ];
        }

        return $result;
    }

    /**
     * Возвращет исходное сообщение (к которому привязаны переводы).
     *
     * @param string $category категория.
     * @param string $message  сообщение.
     *
     * @return SourceMessageInterface|null
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getSourceMessageByCategory($category, $message)
    {
        return $this->getModelFactory()->getSourceMessageGetter()->getByCategoryAndAlias($category, $message);
    }

    /**
     * Возвращает исходное сообщение по его айди.
     *
     * @param integer $id Айди исходного сообщения, которое желаем получить.
     *
     * @return null|SourceMessageInterface
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getSourceMessageById($id)
    {
        return $this->getModelFactory()->getSourceMessageGetter()->getById($id);
    }

    /**
     * Данный метод переводит сообщение на указанный язык.
     *
     * @param string       $category Строка с названием категории.
     * @param string       $message  Строка с сообщением.
     * @param array|string $params   Массив с параметрами или строка с переводом по умолчанию.
     * @param string       $language Строка с кодом языка.
     *
     * @throws InvalidConfigException если нет источника сообщения для указанной категории.
     *
     * @return string
     */
    public function translate($category, $message, $params, $language)
    {
        /* @var DbMessageSource $messageSource */
        $messageSource         = $this->getMessageSource($category);
        $isCustomMessageSource = method_exists($messageSource, 'translateSourceMessage');
        if ($isCustomMessageSource) {
            $defTranslation = is_string($params) ? $params : '';
            if ('' === $defTranslation && is_array($params) && array_key_exists('defaultTranslation', $params)) {
                $defTranslation = $params['defaultTranslation'];
            }
            $translation = $messageSource->translateSourceMessage($category, $message, $language, $defTranslation);
        } else {
            $translation = $messageSource->translate($category, $message, $language);
        }
        if (false === $translation) {
            return $this->format($message, $params, $messageSource->sourceLanguage);
        }
        return $this->format($translation, $params, $language);
    }

    /**
     * Метод переводит сообщение на текущий язык.
     * Может быть использовано для конфигурационных файлов.
     *
     * @param string       $category Категория сообщения.
     * @param array|string $config   Конфигурация перевода: Сообщение либо ['Константа', 'Дефолтный перевод'].
     *
     * @throws Exception Исключение, если передан неверный формат конфигурации.
     *
     * @return string
     */
    public function t($category, $config)
    {
        if (is_string($config)) {
            return $config;
        } elseif (! is_array($config) || ! count($config) || count($config) > 1) {
            throw new Exception('Wrong translate configuration!');
        }

        return Yii::t($category, key($config), reset($config));
    }

    /**
     * Метод возвращает провайдер данных для переводов.
     *
     * @param string  $needle     Фильтр поиска переводов.
     * @param integer $languageId Индификатор языка.
     *
     * @return ArrayDataProvider
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getTranslationDataProvider($needle, $languageId = null)
    {
        $models       = $this->getModelFactory()->getSourceMessageGetter()->getSearchModelList($needle, $languageId);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
            'key'       => 'id',
        ]);
        return $dataProvider;
    }

    /**
     * Метод возвращает провайдер данных для языков.
     *
     * @return ArrayDataProvider
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getLanguageDataProvider()
    {
        $models       = $this->getLanguagesWithSort();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
            'key'       => 'id',
        ]);
        return $dataProvider;
    }

    /**
     * Метод-прокси для очиски кеша компонента.
     *
     * @return void
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function flush()
    {
        $this->getModelFactory()->getClearCacheOperation()->flush();
    }

    /**
     * Метод возврашает переводы в виде файла.
     *
     * @param integer $languageId Идентификатор языка.
     * @param string  $fileType   Тип файла (Доступные расширения 0.3.9: xlsx, csv).
     *
     * @return void
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     * @throws NotFoundHttpException Генерирует в случае не правильного формата.
     * @throws ExitException Генерирует при неверной конфигурации.
     * @throws RangeNotSatisfiableHttpException Генерирует при неверной конфигурации.
     */
    public function getTranslatesAsFile($languageId, $fileType = 'xlsx')
    {
        $language = $this->getLanguageById($languageId);
        if (empty($language)) {
            throw new NotFoundHttpException();
        }
        $this->getModelFactory()->getMessageExporter($fileType)->send($language);
    }

    /**
     * Метод возврашает путь к файлам с переводами.
     *
     * @param integer $languageId Идентификатор языка.
     * @param string  $fileType   Тип файла (Доступные расширения 0.3.9: xlsx, csv).
     *
     * @return string
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     * @throws NotFoundHttpException Генерирует в случае не правильного формата.
     * @throws FileNotCloseException Генерирует в случае неправильной работы с файлами.
     * @throws FileNotLockException Генерирует в случае неправильной работы с файлами.
     * @throws FileNotOpenException Генерирует в случае неправильной работы с файлами.
     * @throws FileNotUnlockException Генерирует в случае неправильной работы с файлами.
     * @throws FileNotWriteException Генерирует в случае неправильной работы с файлами.
     * @throws IsNotWritableException Генерирует в случае неправильной работы с файлами.
     */
    public function getTranslatesFilePath($languageId, $fileType = 'xlsx')
    {
        $language = $this->getLanguageById($languageId);
        if (empty($language)) {
            throw new NotFoundHttpException();
        }
        return $this->getModelFactory()->getMessageExporter($fileType)->getFilePath($language);
    }
}
