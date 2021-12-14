<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Arret */

$this->title = 'Modifier le reliquat';
$this->params['breadcrumbs'][] = ['label' => 'Reliquat de jouissance', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_SUSPENSION, 'url' => ['view', 'id' => $model->ID_SUSPENSION]];
$this->params['breadcrumbs'][] = 'Modifier';
?>
<div class="arret-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
