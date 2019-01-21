<?php

declare(strict_types = 1);

namespace app\api\v1\forms\vk;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\base\Model;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\traits\keyword\KeywordComponentTrait;
use Ziganshinalexey\PersonType\traits\personType\PersonTypeComponentTrait;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;
use Ziganshinalexey\Yii2VkApi\traits\group\GroupComponentTrait;
use Ziganshinalexey\Yii2VkApi\traits\user\UserComponentTrait;
use function preg_match;
use function strripos;
use function substr;

/**
 * Форма данных для REST-метода выборки сущности "Ключевое фраза".
 */
class AnalyzeForm extends Model
{
    use UserComponentTrait;
    use GroupComponentTrait;
    use KeywordComponentTrait;
    use PersonTypeComponentTrait;

    /**
     * Свойство содержит урл пользователя в вк.
     *
     * @var string|null
     */
    protected $vkUrl;

    /**
     * Свойство содержит ключ доступа к апи.
     *
     * @var string|null
     */
    protected $accessToken;

    /**
     * Метод возвращает урл пользователя в вк.
     *
     * @return string|null
     */
    public function getVkUrl()
    {
        return $this->vkUrl;
    }

    /**
     * Метод возвращает ключ доступа к апи.
     *
     * @return string|null
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Переопределенный метод возвращает правила валидации формы.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'vkUrl',
                    'accessToken',
                ],
                'required',
            ],
            [
                [
                    'vkUrl',
                    'accessToken',
                ],
                'string',
                'max' => 255,
            ],
            [
                'vkUrl',
                'customVkUrlValidate',
            ],
        ];
    }

    /**
     * Кастомный метод валидации урла пользователя.
     *
     * @param string $attribute Название атрибута.
     *
     * @return void
     */
    public function customVkUrlValidate(string $attribute): void
    {
        if (! preg_match('/^https:\/\/vk.com\/[a-z0-9_]{5,32}$/i', $this->$attribute)) {
            $this->addError($attribute, 'Ссылка неверно указана.');
        }
    }

    /**
     * Осуществлет основное действие формы - просмотр элемента.
     *
     * @return array|null
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     */
    public function run(): ?array
    {
        if (! $this->validate()) {
            return null;
        }

        $userId = $this->parseUserScreenName();
        $result = $this->getUserComponent()->findMany()->setUserScreenName($userId)->setAccessToken($this->getAccessToken())->doOperation();
        if (! $result->isSuccess()) {
            $this->addErrors($result->getYiiErrors());
            return null;
        }

        $userList = $result->getDtoList();
        /* @var UserInterface $user */
        $user = array_shift($userList);

        $result = $this->getGroupComponent()->findMany()->setUserId($user->getId())->setAccessToken($this->getAccessToken())->doOperation();
        if (! $result->isSuccess()) {
            $this->addErrors($result->getYiiErrors());
            return null;
        }
        $groupList = $result->getDtoList();

        return [
            'user'          => $user,
            'analyzeResult' => $this->analyze($groupList),
        ];
    }

    /**
     * Метод парсит имя пользователя.
     *
     * @return null|string
     */
    protected function parseUserScreenName(): ?string
    {
        return (string)substr((string)$this->getVkUrl(), strripos((string)$this->getVkUrl(), '/') + 1);
    }

    /**
     * Метод возвращает список совпадений.
     *
     * @param GroupInterface[] $groupList
     *
     * @return array
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     */
    protected function analyze(array $groupList): array
    {
        $result         = [];
        $personTypeList = $this->getPersonTypeComponent()->findMany()->doOperation();
        foreach ($personTypeList as $personType) {
            $result[$personType->getId()] = [
                'count' => 0,
                'ratio' => 0,
                'name'  => $personType->getName(),
            ];
        }
        $keywordList = $this->getKeywordComponent()->findMany()->doOperation();
        foreach ($groupList as $group) {
            $text = $this->prepareText($group);
            foreach ($keywordList as $keyword) {
                if ($count = mb_substr_count($text, strtolower($keyword->getText()))) {
                    if ($keyword->getPersonTypeId()) {
                        $result[$keyword->getPersonTypeId()]['count'] += $count;
                        $result[$keyword->getPersonTypeId()]['ratio'] += $count * $keyword->getRatio();
                    }
                    $keyword->setCoincidenceCount($keyword->getCoincidenceCount() + $count);
                }
            }
// $keywordList = ArrayHelper::merge($keywordList, $this->addMissingKeywordList($text));
        }

//        foreach ($keywordList as $keyword) {
//            $resultOperation = $this->getKeywordComponent()->updateOne($keyword)->doOperation();
//            if (! $resultOperation->isSuccess()) {
//                throw new InvalidConfigException('keyword update was failed');
//            }
//        }

        return $result;
    }

    protected function prepareText(GroupInterface $group)
    {
        $text = $group->getName() . ' ' . $group->getDescription();
        $text = preg_replace('/\\n|\\t|[.,\/#!?$%\^&\*;:{}=\-_`~()]|\d/', ' ', $text);
        $text = str_replace([
            '\n',
            '\r',
            '\t',
        ], ' ', $text);
        $text = mb_strtolower(trim(preg_replace('/ {2,}/', ' ', $text)));

        return ($text);
    }

    /**
     * Метод сохраняет невстретивщиеся слова.
     *
     * @param string $text
     *
     * @return KeywordInterface[]
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     */
    protected function addMissingKeywordList(string $text): array
    {
        $text        = trim(preg_replace('/ {2,}/', ' ', $text));
        $keywordList = explode(' ', $text);
        $result      = [];

        $uniqueKeywordList = [];
        foreach ($keywordList as $keyword) {
            if (empty($keyword)) {
                continue;
            }
            if (! isset($uniqueKeywordList[$keyword])) {
                $uniqueKeywordList[$keyword] = 0;
            }
            $uniqueKeywordList[$keyword] ++;
        }

        foreach ($uniqueKeywordList as $keywordText => $coincidenceCount) {
            $keywordDto = $this->getKeywordComponent()->getKeywordPrototype()->copy();
            $keywordDto->setCoincidenceCount((int)$coincidenceCount);
            $keywordDto->setText((string)$keywordText);
            $result[] = $this->getKeywordComponent()->createOne($keywordDto)->doOperation()->getKeyword();
        }

        return $result;
    }
}
