Организация логирования.
========================

Компонент определяет базовую конфигурацию логирования для проекта.

Расширение
----------

Добавлен новый объект для настроек targets (Userstory\ComponentLog\loggers\FileTarget)

* появилась возможность управлять шаблоном сообщения записанного в лог.
* на каждый день создается свой файл лога в формате Y-m-d.log
* возможность указать папку куда складывать логи
* управления жизню файла лога (количество дней)
* удаление файла лога по консольной комманде (можно запускать с крона)
* разбиение на файлы по принципу <директория с логами>/<категория>/<год>/<месяц>/<день>.log

Пример конфигурации
-------------------

`'components' => [
         'log'          => [
            ...
             'targets'    => [
                ...
                 [
                     'class'        => \Userstory\ComponentLog\loggers\FileTarget::class,
                     'levels'       => ['info'],
                     'categories'   => ['Имя категории'],
                     'logPath'      => 'путь/где/создаются/файлы/логирования',
                     'templatePath' => 'путь/до/шаблона/вида/ообщения/в/файле/логирования',
                     'daysLife'     => 180,
                 ],
             ],
         ],
     ],`
     
templatePath - файл-шаблон вида сообщения
-----------------------------------------

php-файл принимает для вывода данные:

* string $text - текст сообщения 
* string $level - уровень логирования
* string $category - категория логирования
* DateTime $date - дата

daysLife - время жизни файла-логирования в днях
-----------------------------------------------

параметр жизни файла0лога в днях приминяется в консольной комманде для удаления.
при daysLife = 0 логи не удаляются.

Консольная комманда
-------------------

`php yiic logs/remove`

запускает задачу для удаления лог-файлов 
для всех видов логов работающих по цели Userstory\ComponentLog\loggers\FileTarget