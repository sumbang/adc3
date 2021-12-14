<?php

use app\models\Habilitation;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Roles;
use app\models\Menus;

/* @var $this yii\web\View */
/* @var $model app\models\Jouissance */

$this->title = 'Détail de la jouissance';
$this->params['breadcrumbs'][] = ['label' => 'Jouissances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M9";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="jouissance-view">

    <p>
        <?php  if ($habilation->AUPDATE == 1)  echo Html::a('Modifier', ['update', 'id' => $model->IDNATURE], ['class' => 'btn btn-primary']) ?>
        <?php if ($habilation->ADELETE == 1) echo Html::a('Supprimer', ['delete', 'id' => $model->IDNATURE], [
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
          //  'IDNATURE',
            'TITRE',
            'NUMERO',
            'DEBUT',
            'FIN',
            'DEBUTREPORT',
            'FINREPORT',
           // 'MESSAGE:ntext',
           // 'LIEU',
           // 'JOUR',
            'TYPES' => [
                'label' => 'Types de décision',
                'value' => $model->getType()
            ],
            'DOCUMENT'=>[
                'label' => 'Document de jouissance',
                'format'=>'raw',
                'value'=>Html::a('Ouvrir', $model->showFile(),['target'=>'_blank']),
            ],
            'DOCUMENT2'=>[
                'label' => 'Piece jointe de jouissance',
                'format'=>'raw',
                'value'=>Html::a('Ouvrir', $model->showFile2(),['target'=>'_blank']),
            ],
            'DOCUMENT3'=>[
                'label' => 'Piece jointe de report',
                'format'=>'raw',
                'value'=>Html::a('Ouvrir', $model->showFile3(),['target'=>'_blank']),
            ],
            'DOCUMENT4'=>[
                'label' => 'Document report de jouissance',
                'format'=>'raw',
                'value'=>Html::a('Ouvrir', $model->showFile4(),['target'=>'_blank']),
            ],
            'IDDECISION' => [
                'label' => 'Décision de congés',
                'value' => $model->getDecision()
            ],
           // 'DATECREATION',
          //  'USERCREATE',
          //  'EXERCICE',
        ],
    ]) ?>

</div>
