<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Departements */

$this->title = 'Ajouter un département';
$this->params['breadcrumbs'][] = ['label' => 'Départements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="departements-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
