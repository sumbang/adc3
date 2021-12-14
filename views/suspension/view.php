<?php

use app\models\Habilitation;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Roles;
use app\models\Menus;

/* @var $this yii\web\View */
/* @var $model app\models\Suspension */

$this->title = 'Détails de la suspension';
$this->params['breadcrumbs'][] = ['label' => 'Suspensions de contrats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M10";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="suspension-view">

    <p>
        <?php if ($habilation->AUPDATE == 1) echo Html::a('Modifier', ['update', 'id' => $model->ID_SUSPENSION], ['class' => 'btn btn-primary']) ?>
        <?php if ($habilation->ADELETE == 1) echo Html::a('Supprimer', ['delete', 'id' => $model->ID_SUSPENSION], [
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
            'ID_SUSPENSION',
            'MATICULE',
            'ANNEEEXIGIBLE',
            'DATEDEBUT',
            'DATEFIN',
            'STATUT'=>[

                'label' => 'Statut traitement',
                'value'=>$model->getStatut($model->STATUT),
            ],
            'STATUTLEVEE'=>[

                'label' => 'Statut',
                'value'=>$model->getStatut2($model->STATUTLEVE),
            ],
            //'DATEEMIS',
            //'DATEVAL',
            //'DATEANN',
            'COMMENTAIRE:ntext',
            'DOCUMENT'=>[

                'label' => 'Attestion suspension congés',
                'format'=>'raw',
                'value'=>Html::a('Télécharger', $model->showFile()),
            ],
            'DOCUMENT2'=>[

                'label' => 'Attestion levée suspension congés',
                'format'=>'raw',
                'value'=>Html::a('Télécharger', $model->showFile2()),
            ],
        ],
    ]) ?>

</div>
