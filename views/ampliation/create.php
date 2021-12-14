<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ampliation */

$this->title = 'Ajouter une ampliation';
$this->params['breadcrumbs'][] = ['label' => 'Ampliations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ampliation-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
