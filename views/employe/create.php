<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Employe */

$this->title = 'Ajouter un employé';
$this->params['breadcrumbs'][] = ['label' => 'Employés', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employe-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
