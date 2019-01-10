<?php

declare(strict_types = 1);

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Ziganshinalexey\KeywordAdmin\components\KeywordAdminComponent;
use Ziganshinalexey\KeywordAdmin\factories\KeywordAdminFactory;
use Ziganshinalexey\KeywordAdmin\forms\keyword\CreateForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\DeleteForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\FindForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\UpdateForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\ViewForm;

return [
    'class'                                           => KeywordAdminComponent::class,
    ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
        'class'                                    => KeywordAdminFactory::class,
        KeywordAdminFactory::MODEL_CONFIG_LIST_KEY => [
            KeywordAdminFactory::KEYWORD_CREATE_FORM => [
                KeywordAdminFactory::OBJECT_TYPE_KEY => CreateForm::class,
            ],
            KeywordAdminFactory::KEYWORD_UPDATE_FORM => [
                KeywordAdminFactory::OBJECT_TYPE_KEY => UpdateForm::class,
            ],
            KeywordAdminFactory::KEYWORD_DELETE_FORM => [
                KeywordAdminFactory::OBJECT_TYPE_KEY => DeleteForm::class,
            ],
            KeywordAdminFactory::KEYWORD_FIND_FORM   => [
                KeywordAdminFactory::OBJECT_TYPE_KEY => FindForm::class,
            ],
            KeywordAdminFactory::KEYWORD_VIEW_FORM   => [
                KeywordAdminFactory::OBJECT_TYPE_KEY => ViewForm::class,
            ],
        ],
    ],
];
