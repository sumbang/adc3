<?php

use app\models\Habilitation;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Roles;
use app\models\Menus;

/* @var $this yii\web\View */
/* @var $model app\models\Absenceponctuel */

$this->title = 'Détail de la demande de permission';
$this->params['breadcrumbs'][] = ['label' => 'Demande de permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M5";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="absenceponctuel-view">
    <p>
        <?php  if($habilation->AUPDATE == 1) echo  Html::a('Modifier', ['update', 'id' => $model->ID_ABSENCE], ['class' => 'btn btn-primary']) ?>
        <?php   if($habilation->ADELETE == 1) echo  Html::a('Supprimer', ['delete', 'id' => $model->ID_ABSENCE], [
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
            'ID_ABSENCE',
            'CODEABS'=> [
                'label' => 'Code absence',
                'value' => $model->getType()
            ],
            'MATICULE'=> [
                'label' => 'Employe',
                'value' => $model->getEmploi()
            ],
            'ANNEEEXIGIBLE'=> [
                'label' => 'Exercice',
                'value' => $model->getAnnee()
            ],
            'DATEDEBUT',
            'DATEFIN',
            'STATUT' => [
                'label' => 'Statut',
                'value' => $model->getStatut()
            ],
            'IMPUTERCONGES' => [
                'label' => 'Imputer sur les conges',
                'value' => $model->getGenre()
            ],
            'TYPE_DEMANDE' => [
                'label' => 'Type de demande',
                'value' => $model->getTypeDemande()
            ],
            'DUREE',
            'DATEEMIS',
            'DATEVAL',
            'DATEANN',
            
        ],
    ]) ?>

</div>
