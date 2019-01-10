<?php

namespace Userstory\ComponentApiServer\models\rest;

use JsonSerializable;
use yii\base\Component;
use yii\data\Pagination;
use Userstory\ComponentHelpers\helpers\ArrayHelper;

/**
 * Class Response.
 * Класс ответа API действия.
 *
 * @SWG\Definition(
 *     type="object",
 *     definition="Response",
 * )
 *
 * @package Userstory\ComponentApiServer\models
 */
class Response extends Component implements JsonSerializable
{
    /**
     * Свойство содержит возникшие ошибки при выполнении действия.
     *
     * @var Error[]
     *
     * @SWG\Property()
     */
    protected $errors = [];

    /**
     * Свойство содержит уведомления, необходимые для отправки пользователю.
     *
     * @var Notify[]
     *
     * @SWG\Property()
     */
    protected $notices = [];

    /**
     * Свойство содержит запрошенные данные, которые будут включены в ответ.
     *
     * @var array
     *
     * @SWG\Property(@SWG\Items())
     */
    protected $data = [];

    /**
     * Свойство содержит объект пагинации данных в случаях, когда запрашивается список.
     *
     * @var Pagination|null
     */
    protected $page;

    /**
     * Формат, в который будет заворачиваться ответ.
     * На данный момент поддерживается два формата ответа:
     * Response::FORMAT_JSON
     * Response::FORMAT_XML.
     *
     * @var string|null
     */
    protected $format;

    /**
     * Метод возвращает формат, в который будет заворачиваться ответ.
     *
     * @return null|string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Метод устанавливает формат, в который будет завернут ответ.
     *
     * @param null|string $format Новое значение формата.
     *
     * @return static
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    /**
     * Метод добавляет новую ошибку в ответ.
     *
     * @param integer $code   Код ошибки.
     * @param string  $title  Краткое описание ошибки.
     * @param string  $detail Детальное описание ошибки.
     * @param array   $data   Дополнительные данные.
     *
     * @return Response
     */
    public function addError($code, $title, $detail = '', array $data = [])
    {
        $this->errors[] = new Error([
            'code'   => $code,
            'title'  => $title,
            'detail' => $detail,
            'data'   => $data,
        ]);

        return $this;
    }

    /**
     * Метод проверяет заданы ли уже ошибки.
     *
     * @return boolean
     */
    public function hasErrors()
    {
        return ! empty($this->errors);
    }

    /**
     * Метод добавляет новое уведомление в ответ.
     *
     * @param integer $code   Код уведомления.
     * @param string  $title  Краткое описание уведомления.
     * @param string  $detail Детальное описание уведомления.
     * @param array   $data   Дополнительные данные.
     *
     * @return Response
     */
    public function addNotify($code, $title, $detail = '', array $data = [])
    {
        $this->notices[] = new Notify([
            'code'   => $code,
            'title'  => $title,
            'detail' => $detail,
            'data'   => $data,
        ]);

        return $this;
    }

    /**
     * Метод добавляет данные ответа.
     *
     * @param mixed  $data Данные для установки.
     * @param string $key  Ключ для данных ('users', 'posts').
     *
     * @return Response
     */
    public function addData($data, $key)
    {
        $this->data[$key] = $data;
        return $this;
    }

    /**
     * Метод заполняет данные ответа.
     *
     * @param mixed $data Данные для установки.
     *
     * @return static
     */
    public function setData($data)
    {
        $this->data = ArrayHelper::merge($this->data, is_array($data) ? $data : (array)$data);
        return $this;
    }

    /**
     * Метод проверяет заполнены ли данные ответа.
     *
     * @return boolean
     */
    public function hasData()
    {
        return ! empty($this->data);
    }

    /**
     * Метод создает объект пагинации и заполняет его переданными данными.
     * Возвращает созданный объект.
     *
     * @param integer $pageSize   Количество записей на странице.
     * @param integer $totalCount Всего записей.
     * @param integer $page       Номер страницы.
     *
     * @return Pagination
     */
    public function createPage($pageSize, $totalCount, $page)
    {
        $this->page = new Pagination([
            'totalCount' => $totalCount,
            'pageSize'   => $pageSize,
            'page'       => $page,
        ]);

        return $this->page;
    }

    /**
     * Метод устанавливает объект пагинации.
     *
     * @param Pagination $pagination Объект пагинации.
     *
     * @return Pagination
     */
    public function setPage(Pagination $pagination)
    {
        $this->page = $pagination;
        return $this->page;
    }

    /**
     * Метод возвращает данные для json.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $response = [
            'errors'  => ArrayHelper::toArray($this->errors, [
                Error::class => [
                    'code',
                    'title',
                    'detail',
                    'data',
                ],
            ]),
            'notices' => ArrayHelper::toArray($this->notices, [
                Notify::class => [
                    'code',
                    'title',
                    'detail',
                    'data',
                ],
            ]),
            'data'    => $this->data,
        ];

        if ($this->page) {
            $response['page'] = ArrayHelper::toArray($this->page, [
                Pagination::class => [
                    'size'          => 'pageSize',
                    'totalElements' => 'totalCount',
                    'totalPages'    => 'pageCount',
                    'number'        => 'page',
                ],
            ]);
        }

        return $response;
    }
}
