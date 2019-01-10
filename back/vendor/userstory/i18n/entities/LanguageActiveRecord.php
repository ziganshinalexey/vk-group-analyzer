<?php

namespace Userstory\I18n\entities;

use Exception;
use ResourceBundle;
use Userstory\ComponentBase\traits\ModifierAwareTrait;
use Userstory\ComponentBase\traits\UploadFileTrait;
use Userstory\ComponentBase\traits\ValidatorTrait;
use Userstory\I18n\components\I18NComponent;
use Userstory\I18n\models\LanguageModel;
use Userstory\I18n\traits\I18nComponentTrait;
use yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Модель поддерживаемых системой языков.
 * Не использовать сохранение модели через метод save() за пределами LanguageSaveOperations.
 *
 * @property integer $id        Идентификатор модели.
 * @property string  $code      Код модели.
 * @property string  $name      Название модели.
 * @property integer $isDefault Флаг по-умолчанию.
 * @property integer $isActive  Флаг активности модели.
 * @property string  $url       Урл для модели.
 * @property string  $icon      Название иконки модели.
 */
class LanguageActiveRecord extends ActiveRecord
{
    use UploadFileTrait, ModifierAwareTrait, ValidatorTrait, I18nComponentTrait {
        UploadFileTrait::save as private saveUploadFileTrait;
    }

    const MAX_HEIGHT_IMAGE = 50;
    const MAX_WIDTH_IMAGE  = 50;

    /**
     * Массив с именами параметров, содержащих файлы.
     *
     * @var array
     */
    protected $entityFiles = ['icon'];

    /**
     * Список правил валидации для модели.
     *
     * @var array
     */
    protected static $ruleList = [
        [
            [
                'code',
                'name',
                'url',
                'locale',
            ],
            'required',
        ],
        [
            [
                'isDefault',
                'isActive',
                'creatorId',
                'updaterId',
            ],
            'integer',
        ],
        [
            ['code'],
            'string',
            'max' => 3,
        ],
        [
            ['name'],
            'string',
            'max' => 20,
        ],
        [
            ['url'],
            'string',
            'max' => 50,
        ],
        [
            [
                'name',
                'code',
                'url',
            ],
            'unique',
        ],
        [
            'locale',
            'validateLocale',
        ],
        [
            ['icon'],
            'file',
            'extensions' => 'png, jpg, jpeg, gif',
        ],
        [
            ['icon'],
            'image',
            'maxWidth'  => self::MAX_WIDTH_IMAGE,
            'maxHeight' => self::MAX_HEIGHT_IMAGE,
        ],
    ];

    /**
     * Данный метод возвращает имя связанной с моделью таблицы.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%language}}';
    }

    /**
     * Данный метод возвращает массив, содержащий правила валидации атрибутов.
     *
     * @return array
     */
    public function rules()
    {
        return self::$ruleList;
    }

    /**
     * Метод - валидация локали.
     *
     * @param string $localeAttr Проверяемое свойство формы - локаль.
     *
     * @return void
     */
    public function validateLocale($localeAttr)
    {
        $allLocals = ResourceBundle::getLocales('');
        if (! in_array($this->$localeAttr, $allLocals, false)) {
            $message = Yii::t('Admin.I18N.Errors', 'localeError', 'Wrong locale');
            $this->addError($localeAttr, $message);
        }
    }

    /**
     * Данный метод возвращает массив, содержащий метки атрибутов.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return LanguageModel::labels();
    }

    /**
     * Определение связи messages для класса Language.
     *
     * @return ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(MessageActiveRecord::className(), ['languageId' => 'id']);
    }

    /**
     * Переопределенный метод сохранения языка.
     *
     * @param boolean    $runValidation  валидировать/не валидировать.
     * @param null|array $attributeNames название атрибутов.
     *
     * @return boolean
     *
     * @throws Exception    Глобальные ошибки при сохранении.
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        /* @var I18NComponent $i18n */
        $i18n        = Yii::$app->i18n;
        $transaction = Yii::$app->db->beginTransaction();
        if ($this->isDefault) {
            $this->isActive = 1;
            $language       = $i18n->getModelFactory()->getLanguageGetter()->byDefault()->one();
            if ($language->getId() !== $this->id) {
                $language->isDefault = 0;
                if (! $i18n->saveLanguageByDataModel($language)) {
                    $transaction->rollBack();
                    return false;
                }
            }
        }
        if ($this->saveUploadFileTrait($runValidation, $attributeNames)) {
            $transaction->commit();
            return true;
        }
        $transaction->rollBack();
        return false;
    }
}
