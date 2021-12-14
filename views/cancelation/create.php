<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cancelation */

$this->title = 'Créer une Suspension';
$this->params['breadcrumbs'][] = ['label' => 'Suspensions de jouissance', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cancelation-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
