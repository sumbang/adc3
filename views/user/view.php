<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = "Details du compte";
$this->params['breadcrumbs'][] = ['label' => 'Gestion des comptes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

  <p>
        <?= Html::a('Modifier', ['update', 'id' => $model->IDUSER], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Supprimer', ['delete', 'id' => $model->IDUSER], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IDUSER',
            'EMAIL:email',
            //'PASSWORD',
            'DATECREATION',
            //'TOKEN',
            //'AUTHKEY',
            'NOM',
            'ROLE',
            'INITIAL',
            'NIVEAU',
        ],
    ]) ?>

</div>
