<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Roles */

$this->title = 'Modifier le role';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CODE, 'url' => ['view', 'id' => $model->CODE]];
$this->params['breadcrumbs'][] = 'Modifier';
?>
<div class="roles-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
