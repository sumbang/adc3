<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Documents */

$this->title = 'Ajouter un document';
$this->params['breadcrumbs'][] = ['label' => 'Gestion documentaire', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documents-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
