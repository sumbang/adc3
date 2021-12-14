<?php

use app\models\Habilitation;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\models\Roles;
use app\models\Menus;

/* @var $this yii\web\View */
/* @var $model app\models\Decisionconges */

$this->title = 'Détail de la décision de congés';
$this->params['breadcrumbs'][] = ['label' => 'Décisions de congés', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M4";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="decisionconges-view">

    <p>
        <?php if ($habilation->AUPDATE == 1) echo Html::a('Modifier', ['update', 'id' => $model->ID_DECISION], ['class' => 'btn btn-primary']) ?>
        <?php  if ($habilation->ADELETE == 1)  echo Html::a('Supprimer', ['delete', 'id' => $model->ID_DECISION], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

        <?php

        if($model->STATUT == "V") {

            if(!empty($model->EDITION)) {

              //  echo "&nbsp;&nbsp;".Html::a('Edition de la décision', ['update', 'id' => $model->ID_DECISION], ['class' => 'btn btn-success']);
            }

            else {

             //   echo "&nbsp;&nbsp;".Html::a('Générer l\'édition de la décision', ['update', 'id' => $model->ID_DECISION], ['class' => 'btn btn-success']);
            }

        }

        ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'ID_DECISION',
            'MATICULE'=> [
                'label' => 'Employe',
                'value' => $model->getEmploi()
            ],
            'ANNEEEXIGIBLE'=> [
                'label' => 'Exercice',
                'value' => $model->getAnnee()
            ],
            'REF_DECISION',
            'DEBUTPERIODE',
            'FINPERIODE',
            'DEBUTPLANIF',
            'FINPLANIF',
            //'DEBUTREELL',
           // 'FINREEL',
            'STATUT' => [
                'label' => 'Statut',
                'value' => $model->getStatut($model->STATUT)
            ],
            'DATEEMIS',
            'DATEVAL',
             'EDITION'=>[
                 'label' => 'Document edition',
                 'format'=>'raw',
                 'value'=>Html::a('Ouvrir', $model->showFile(),['target'=>'_blank']),
             ],
           // 'DATESUSP',
           // 'DATEANN',
            'DATEREPRISE',
         //   'DATECLOTURE',
         //   'SITUTATIONFAMILIALE',
         //   'MODETRANSPORT',
        ],
    ]) ?>

</div>
