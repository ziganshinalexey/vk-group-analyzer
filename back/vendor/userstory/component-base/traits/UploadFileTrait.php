<?php

namespace Userstory\ComponentBase\traits;

use Exception as GlobalException;
use Userstory\ComponentHelpers\helpers\FileHelper;
use yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\helpers\BaseFileHelper;
use yii\helpers\StringHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Трейт для загрузки файлов. В целевом классе следует объявить свойство entityFiles[], где перечислить поля для файлов.
 *
 * @property string $uploadPath
 * @property string $uploadDir
 */
trait UploadFileTrait
{
    /**
     * свойство для пути для загрузки файлов сущности
     * определяется автоматически.
     *
     * @var string|null
     */
    public $uploadPath;

    /**
     * свойство для хранения директории загрузки файлов.
     *
     * @var string
     */
    protected $uploadDir = '@app/upload/public/';

    /**
     * Путь к директории файлов относительно www.
     *
     * @var string
     */
    protected $relativeDir = '/../protected/upload/public/';

    /**
     * Метод возвращает идентификатор первичного ключа модели.
     *
     * @return string
     */
    protected function getModelKey()
    {
        return static::primaryKey()[0];
    }

    /**
     * Метод для загрузки файлов и сохранения данных в бд
     * Только для сохранения файлов, определенных в сущности.
     *
     * @param boolean $insert            True при вставке, при апдейте false.
     * @param mixed   $changedAttributes старые значения атрибутов.
     *
     * @return void
     *
     * @throws ErrorException ошибка при сохранении файла.
     * @throws InvalidParamException алиас не объявлен.
     * @throws Exception ошибка при создании директории.
     */
    public function afterSave($insert, $changedAttributes)
    {
        $modelKey = $this->getModelKey();
        parent::afterSave($insert, $changedAttributes);
        if (! is_array($this->entityFiles)) {
            return;
        }
        foreach ($this->entityFiles as $file) {
            if (false !== ( $uniqueName = $this->saveFile($this->{$file}) )) {
                static::updateAll([$file => $uniqueName . '.' . $this->{$file}->extension], [$modelKey => $this->{$modelKey}]);
            } elseif (array_key_exists($file, $changedAttributes) && null !== $changedAttributes[$file]) {
                static::updateAll([$file => $changedAttributes[$file]], [$modelKey => $this->{$modelKey}]);
            }
        }
    }

    /**
     * переопределение метода load для загрузки файлов.
     *
     * @param array|null  $data     данные с формы.
     * @param string|null $formName имя формы.
     *
     * @return boolean
     */
    public function load($data, $formName = null)
    {
        return parent::load($data, $formName) && $this->loadFiles($data);
    }

    /**
     * Загрузка файлов сущности и прикреплений.
     *
     * @param array|null $data данные с формы.
     *
     * @return boolean
     *
     * @throws InvalidParamException алиас не найден.
     */
    protected function loadFiles($data)
    {
        if (is_array($this->entityFiles)) {
            foreach ($this->entityFiles as $file) {
                $this->{$file} = Yii::$app->uploadFile->getInstance($this, $file);
            }
        }
        if (isset($this->attachments)) {
            $this->loadAttachments($data);
        }
        return true;
    }

    /**
     * метод для Загрузки прикреплений.
     *
     * @param array|null $data данные с формы.
     *
     * @return void
     *
     * @throws InvalidParamException алиас не найден.
     */
    protected function loadAttachments($data)
    {
        $attachModel = $this->getNewAttachmentObject();
        $formName    = $attachModel->formName();
        if (! isset ($data[$formName]) || ! is_array($data[$formName])) {
            return;
        }
        foreach ($data[$formName] as $fInput => $val) {
            if (is_array($val)) {
                $attachModel->{$fInput} = Yii::$app->uploadFile->getInstances($attachModel, $fInput);
            } else {
                $attachModel->{$fInput} = Yii::$app->uploadFile->getInstance($attachModel, $fInput);
            }
        }
        $this->populateRelation('attachments', $attachModel);
    }

    /**
     * Переопределенная функция проверки валидации сущности и прикрепленных файлов.
     *
     * @param string|array $attributeNames проверяемые атрибуты.
     * @param boolean      $clearErrors    очищать ошибки.
     *
     * @return boolean
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        if (! isset($this->attachments)) {
            return parent::validate($attributeNames, $clearErrors);
        }
        return parent::validate($attributeNames, $clearErrors) && $this->attachments->validate($attributeNames, $clearErrors);
    }

    /**
     * сохранение сущности вместе с аттачами.
     *
     * @param boolean    $runValidation  валидировать/не валидировать.
     * @param null|array $attributeNames название атрибутов.
     *
     * @return boolean
     * @throws GlobalException ошибка при сохранении.
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $transaction = static::getDb()->beginTransaction();
        try {
            $result = parent::save($runValidation, $attributeNames) && $this->saveAttachments();
            if (false === $result) {
                $transaction->rollBack();
                $this->deleteAttachment();
            } else {
                $transaction->commit();
            }
            return $result;
        } catch (GlobalException $e) {
            $transaction->rollBack();
            $this->deleteAttachment();
            throw $e;
        }
    }

    /**
     * Сохранение аттачей, если есть связь.
     *
     * @return boolean
     *
     * @throws ErrorException ошибка при сохранении файла.
     * @throws InvalidParamException алиас не найден.
     * @throws Exception ошибка при создании директории.
     */
    protected function saveAttachments()
    {
        if (! isset($this->attachments)) {
            return true;
        }
        $attachModel = $this->getNewAttachmentObject();
        foreach ($attachModel->attachmentFiles as $file) {
            if (is_array($this->attachments->{$file})) {
                foreach ($this->attachments->{$file} as $uploadedFile) {
                    $this->saveAttachment($uploadedFile);
                }
            } else {
                $this->saveAttachment($this->attachments->{$file});
            }
        }
        return true;
    }

    /**
     * Метод для загрузки файлов и сохранения данных в бд
     * Для прикреплений.
     *
     * @param UploadedFile|null $uploadedFile объект загруженного файла.
     *
     * @return boolean
     *
     * @throws ErrorException ошибка при сохранении файла.
     * @throws InvalidParamException связь не найдена.
     * @throws Exception ошибка при создании директории.
     */
    protected function saveAttachment($uploadedFile)
    {
        $modelKey = $this->getModelKey();

        if (false !== ( $uniqueName = $this->saveFile($uploadedFile) )) {
            $attachment           = $this->getNewAttachmentObject();
            $attachment->entityId = $this->{$modelKey};
            $attachment->fileName = $uniqueName . '.' . $uploadedFile->extension;
            if (! $attachment->save()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Возвращает объект прикреплений.
     *
     * @return ActiveRecord
     *
     * @throws InvalidParamException связь не найдена.
     */
    protected function getNewAttachmentObject()
    {
        $relationQuery = $this->getRelation('attachments');
        return new $relationQuery->modelClass();
    }

    /**
     * Метод для удаления файлов сущности вместе с директорией.
     *
     * @return boolean
     *
     * @throws ErrorException ошибка при удалении директории.
     */
    public function beforeDelete()
    {
        if (! isset($this->entityFiles)) {
            return parent::beforeDelete();
        }

        $modelKey = $this->getModelKey();

        return $this->deleteDir($this->{$modelKey}) && parent::beforeDelete();
    }

    /**
     * метод загружает файл на сервер и возвращает название файла.
     *
     * @param UploadedFile|null $uploadedFile файл, который необходимо загрузить.
     *
     * @return boolean|string
     *
     * @throws ErrorException ошибка, если файл не сохранился.
     * @throws InvalidParamException алиас не объявлен.
     * @throws Exception ошибка при создании директории.
     */
    protected function saveFile($uploadedFile)
    {
        if (null === $uploadedFile || ! is_object($uploadedFile) || ! $uploadedFile->tempName) {
            return false;
        }

        $modelKey         = $this->getModelKey();
        $this->uploadPath = $this->getUploadPath($this->{$modelKey}, true);
        $uniqueName       = $this->getUniqueName($uploadedFile->extension);
        if (! $uploadedFile->saveAs($this->uploadPath . $uniqueName . '.' . $uploadedFile->extension)) {
            throw new ErrorException('Counldn\'t save file');
        }
        return $uniqueName;
    }

    /**
     * метод создает вложенные директории, заданные в path.
     *
     * @param string $path путь к директории.
     *
     * @return void
     * @throws Exception ошибка при создании директории.
     */
    protected function createDirectory($path)
    {
        if (! FileHelper::isDirectory($path)) {
            BaseFileHelper::createDirectory($path);
        }
    }

    /**
     * метод для чтения файлов сущности.
     *
     * @param string $path путь к файлу.
     *
     * @throws NotFoundHttpException возможное ислкючение.
     * @return void
     */
    protected function showFile($path)
    {
        if (FileHelper::fileExists($path) && ! FileHelper::isDirectory($path)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            header('Content-Type: ' . finfo_file($finfo, $path));
            readfile($path);
            finfo_close($finfo);
            exit;
        }
        throw new NotFoundHttpException();
    }

    /**
     * Удаляет файл из директории.
     *
     * @param string $path путь к файлу.
     *
     * @return boolean
     * @throws Exception ошибка при удалении файла.
     */
    protected function deleteFile($path)
    {
        if (FileHelper::isWritable($path) && ! FileHelper::isDirectory($path) && FileHelper::remove($path)) {
            return true;
        }
        throw new Exception('Couldn\'t delete file or file doesn\'t exist ');
    }

    /**
     * Показывает файл сущности.
     *
     * @param string $field название поля файла.
     *
     * @return void
     *
     * @throws NotFoundHttpException файл не найден.
     * @throws InvalidParamException алиас не найден.
     * @throws Exception             ошибка при создании директории.
     */
    public function getEntityFile($field)
    {
        $modelKey = $this->getModelKey();
        $path     = $this->getUploadPath($this->{$modelKey});
        $filePath = $path . $this->{$field};
        $this->showFile($filePath);
    }

    /**
     * Показывает прикрепление к сущности.
     *
     * @return void
     *
     * @throws NotFoundHttpException файл не найден.
     * @throws InvalidParamException алиас не найден.
     * @throws Exception             ошибка при создании директории.
     */
    public function getAttachment()
    {
        $path     = $this->getUploadPath($this->entityId);
        $filePath = $path . $this->fileName;
        $this->showFile($filePath);
    }

    /**
     * Метод для удаления файла сущности.
     *
     * @param string $field название поля файла.
     *
     * @return void
     *
     * @throws InvalidParamException алиас не найден.
     * @throws Exception ошибка при удалении файла.
     */
    public function deleteEntityFile($field)
    {
        $modelKey = $this->getModelKey();
        $path     = $this->getUploadPath($this->{$modelKey});
        $filePath = $path . $this->{$field};

        if ($this->deleteFile(Yii::getAlias($filePath))) {
            static::updateAll([$field => null], ['id' => $this->{$modelKey}]);
        }
    }

    /**
     * Метод для удаления прикрепления к сущности.
     *
     * @return void
     *
     * @throws \Exception Если не получилось удаление.
     * @throws Exception ошибка при создании директории.
     * @throws InvalidParamException алиас не найден.
     */
    public function deleteAttachment()
    {
        if (! $this->hasProperty('entityId')) {
            return;
        }

        $path     = $this->getUploadPath($this->entityId);
        $filePath = $path . $this->fileName;
        if ($this->deleteFile(Yii::getAlias($filePath))) {
            $this->delete();
        }
    }

    /**
     * Метод для удаления директории сущности.
     *
     * @param integer $entityId идентификатор сущности.
     *
     * @return boolean
     *
     * @throws ErrorException ошибка при удалении директории.
     */
    protected function deleteDir($entityId)
    {
        $path = $this->getUploadPath($entityId);
        if (! FileHelper::isDirectory($path) || ! FileHelper::fileExists($path)) {
            return true;
        }
        if (! FileHelper::isWritable($path)) {
            return false;
        }
        BaseFileHelper::removeDirectory($path);
        return true;
    }

    /**
     * метод возвращает путь к директории файла.
     *
     * @param integer $id     идентификатор новости.
     * @param boolean $create метка для создания директории если не существует.
     *
     * @return string
     *
     * @throws InvalidParamException алиас не найден.
     * @throws Exception ошибка при создании директории.
     */
    protected function getUploadPath($id, $create = false)
    {
        if (null === $this->uploadPath) {
            $className = ( isset($this->mainClassName) && null !== $this->mainClassName ) ? $this->mainClassName : get_class($this);
            $group     = str_pad(floor($id / 1000), 3, '0', STR_PAD_LEFT);
            $path      = $this->uploadDir . StringHelper::basename($className) . '/' . $group . '/' . $id . '/';
            $path      = Yii::getAlias($path);
            if (! FileHelper::isDirectory($path) && $create) {
                $this->createDirectory($path);
            }
            return $path;
        }
        return $this->uploadPath;
    }

    /**
     * генерация уникального имени для файла.
     *
     * @param string $extension расширение файла.
     *
     * @return string
     */
    protected function getUniqueName($extension)
    {
        do {
            $hashName = substr(md5(uniqid(mt_rand(), true)), 0, 8);
        } while (FileHelper::fileExists($this->uploadPath . $hashName . '.' . $extension));
        return $hashName;
    }

    /**
     * Получение адреса минимизированного файла.
     *
     * @param string  $fileName Название файла из базы данных.
     * @param integer $width    ширина миниатюры.
     * @param integer $height   высота миниатюры.
     * @param boolean $crop     Обрезать миниатюру или нет.
     *
     * @return string
     */
    public function getUrl($fileName, $width = 500, $height = 300, $crop = false)
    {
        return str_replace('\\', '/', Yii::$app->thumb->getThumbUrl($this->getRelativePath($this->id) . $fileName, $width, $height, $crop));
    }

    /**
     * Получение пути к директории файлов сущности, относительно www.
     *
     * @param integer $id Идентификатор сущности.
     *
     * @return string
     */
    protected function getRelativePath($id)
    {
        $className = ( isset($this->mainClassName) && null !== $this->mainClassName ) ? $this->mainClassName : get_class($this);
        $group     = str_pad(floor($id / 1000), 3, '0', STR_PAD_LEFT);
        $path      = $this->relativeDir . StringHelper::basename($className) . '/' . $group . '/' . $id . '/';
        return $path;
    }
}
