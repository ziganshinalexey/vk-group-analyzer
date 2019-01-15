# userstory / yii2-errors

Пакет для организации логики работы с ошибками.
Позволяет добавить к любому классу функционал для работы с ошибками.

### Основные понятия

 - **Ошибка** - объект, храняший в себе данные о ошибке.
 - **Коллекция ошибок** - объект, представляющий из себя список ошибок.
 - **Текущая коллекция ошибок** - коллекция ошибок текущего объекта.

### Основной сценарий использования

Для того, чтобы добавить к классу функционал для работы с ошибками,
необходимо использовать трейт:

```php
use Userstory\Yii2Errors\traits\errors\ObjectWithErrorsTrait;
```

При использовании данного трейта в классе становятся доступны следующие методы: 

```php

    /**
     * Метод проверяет есть ли ошибки в коллекции ошибок.
     *
     * @return bool
     */
    public function hasUSErrors(): bool;
    
    
    
    /**
     * Метод добавляет ошибку в текущую коллекцию ошибок.
     *
     * @param string $message Сообщение ошибки.
     * @param string $source  Источник ошибки.
     * @param string $code    Код ошибки.
     *
     * @return static
     */
    public function addUSError(string $message, string $source = 'system', string $code = '');
    
    
    
    /**
     * Метод добавляет ошибки из переданной коллекции ошибок в текущую коллекцию.
     *
     * @param CollectionInterface $errorCollection Коллекция ошибок для добавления.
     *
     * @return static
     */
    public function addUSErrors(CollectionInterface $errorCollection);
    
    
    
    /**
     * Метод возвращает текущую коллекцию ошибок.
     *
     * @return CollectionInterface
     */
    public function getUSErrors(): CollectionInterface;
    
    
    
    /**
     * Метод очищает текущую коллекцию ошибок.
     *
     * @return static
     */
    public function clearUSErrors();
    
    
    
    /**
     * Метод добавляет ошибки в текущую коллекцию ошибок из списка ошибок,
     * переданном в формате, с которым работает модель Yii2.
     *
     * @param array $errorDataList Данные списка ошибок.
     *
     * @return static
     */
    public function addYiiErrors(array $errorDataList);
    
    
    
    /**
     * Метод возвращает текущую коллекцию ошибок в формате,
     * с которым работает модель Yii2.
     *
     * @return array
     */
    public function getYiiErrors(): array;
    
```

Все перечисленные методы описывает интерфейс:
```php
use Userstory\Yii2Errors\interfaces\errors\ObjectWithErrorsInterface;
```
Данный интерфейс следует использовать для описания объектов,
содержащих функционад для работы с ошибками.

### Пример кода

```php

use Userstory\Yii2Errors\interfaces\errors\ObjectWithErrorsInterface;
use Userstory\Yii2Errors\traits\errors\ObjectWithErrorsTrait;

class SomeClass implements ObjectWithErrorsInterface
{
    use ObjectWithErrorsTrait;
    
    ...

    /**
     * Метод выводит текущую коллекцию ошибок. 
     */
    protected function printErrorCollection(): void
    {
        $result = [];
        foreach ($this->getUSErrors() as $error) {
            $result[] = [
                'title'  => $error->getTitle(),
                'source' => $error->getSource(),
                'code'   => $error->getCode(),
            ];
        }
        print_r($result);
    }
    
    pubclic function someFunction(): void
    {
        $this->addUSError('Error message 1', 'SomeClass::someFunction', 'E0001');
        $this->printErrorCollection();
        // Добавляем ошибки в коллекцию ошибок.
        //        Array
        //        (
        //                    [0] => Array
        //                    (
        //                        [title] => Error message 1
        //                        [source] => SomeClass::someFunction
        //                        [code] => E0001
        //                    )
        //        
        //        )

        $errorsCollection = $this->getUSErrors();
        $this->addUSErrors($errorsCollection);
        $this->printErrorCollection();
        // Получаем текущую коллекцию ошибок и
        // тут же добавляем ее к уже существующим ошибкам.
        //        Array
        //        (
        //                    [0] => Array
        //                    (
        //                        [title] => Error message 1
        //                        [source] => SomeClass::someFunction
        //                        [code] => E0001
        //                    )
        //
        //                    [1] => Array
        //                    (
        //                        [title] => Error message 1
        //                        [source] => SomeClass::someFunction
        //                        [code] => E0001
        //                    )
        //        
        //        )
        
        $errorsCollectionData = $this->getYiiErrors();
        $this->addYiiErrors($errorsCollectionData);
        $this->printErrorCollection();
        // Получаем текущую коллекцию ошибок в формате Yii и
        // тут же добавляем ее к уже существующим ошибкам.
        //        Array
        //        (
        //                    [0] => Array
        //                    (
        //                        [title] => Error message 1
        //                        [source] => SomeClass::someFunction
        //                        [code] => E0001
        //                    )
        //
        //                    [1] => Array
        //                    (
        //                        [title] => Error message 1
        //                        [source] => SomeClass::someFunction
        //                        [code] => E0001
        //                    )
        //        
        //                    [2] => Array
        //                    (
        //                        [title] => Error message 1
        //                        [source] => SomeClass::someFunction
        //                        [code] => E0001
        //                    )
        //
        //                    [3] => Array
        //                    (
        //                        [title] => Error message 1
        //                        [source] => SomeClass::someFunction
        //                        [code] => E0001
        //                    )        
        //
        //        )
        
        $this->clearUSErrors();
        $this->printErrorCollection();
        // Очищаем коллекцию ошибок.
        //        Array
        //        (
        //
        //        )
    }
    
    ...
    
}

```

