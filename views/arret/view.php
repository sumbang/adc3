<?php

use app\models\Habilitation;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Roles;
use app\models\Menus;

/* @var $this yii\web\View */
/* @var $model app\models\Arret */

$this->title = 'Détail du reliquat';
$this->params['breadcrumbs'][] = ['label' => 'Reliquat de jouissance', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M11";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="arret-view">

  
    <p>
        <?php  if ($habilation->AUPDATE == 1) echo Html::a('Modifier', ['update', 'id' => $model->ID_SUSPENSION], ['class' => 'btn btn-primary']) ?>
        <?php  if ($habilation->ADELETE == 1) echo Html::a('Supprimer', ['delete', 'id' => $model->ID_SUSPENSION], [
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
            'JOUISSANCE',
            'DATEDEBUT',
            'DATEFIN',
            'STATUT',
            'DATEEMIS',
            'DATEVAL',
            'DATEANN',
            'COMMENTAIRE:ntext',
            'DOCUMENT'=>[

                'label' => Yii::t('app', 'cfile'),
                'format'=>'raw',
                'value'=>Html::a('Telecharger', $model->showFile()),
            ],
        ],
    ]) ?>

</div>
