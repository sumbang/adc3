<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Departements */

$this->title = 'Modifier le département';
$this->params['breadcrumbs'][] = ['label' => 'Départements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CODEDPT, 'url' => ['view', 'id' => $model->CODEDPT]];
$this->params['breadcrumbs'][] = 'Modifier';
?>
<div class="departements-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
