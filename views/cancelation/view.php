<?php

use app\models\Habilitation;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Roles;
use app\models\Menus;

/* @var $this yii\web\View */
/* @var $model app\models\Cancelation */

$this->title = 'Détail de la  suspension';
$this->params['breadcrumbs'][] = ['label' => 'Suspensions de jouissance', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M19";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="cancelation-view">

    <p>
        <?php  if($habilation->AUPDATE == 1) echo   Html::a('Modifier', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?php  if($habilation->AUPDATE == 1) echo  Html::a('Supprimer', ['delete', 'id' => $model->ID], [
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
          //  'ID',
            'JOUISSANCE'=> [
                'label' => 'Jouissance',
                'value' => $model->getJouissance()
            ],
            'DEBUT',
            'PERIODE',
            'COMMENTAIRE:ntext',
            'FICHIER'=>[
                'label' => 'Document joint',
                'format'=>'raw',
                'value'=>Html::a('Ouvrir', $model->showFile(),['target'=>'_blank']),
            ],
           // 'IDUSER',
            //'DATECREATION',
        ],
    ]) ?>

</div>
