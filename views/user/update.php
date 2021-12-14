<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Modifier le compte';
$this->params['breadcrumbs'][] = ['label' => 'Gestion des comptes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IDUSER, 'url' => ['view', 'id' => $model->IDUSER]];
$this->params['breadcrumbs'][] = 'Modifier';
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
