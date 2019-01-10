<?php

namespace Userstory\ComponentBase\formatters;

use DOMElement;
use yii\web\XmlResponseFormatter as YiiXmlResponseFormatter;

/**
 * Класс UploadFileComponent управления загрузки/сохранения файлов.
 *
 * @package Userstory\ComponentBase\components
 */
class XmlResponseFormatter extends YiiXmlResponseFormatter
{
    /**
     * Метод расширяет функционал базового класса, позволяя добавлять атрибуты в XML-response.
     *
     * @param mixed $element Объект DOMElement, через который формируется ответ.
     * @param mixed $data    Данные, по которым формируется ответ.
     *
     * @return void
     */
    protected function buildXml($element, $data)
    {
        if (is_array($data) && isset($data['@attributes'])) {
            if (is_array($data['@attributes'])) {
                /* @var DOMElement $element */
                foreach ($data['@attributes'] as $key => $item) {
                    if (is_string($key) && is_string($item)) {
                        $element->setAttribute($key, $item);
                    }
                }
            }
            unset($data['@attributes']);
        }
        parent::buildXml($element, $data);
    }
}
