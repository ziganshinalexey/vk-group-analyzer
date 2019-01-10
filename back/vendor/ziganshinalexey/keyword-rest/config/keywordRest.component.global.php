<?php

declare(strict_types = 1);

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Ziganshinalexey\Keyword\dataTransferObjects\keyword\Keyword;
use Ziganshinalexey\Keyword\filters\keyword\MultiFilter;
use Ziganshinalexey\Keyword\validators\keyword\KeywordFilterValidator;
use Ziganshinalexey\KeywordRest\api\v1\forms\keyword\CreateForm;
use Ziganshinalexey\KeywordRest\api\v1\forms\keyword\DeleteForm;
use Ziganshinalexey\KeywordRest\api\v1\forms\keyword\ListForm;
use Ziganshinalexey\KeywordRest\api\v1\forms\keyword\UpdateForm;
use Ziganshinalexey\KeywordRest\api\v1\forms\keyword\ViewForm;
use Ziganshinalexey\KeywordRest\api\v1\hydrators\keyword\FilterHydrator;
use Ziganshinalexey\KeywordRest\api\v1\hydrators\keyword\Hydrator;
use Ziganshinalexey\KeywordRest\components\KeywordRestComponent;
use Ziganshinalexey\KeywordRest\factories\KeywordRestFactory;

return [
    'class'                                           => KeywordRestComponent::class,
    ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
        'class'                                   => KeywordRestFactory::class,
        KeywordRestFactory::MODEL_CONFIG_LIST_KEY => [
            KeywordRestFactory::KEYWORD_CREATE_FORM      => [
                KeywordRestFactory::OBJECT_TYPE_KEY => CreateForm::class,
            ],
            KeywordRestFactory::KEYWORD_DELETE_FORM      => [
                KeywordRestFactory::OBJECT_TYPE_KEY => DeleteForm::class,
            ],
            KeywordRestFactory::KEYWORD_LIST_FORM        => [
                KeywordRestFactory::OBJECT_TYPE_KEY => ListForm::class,
            ],
            KeywordRestFactory::KEYWORD_UPDATE_FORM      => [
                KeywordRestFactory::OBJECT_TYPE_KEY => UpdateForm::class,
            ],
            KeywordRestFactory::KEYWORD_VIEW_FORM        => [
                KeywordRestFactory::OBJECT_TYPE_KEY => ViewForm::class,
            ],
            KeywordRestFactory::KEYWORD_FILTER           => [
                KeywordRestFactory::OBJECT_TYPE_KEY => MultiFilter::class,
            ],
            KeywordRestFactory::KEYWORD_FILTER_VALIDATOR => [
                KeywordRestFactory::OBJECT_TYPE_KEY => KeywordFilterValidator::class,
            ],
            KeywordRestFactory::KEYWORD_FILTER_HYDRATOR  => [
                KeywordRestFactory::OBJECT_TYPE_KEY => FilterHydrator::class,
            ],
            KeywordRestFactory::KEYWORD_HYDRATOR         => [
                KeywordRestFactory::OBJECT_TYPE_KEY => Hydrator::class,
            ],
            KeywordRestFactory::KEYWORD_PROTOTYPE        => [
                KeywordRestFactory::OBJECT_TYPE_KEY => Keyword::class,
            ],
        ],
    ],
];
