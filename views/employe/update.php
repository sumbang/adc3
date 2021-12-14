<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Employe */

$this->title = 'Modifier l\'employé';
$this->params['breadcrumbs'][] = ['label' => 'Employés', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MATRICULE, 'url' => ['view', 'id' => $model->MATRICULE]];
$this->params['breadcrumbs'][] = 'Modifier';
?>
<div class="employe-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
