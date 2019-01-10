<?php

use Userstory\ComponentBase\caches\AbstractActiveRecordCache;
use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\ComponentHydrator\hydrators\ArrayHydrator;
use Userstory\I18n\components\I18NComponent;
use Userstory\I18n\entities\LanguageActiveRecord;
use Userstory\I18n\entities\MessageActiveRecord;
use Userstory\I18n\entities\SourceMessageActiveRecord;
use Userstory\I18n\factories\I18nFactory;
use Userstory\I18n\models\DbMessageModel;
use Userstory\I18n\models\LanguageModel;
use Userstory\I18n\models\MessageModel;
use Userstory\I18n\models\MixedMessageModel;
use Userstory\I18n\operations\ClearCacheOperation;
use Userstory\I18n\operations\LanguageDeleteOperation;
use Userstory\I18n\operations\LanguageGetOperation;
use Userstory\I18n\operations\LanguageSaveOperation;
use Userstory\I18n\operations\MessageCSVExportOperation;
use Userstory\I18n\operations\MessageGetOperation;
use Userstory\I18n\operations\MessageSaveOperation;
use Userstory\I18n\operations\MessageXLSXExportOperation;
use Userstory\I18n\operations\SourceMessageGetOperation;
use Userstory\I18n\queries\LanguageQuery;
use Userstory\I18n\queries\MessageQuery;
use Userstory\I18n\queries\SourceMessageQuery;

return [
    'i18n' => [
        'class'                                           => I18NComponent::class,
        ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
            'class'                            => I18nFactory::class,
            I18nFactory::MODEL_CONFIG_LIST_KEY => [
                I18nFactory::LANGUAGE_MODEL               => [
                    I18nFactory::OBJECT_TYPE_KEY => LanguageModel::class,
                ],
                I18nFactory::LANGUAGE_QUERY               => [
                    I18nFactory::OBJECT_TYPE_KEY   => LanguageQuery::class,
                    I18nFactory::OBJECT_PARAMS_KEY => LanguageActiveRecord::class,
                ],
                I18nFactory::LANGUAGE_GET_OPERATION       => [
                    I18nFactory::OBJECT_TYPE_KEY => LanguageGetOperation::class,
                ],
                I18nFactory::LANGUAGE_SAVE_OPERATION      => [
                    I18nFactory::OBJECT_TYPE_KEY => LanguageSaveOperation::class,
                ],
                I18nFactory::LANGUAGE_DELETE_OPERATION    => [
                    I18nFactory::OBJECT_TYPE_KEY => LanguageDeleteOperation::class,
                ],
                I18nFactory::LANGUAGE_CACHE_MODEL         => [
                    I18nFactory::OBJECT_TYPE_KEY => [
                        'class'          => AbstractActiveRecordCache::class,
                        'cacheKeyPrefix' => 'i18n-language',
                    ],
                ],
                I18nFactory::MESSAGE_MODEL                => [
                    I18nFactory::OBJECT_TYPE_KEY => MessageModel::class,
                ],
                I18nFactory::MESSAGE_QUERY                => [
                    I18nFactory::OBJECT_TYPE_KEY   => MessageQuery::class,
                    I18nFactory::OBJECT_PARAMS_KEY => MessageActiveRecord::class,
                ],
                I18nFactory::MESSAGE_GET_OPERATION        => [
                    I18nFactory::OBJECT_TYPE_KEY => MessageGetOperation::class,
                ],
                I18nFactory::MESSAGE_SAVE_OPERATION       => [
                    I18nFactory::OBJECT_TYPE_KEY => MessageSaveOperation::class,
                ],
                I18nFactory::MESSAGE_CACHE_MODEL          => [
                    I18nFactory::OBJECT_TYPE_KEY => [
                        'class'          => AbstractActiveRecordCache::class,
                        'cacheKeyPrefix' => 'i18n-message',
                    ],
                ],
                I18nFactory::MESSAGE_CSV_EXPORTER         => [
                    I18nFactory::OBJECT_TYPE_KEY => MessageCSVExportOperation::class,
                ],
                I18nFactory::MESSAGE_XLSX_EXPORTER        => [
                    I18nFactory::OBJECT_TYPE_KEY => MessageXLSXExportOperation::class,
                ],
                I18nFactory::SOURCE_MESSAGE_QUERY         => [
                    I18nFactory::OBJECT_TYPE_KEY   => SourceMessageQuery::class,
                    I18nFactory::OBJECT_PARAMS_KEY => SourceMessageActiveRecord::class,
                ],
                I18nFactory::SOURCE_MESSAGE_GET_OPERATION => [
                    I18nFactory::OBJECT_TYPE_KEY => SourceMessageGetOperation::class,
                ],
                I18nFactory::HYDRATOR_MODEL               => [
                    I18nFactory::OBJECT_TYPE_KEY => ArrayHydrator::class,
                ],
                I18nFactory::CLEAR_CACHE_OPERATION        => [
                    I18nFactory::OBJECT_TYPE_KEY => ClearCacheOperation::class,
                ],
            ],
        ],
        'translations'                                    => [
            'yii' => [
                'class'                 => MixedMessageModel::class,
                'on missingTranslation' => [
                    MixedMessageModel::class,
                    'missingTranslationHandler',
                ],
                'sourceLanguage'        => 'en-US',
                'basePath'              => '@yii/messages',
            ],
            '*'   => [
                'class'                 => DbMessageModel::class,
                'messageTable'          => MessageActiveRecord::tableName(),
                'sourceMessageTable'    => SourceMessageActiveRecord::tableName(),
                'on missingTranslation' => [
                    DbMessageModel::class,
                    'missingTranslationHandler',
                ],
            ],
        ],
    ],
];
