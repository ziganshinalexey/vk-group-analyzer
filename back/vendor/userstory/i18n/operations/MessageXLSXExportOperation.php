<?php

namespace Userstory\I18n\operations;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Writer\Exception as SpreadSheetException;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\ComponentHelpers\helpers\exceptions\FileHelperException;
use Userstory\ComponentHelpers\helpers\FileHelper;
use Userstory\I18n\interfaces\LanguageInterface;
use Userstory\I18n\interfaces\MessageExportInterface;
use yii;
use yii\base\ExitException;
use yii\base\InvalidConfigException;

/**
 * Класс MessageXLSXExportOperation реализует отправку файла клиенту.
 *
 * @package Userstory\I18n\operations
 */
class MessageXLSXExportOperation extends AbstractMessageExportOperation implements MessageExportInterface
{
    /**
     * Настройки ширины колонок.
     *
     * @var array
     */
    protected $columnWidthSettings = [
        5,
        15,
        25,
        25,
        50,
        50,
    ];

    /**
     * Метод отправки файла клиенту.
     *
     * @param LanguageInterface $language Сущность языка.
     *
     * @return void
     *
     * @throws Exception Генерирует при неверной конфигурации.
     * @throws ExitException Генерирует при неверной конфигурации.
     * @throws FileHelperException Генерирует при неправильной работе с файлами.
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function send(LanguageInterface $language)
    {
        $filePath = $this->getFilePath($language);

        $fileName = 'constants_' . $language->getName() . '.xlsx';
        Yii::$app->response->getHeaders()->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        Yii::$app->response->getHeaders()->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        Yii::$app->response->getHeaders()->set('Cache-Control', 'no-cache');
        Yii::$app->response->getHeaders()->set('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
        Yii::$app->response->getHeaders()->set('Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT');

        Yii::$app->response->sendFile($filePath);
        FileHelper::remove($filePath);
        Yii::$app->end();
    }

    /**
     * Получения пути до файла с переводами.
     *
     * @param LanguageInterface $language Сущность языка.
     *
     * @return string
     *
     * @throws Exception Генерирует при неверной конфигурации.
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    public function getFilePath(LanguageInterface $language)
    {
        $spreadsheet = $this->buildXLSX($language);
        return $this->save($spreadsheet);
    }

    /**
     * Метод возвращает файл клиенту.
     *
     * @param LanguageInterface $language Сущность языка.
     *
     * @return Spreadsheet
     *
     * @throws Exception Генерирует при неверной конфигурации.
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    protected function buildXLSX(LanguageInterface $language)
    {
        $content = ArrayHelper::merge([$this->getColumnLabels()], $this->getContent($language->getId()));

        $spreadsheet = $this->createSpreadsheet();
        $spreadsheet->getActiveSheet()->fromArray($content);

        $countOfRow = $spreadsheet->getActiveSheet()->getHighestRow();

        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        $spreadsheet->getActiveSheet()->getStyle('C2:C' . $countOfRow)->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);
        $spreadsheet->getActiveSheet()->getStyle('F2:F' . $countOfRow)->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);

        $spreadsheet->getActiveSheet()->getStyle('A1:F' . $countOfRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);

        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(- 1);
        $spreadsheet->getActiveSheet()->getStyle('B1:F' . $countOfRow)->getAlignment()->setWrapText(true);

        foreach ($this->columnWidthSettings as $key => $columnWidth) {
            $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($key + 1)->setWidth($columnWidth);
        }

        $spreadsheet->getActiveSheet()
                    ->getStyle('A1:B' . count($content))
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('EEEEEE');

        $spreadsheet->getActiveSheet()
                    ->getStyle('D1:E' . count($content))
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('EEEEEE');

        $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('EEEEEE');
        $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('EEEEEE');

        return $spreadsheet;
    }

    /**
     * Метод создает объект страницы.
     *
     * @return Spreadsheet
     */
    protected function createSpreadsheet()
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()
                    ->setCreator('UserStory')
                    ->setLastModifiedBy('UserStory')
                    ->setTitle('Office 2007 XLSX Test Document')
                    ->setSubject('Office 2007 XLSX Test Document')
                    ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
                    ->setKeywords('office 2007 openxml php')
                    ->setCategory('Test result file');

        return $spreadsheet;
    }

    /**
     * Метод сохраняет файл во временной директории.
     *
     * @param Spreadsheet $spreadsheet объект ресурса.
     *
     * @return string
     *
     * @throws SpreadSheetException Генерирует в случае ошибочной работы таблиц.
     */
    protected function save(Spreadsheet $spreadsheet)
    {
        $writer      = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $tmpFileName = FileHelper::createTempFile('KIPS-xlsx-');
        $writer->save($tmpFileName);
        return $tmpFileName;
    }
}
