<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Ajouter un compte';
$this->params['breadcrumbs'][] = ['label' => 'Gestion des comptes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
