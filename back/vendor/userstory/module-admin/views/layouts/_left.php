<?php

use Userstory\ModuleAdmin\widgets\Menu;

/* @var array $menuItems */
/* @var array $bottomMenuItems */

?>

<aside class="main-sidebar">
    <section class="sidebar">
        <table class="table-nav">
            <tr>
                <td valign="top">
                    <?php
                    echo Menu::widget([
                        'options' => [
                            'class'       => 'sidebar-menu tree',
                            'data-widget' => 'tree',
                        ],
                        'items'   => $menuItems,
                    ]);
                    ?>
                </td>
            </tr>
            <tr>
                <td valign="bottom" class="table-col">
                    <?php
                    echo Menu::widget([
                        'options' => [
                            'class'       => 'sidebar-menu tree',
                            'data-widget' => 'tree',
                        ],
                        'items'   => $bottomMenuItems,
                    ]);
                    ?>
                </td>
            </tr>
        </table>
    </section>
</aside>
