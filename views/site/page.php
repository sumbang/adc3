<?php

$this->title = 'Reporting';

use app\models\Exercice;
use yii\web\View;
use yii\helpers\Html;
use app\models\Jouissance;
use app\models\Employe;
use app\models\Decisionconges;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use app\models\Absenceponctuel;

?>
<div class="site-index">

    <div style="width: 90%; margin: 0px auto">


           <?php  echo Html::beginForm(['export1'],'post',['id'=>'formexport']); ?>

        <div class="row">

            <div class="form-group">
                <input type="text" name="matricule"  class="form-control" style="padding: 5px" placeholder="Matricule" />
            </div>

            <div class="form-group">
                <input type="text" name="nom" class="form-control" style="padding: 5px" placeholder="Nom" />  </div>


            <div class="form-group">
                <input type="date" class="form-control" name="conge" style="padding: 5px" placeholder="Debut" /> </div>


            <div class="form-group">
                <input type="date" class="form-control" name="conges" style="padding: 5px" placeholder="Fin" /> </div>


            <div class="form-group">
                Exercices : <select style="padding: 5px;  width: 200px" name="exercice" class="form-control"><option value="0" selected>Tout</option>
                    <?php
                    $exs = Exercice::find()->orderBy(["ANNEEEXIGIBLE"=>SORT_DESC])->all();
                    foreach ($exs as $ex) {
                        echo '<option value="'.$ex->ANNEEEXIGIBLE.'" >'.$ex->ANNEEEXIGIBLE.'</option>';
                    }
                    ?>
                </select> </div>


            <div class="form-group">
                Direction : <select style="padding: 5px; width: 200px" class="form-control" name="direction"><option value="0" selected>Toutes</option>
                    <?php
                    $dps = \app\models\Direction::find()->orderBy(["LIBELLE"=>SORT_ASC])->all();
                    foreach ($dps as $dp) {
                        echo '<option value="'.$dp->ID.'" >'.$dp->LIBELLE.'</option>';
                    }
                    ?>
                </select></div>


            <div class="form-group">
                Départements : <select style="padding: 5px; width: 200px" class="form-control" name="departement"><option value="0" selected>Tous</option>
                    <?php
                    $dps = \app\models\Departements::find()->orderBy(["LIBELLE"=>SORT_ASC])->all();
                    foreach ($dps as $dp) {
                        echo '<option value="'.$dp->CODEDPT.'" >'.$dp->LIBELLE.'</option>';
                    }
                    ?>
                </select></div>


            <div class="form-group">
                Service : <select style="padding: 5px; width: 200px" name="service" class="form-control"><option value="0" selected>Tous</option>
                    <?php
                    $dps = \app\models\Service::find()->orderBy(["LIBELLE"=>SORT_ASC])->all();
                    foreach ($dps as $dp) {
                        echo '<option value="'.$dp->ID.'" >'.$dp->LIBELLE.'</option>';
                    }
                    ?>
                </select> </div>

            <div class="form-group">
                <input type="submit" class="btn-primary btn-sm" value="Exporter">
            </div>


        </div>



           <?=   Html::endForm(); ?>

      <br>

        <?php

/*

        $employes = Employe::find()->where(["STATUT"=>1]);

        if(isset($_REQUEST["matricule"]) && !empty($_REQUEST["matricule"])) {
            $employes->andWhere(["MATRICULE"=>$_REQUEST["matricule"]]);
        }

        if(isset($_REQUEST["nom"]) && !empty($_REQUEST["nom"])) {
            $employes->andWhere(["LIKE","NOM",$_REQUEST["nom"]]);
        }

        if(isset($_REQUEST["direction"]) && !empty($_REQUEST["direction"]) ) {
           // $employes->andWhere(["LIKE","DIRECTION",$_REQUEST["direction"]]);
            $employes->andWhere(["DIRECTION"=>$_REQUEST["direction"]]);
        }

        if(isset($_REQUEST["service"]) && !empty($_REQUEST["service"])) {
          // $employes->andWhere(["LIKE","SERVICE",$_REQUEST["service"]]);
            $employes->andWhere(["SERVICE"=>$_REQUEST["service"]]);
        }

        if(isset($_REQUEST["departement"]) && ($_REQUEST["departement"] != 0)) {

            $employes->andWhere(["CODEDPT"=>$_REQUEST["departement"]]);
        }

        if(isset($_REQUEST["conge"]) && !empty($_REQUEST["conge"])) {

            if(isset($_REQUEST["conges"]) && !empty($_REQUEST["conges"])) {

                $fin = $_REQUEST["conges"];

                $employes->andWhere(['>=', 'DATECALCUL', $_REQUEST["conge"]])->andWhere(['<=', 'DATECALCUL', $fin]);
            }

            else $employes->andWhere(["DATECALCUL" => $_REQUEST["conge"]]);

        }


        $employes->orderBy(['NOM'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $employes,
        ]);


        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'label' => 'MATRICULE',
                    'value' => function ($data) {
                        return $data->MATRICULE;
                    },
                ],

                [
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'label' => 'NOM',
                    'value' => function ($data) {
                        return $data->NOM." ".$data->PRENOM;
                    },
                ],

                [
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'label' => 'EXERCICE',
                    'value' => function ($data) {

                        if(isset($_REQUEST["exercice"]) && ($_REQUEST["exercice"] != 0)) {

                            $exo =  Exercice::findOne($_REQUEST["exercice"]);
                        }

                        else $exo =  Exercice::find()->orderBy(['ANNEEEXIGIBLE'=>SORT_DESC])->One();

                        return $exo->ANNEEEXIGIBLE;
                    },
                ],

                [
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'label' => 'PERMISSION IMPUTABLE (Jrs)',
                    'value' => function ($data) {

                        if(isset($_REQUEST["exercice"]) && ($_REQUEST["exercice"] != 0)) {

                            $exo =  Exercice::findOne($_REQUEST["exercice"]);
                        }

                        else $exo =  Exercice::find()->orderBy(['ANNEEEXIGIBLE'=>SORT_DESC])->One();

                        $abscences = Absenceponctuel::find()->where(['MATICULE'=>$data->MATRICULE,'ANNEEEXIGIBLE'=>$exo->ANNEEEXIGIBLE,'IMPUTERCONGES'=>1,'STATUT'=>'V'])->all();

                        $duree1 = 0; $duree2 = 0;

                        foreach($abscences as $abs) {

                            if($abs->TYPE_DEMANDE == 0) {

                                $d1 = strtotime($abs->DATEDEBUT); $d2 = strtotime($abs->DATEFIN);

                                $diff = $d2 - $d1;

                                $nbjour = abs(round($diff/86400)) + 1;

                                $duree1+=$nbjour;
                            }

                            else {

                                $duree2+= $abs->DUREE;
                            }

                        }

                        $jourheureconge = (int)($duree2 / 8);

                        $duree1+= $jourheureconge;

                        return $duree1;
                    },
                ],

                [
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'label' => 'PERMISSION NON IMPUTABLE (Jrs)',
                    'value' => function ($data) {

                        if(isset($_REQUEST["exercice"]) && ($_REQUEST["exercice"] != 0)) {

                            $exo =  Exercice::findOne($_REQUEST["exercice"]);
                        }

                        else $exo =  Exercice::find()->orderBy(['ANNEEEXIGIBLE'=>SORT_DESC])->One();

                        $abscences1 = Absenceponctuel::find()->where(['MATICULE'=>$data->MATRICULE,'ANNEEEXIGIBLE'=>$exo->ANNEEEXIGIBLE,'IMPUTERCONGES'=>2,'STATUT'=>'V'])->all();

                        $duree2 = 0; $duree1 = 0;

                        foreach($abscences1 as $abs) {

                            if($abs->TYPE_DEMANDE == 0) {

                                $d1 = strtotime($abs->DATEDEBUT); $d2 = strtotime($abs->DATEFIN);

                                $diff = $d2 - $d1;

                                $nbjour = abs(round($diff/86400)) + 1;

                                $duree1+=$nbjour;
                            }

                            else {

                                $duree2+= $abs->DUREE;
                            }

                        }

                        $jourheureconge = (int)($duree2 / 8);

                        $duree1+= $jourheureconge;

                        return $duree1;
                    },
                ],

                [
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'label' => 'JOUISSANCE',
                    'value' => function ($data) {

                        if(isset($_REQUEST["exercice"]) && ($_REQUEST["exercice"] != 0)) {

                            $exo =  Exercice::findOne($_REQUEST["exercice"]);
                        }

                        else $exo =  Exercice::find()->orderBy(['ANNEEEXIGIBLE'=>SORT_DESC])->One();

                        $d = Decisionconges::find()->select('ID_DECISION')->where(['MATICULE'=>$data->MATRICULE])->all(); $l = array();

                        foreach ($d as $el) $l[] = $el->ID_DECISION;

                        $jouissance = Jouissance::find()->where(['TYPES'=>['01','02','04'], 'EXERCICE'=>$exo->ANNEEEXIGIBLE,'STATUT'=>'V'])->andWhere(['IN','IDDECISION',$l])->all();

                        return count($jouissance);
                    },
                ],

                [
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'label' => 'NON JOUISSANCE',
                    'value' => function ($data) {

                        if(isset($_REQUEST["exercice"]) && ($_REQUEST["exercice"] != 0)) {

                            $exo =  Exercice::findOne($_REQUEST["exercice"]);
                        }

                        else $exo =  Exercice::find()->orderBy(['ANNEEEXIGIBLE'=>SORT_DESC])->One();

                        $d = Decisionconges::find()->select('ID_DECISION')->where(['MATICULE'=>$data->MATRICULE])->all(); $l = array();

                        foreach ($d as $el) $l[] = $el->ID_DECISION;

                        $jouissance1 = Jouissance::find()->where(['TYPES'=>'03', 'EXERCICE'=>$exo->ANNEEEXIGIBLE,'STATUT'=>'V'])->andWhere(['IN','IDDECISION',$l])->all();

                        return count($jouissance1);
                    },
                ],

                [
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'label' => 'CREDIT CONGÉS (Jrs)',
                    'value' => function ($data) {

                        $employe = Employe::findOne($data->MATRICULE);

                        return $employe->SOLDECREDIT;
                    },
                ],

                [
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'label' => 'PROCHAIN CONGÉ',
                    'value' => function ($data) {

                        $employe = Employe::findOne($data->MATRICULE);

                        $d = explode("-",$employe->DATECALCUL);

                        return $d["2"]."-".$d[1]."-".$d[0];
                    },
                ],

            ],
        ]);

        */

        ?>

   </div>

</div>