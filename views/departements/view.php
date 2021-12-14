<?php

use app\models\Decisionconges;
use app\models\Employe;
use app\models\Habilitation;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Roles;
use app\models\Menus;

/* @var $this yii\web\View */
/* @var $model app\models\Departements */

$this->title = 'Détail du département';
$this->params['breadcrumbs'][] = ['label' => 'Départements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M8";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>
<div class="departements-view">

    <p>
        <?php if ($habilation->AUPDATE == 1) echo  Html::a('Modifier', ['update', 'id' => $model->CODEDPT], ['class' => 'btn btn-primary']) ?>
        <?php  if ($habilation->ADELETE == 1)  echo Html::a('Supprimer', ['delete', 'id' => $model->CODEDPT], [
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
            'CODEDPT',
            'LIBELLE',
        ],
    ]) ?>

</div>

<h3>Décisions de congés</h3>

<div style="overflow: auto;overflow-y: hidden; Height:?">

    <table width="140%" border="1" cellpadding="5" cellspacing="5">

        <tr>
            <th style="padding: 5px">EXERCICE</th>
            <th style="padding: 5px">NUMERO DE DECISION</th>
            <th style="padding: 5px">STATUT</th>
            <th style="padding: 5px">DEBUT</th>
            <th style="padding: 5px">FIN</th>
            <th style="padding: 5px">DUREE DE CONGES</th>
            <th style="padding: 5px">DUREE RESTANTE</th>
            <th style="padding: 5px">DETAILS</th>
        </tr>

        <?php

        $decisions = \app\models\Decisionconges::find()->where(['IN','MATICULE',Employe::find()->select('MATRICULE')->where(['CODEDPT'=>$model->CODEDPT])->all()])->orderBy(['ANNEEEXIGIBLE'=>SORT_DESC])->all();

        $i = 0;

        foreach($decisions as $decision) {

            $date1 = strtotime($decision->DEBUTPLANIF); $date2 = strtotime($decision->FINPLANIF);

            $diff = $date2 - $date1;

            $nbjourabs = abs(round($diff/86400)) + 1;

            echo ' <tr>
            <td style="padding: 5px">'.$decision->ANNEEEXIGIBLE.'</td>
            <td style="padding: 5px">'.$decision->REF_DECISION.'</td>
            <td style="padding: 5px">'.$decision->getStatut($decision->STATUT).'</td>
            <td style="padding: 5px">'.$decision->DEBUTPLANIF.'</td>
            <td style="padding: 5px">'.$decision->FINPLANIF.'</td>
            <td style="padding: 5px">'.$nbjourabs.'</td>
            <td style="padding: 5px">'.$decision->NBJOUR.'</td>
            <td style="padding: 5px">'.Html::a('DETAILS',['decisionconges/update','id'=>$decision->ID_DECISION], ['class' => 'btn btn-success']).'</td>
        </tr>';

            $i++;
        }

        ?>

    </table> <br>

    <b>Total d&eacute;cisions : <?= $i; ?></b>

</div>

<h3>Jouissance de congés</h3>

<div style="overflow: auto;overflow-y: hidden; Height:?">

    <table width="140%" border="1" cellpadding="5" cellspacing="5">

        <tr>
            <th style="padding: 5px">EXERCICE</th>
            <th style="padding: 5px">NUMERO DE JOUISSANCE</th>
            <th style="padding: 5px">NUMERO DE DECISION</th>
            <th style="padding: 5px">TYPE JOUISSANCE</th>
            <th style="padding: 5px">STATUT</th>
            <th style="padding: 5px">DEBUT</th>
            <th style="padding: 5px">FIN</th>
            <th style="padding: 5px">DUREE JOUISSANCE</th>
            <th style="padding: 5px">DETAILS</th>
        </tr>

        <?php

        $jouissances = \app\models\Jouissance::find()->where(['IN','IDDECISION',Decisionconges::find()->select('ID_DECISION')->where(['IN','MATICULE',Employe::find()->select('MATRICULE')->where(['CODEDPT'=>$model->CODEDPT])->all()])])->orderBy(['EXERCICE'=>SORT_DESC])->all();

        $j = 0;

        foreach($jouissances as $jouissance) {

            $decision = \app\models\Decisionconges::find()->where(['ID_DECISION'=>$jouissance->IDDECISION])->one();

            $date1 = strtotime($jouissance->DEBUT); $date2 = strtotime($jouissance->FIN);

            $diff = $date2 - $date1;

            $nbjourabs = abs(round($diff/86400)) + 1;

            echo ' <tr>
            <td style="padding: 5px">'.$jouissance->EXERCICE.'</td>
            <td style="padding: 5px">'.$jouissance->NUMERO.'</td>
            <td style="padding: 5px">'.$decision->REF_DECISION.'</td>
            <td style="padding: 5px">'.$jouissance->getType().'</td>
            <td style="padding: 5px">'.$jouissance->getStatut($jouissance->STATUT).'</td>
            <td style="padding: 5px">'.$jouissance->DEBUT.'</td>
            <td style="padding: 5px">'.$jouissance->FIN.'</td>
            <td style="padding: 5px">'.$nbjourabs.'</td>
            <td style="padding: 5px">'.Html::a('DETAILS',['jouissance/update','id'=>$jouissance->IDNATURE], ['class' => 'btn btn-success']).'</td>
        </tr>';

            $j++;

        }

        ?>

    </table><br>

    <b>Total jouissances : <?= $j; ?></b>

</div>

<h3>Permissions d'absences</h3>

<div style="overflow: auto;overflow-y: hidden; Height:?">

    <table width="140%" border="1" cellpadding="5" cellspacing="5">

        <tr>
            <th style="padding: 5px">EXERCICE</th>
            <th style="padding: 5px">NATURE</th>
            <th style="padding: 5px">STATUT</th>
            <th style="padding: 5px">IMPUTER SUR CONGES</th>
            <th style="padding: 5px">DEBUT</th>
            <th style="padding: 5px">FIN</th>
            <th style="padding: 5px">DUREE PERMISSION</th>
            <th style="padding: 5px">DETAILS</th>
        </tr>

        <?php

        $permissions = \app\models\Absenceponctuel::find()->where(['IN','MATICULE',Employe::find()->select('MATRICULE')->where(['CODEDPT'=>$model->CODEDPT])->all()])->orderBy(['ANNEEEXIGIBLE'=>SORT_DESC])->all();

        $k = 0;

        foreach($permissions as $permission) {

            $nature = \app\models\Typeabsence::find()->where(['CODEABS'=>$permission->CODEABS])->one();

            $date1 = strtotime($permission->DATEDEBUT); $date2 = strtotime($permission->DATEFIN);

            $diff = $date2 - $date1;

            $nbjourabs = abs(round($diff/86400)) + 1;

            if($permission->IMPUTERCONGES == 1) $text = "OUI"; else $text = "NON";

            echo ' <tr>
            <td style="padding: 5px">'.$permission->ANNEEEXIGIBLE.'</td>
            <td style="padding: 5px">'.$nature->LIBELLE.'</td>
            <td style="padding: 5px">'.$permission->getStatut().'</td>
            <td style="padding: 5px">'.$text.'</td>
            <td style="padding: 5px">'.$permission->DATEDEBUT.'</td>
            <td style="padding: 5px">'.$permission->DATEFIN.'</td>
            <td style="padding: 5px">'.$nbjourabs.'</td>
            <td style="padding: 5px">'.Html::a('DETAILS',['absenceponctue/update','id'=>$permission->ID_ABSENCE], ['class' => 'btn btn-success']).'</td>
        </tr>';

            $k++;
        }

        ?>

    </table> <br>
