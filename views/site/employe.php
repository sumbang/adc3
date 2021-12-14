<?php

$this->title = 'Etats et reporting par employe';

use app\models\Exercice;
use Mpdf\Tag\Em;
use yii\web\View;
use yii\helpers\Html;
use app\models\Jouissance;
use app\models\Employe;
use app\models\Decisionconges;
use app\models\Absenceponctuel;

$exo2 =  Exercice::find()->orderBy(['ANNEEEXIGIBLE'=>SORT_DESC])->One();

$exercices = Exercice::find()->orderBy(['ANNEEEXIGIBLE'=>SORT_DESC])->all();

$lien = Yii::$app->getUrlManager()->createUrl('site/employes');

?>

<div class="site-index">

    <div style="overflow: auto;overflow-y: hidden; Height:?">

        <table width="100%" cellpadding="5" cellspacing="5">
            <form action="" method="get" >

                <tr>
                    <td><input type="text" name="matricule" style="padding: 5px" placeholder="Matricule" /></td>
                    <td>Suspension : <select style="padding: 5px" name="suspension"><option value="0">Tout</option><option value="1">Oui</option><option value="2">Non</option></select</td>
                    <td>Exercices : <select style="padding: 5px" name="exercice"><option value="0">Tout</option><?php foreach($exercices as $exercice) echo '<option value="'.$exercice->ANNEEEXIGIBLE.'">'.$exercice->ANNEEEXIGIBLE.'</option>'; ?></select></td>
                    <td>Permissions : <select style="padding: 5px" name="permission"><option value="0">Tout</option><option value="1">Imputable</option><option value="2">Non imputable</option></select></td>
                    <td>Jouissances : <select style="padding: 5px" name="jouissance"><option value="0">Tout</option><option value="01">Jouissance</option><option value="02">Jouissance partielle</option><option value="03">Non Jouissance</option><option value="04">Reliquat conges</option><option value="05">Report conges</option></select></td>

                    <td style="padding: 5px"><input type="submit" class="btn-primary btn-sm" value="Go"></td>
                </tr>

            </form>

        </table><br>

       <?php

       if(isset($_REQUEST["matricule"])){

           $matricule = $_REQUEST["matricule"]; $suspension = $_REQUEST["suspension"]; $exo = $_REQUEST["exercice"];

           $permission = $_REQUEST["permission"]; $jouissance = $_REQUEST["jouissance"];

           $employe = Employe::find()->where(['MATRICULE'=>$matricule])->one();

           if($employe != null){


           }

           else echo '<div style="margin: 20px auto"><h5>Aucun résultat trouvé</h5></div>';

       }

       ?>

        </div>


