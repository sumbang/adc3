<?php

use app\models\Decisionconges;
use app\models\Employe;
use app\models\Habilitation;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\Alert;
use yii\helpers\ArrayHelper;
use app\models\Roles;
use app\models\Menus;

/* @var $this yii\web\View */
/* @var $model app\models\Exercice */

$this->title = $model->ANNEEEXIGIBLE;
$this->params['breadcrumbs'][] = ['label' => 'Exercices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M2";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="exercice-view">

    <?= Alert::widget() ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ANNEEEXIGIBLE',
            'DATEBEDUT',
            'DATEFIN',
            'STATUT',
            'DATEOUVERT',
            'DATECLOTURE',
        ],
    ]) ?>

    <?php

    if($model->STATUT == "B") {

        if ($habilation->ADELETE == 1)  echo Html::a('OUVRIR L\'EXERCICE',['exercice/ouverture','exercice'=>$model->ANNEEEXIGIBLE], ['class' => 'btn btn-primary']);

    }

    else if($model->STATUT == "O"){

        if ($habilation->ADELETE == 1)   echo Html::a('CLOTURER L\'EXERCICE',['exercice/fermeture','exercice'=>$model->ANNEEEXIGIBLE], ['class' => 'btn btn-danger'])."&nbsp;&nbsp;";

        if ($habilation->AUPDATE == 1)  echo Html::a('GENERER LES DECISIONS DE CONGES',['exercice/decision','exercice'=>$model->ANNEEEXIGIBLE], ['class' => 'btn btn-success'])."&nbsp;&nbsp;";
    }

   /// if ($habilation->AUPDATE == 1)  echo Html::a('EXPORTER LES DONNEES DE L\'EXERCICE',['exercice/export','exercice'=>$model->ANNEEEXIGIBLE], ['class' => 'btn btn-info']);

    ?>

</div>


