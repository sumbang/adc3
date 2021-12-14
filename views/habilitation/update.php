<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Habilitation */

$this->title = 'Modifier de l\'habilitation';
$this->params['breadcrumbs'][] = ['label' => 'Habilitations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Modifier';
?>
<div class="habilitation-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
