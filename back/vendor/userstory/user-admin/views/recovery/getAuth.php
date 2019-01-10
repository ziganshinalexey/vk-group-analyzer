<?php

use Userstory\ModuleAdmin\components\View;

/* @var View $this */

$this->title                   = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;

$template = '<div class="text-field form__field-wrapper">{input}</div>
<div class="form__error form__error_tooltip us-tooltip us-tooltip_error box box_shadow">{error}</div>';

echo $this->render('_token');
