<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use yii\web\View;
use app\models\Exercice;
use app\models\Departements;

/* @var $this yii\web\View */
/* @var $model app\models\Exercice */

$this->title = 'Emission des décisions de congés';
$this->params['breadcrumbs'][] = ['label' => 'Exercices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$lien1 = Yii::$app->getUrlManager()->createUrl('exercice/creation');

?>

<!-- Modal creation client -->
<div class="modal fade modal-xl" id="creation2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content  modal-info">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body  modal-spa" style="background-color: #ffffff; height: 400px; overflow: auto">

                <div id="mesret312" class="alert-success" style="padding:10px; font-size:12px; display:none"></div>

                <div id="mesret313" class="alert-danger" style="padding:10px; font-size:12px; display:none"></div>

                <form action="<?=$lien1?>" id="formcreation2" method="post">

                    <h3 style="font-weight:bold" id="headrep12">CONFIRMATION DE GENERATION</h3>

                    <div id="mescreate1" class="alert-success" style="padding:10px; font-size:12px; display:none"></div>

                    <div id="mescreate2" class="alert-danger" style="padding:10px; font-size:12px; display:none"></div>

                    <div id="mescreate3" class="alert-info" style="padding:10px; font-size:12px; display:none"></div>

                    <div id="psection2"></div>

                    <label for="name"  style="margin-top: 12px; font-size: 12pt; color: #ffffff">Projets de d&eacute;cisions qui seront g&eacute;n&eacute;r&eacute;s (<span id="qte"></span>)</label><br>

                   <div id="mprojets"></div>

                    <input type="hidden" name="vexercice" id="vexercice" value="0" />

                    <input type="hidden" name="vdepartement" id="vdepartement" value="0" />

                    <input type="hidden" name="vdirection" id="vdirection" value="0" />

                    <input type="hidden" name="vjour" id="vjour" value="" />

                    <input type="hidden" name="vjour2" id="vjour2" value="" />

                    <input type="hidden" name="vservice" id="vservice" value="" />

                    <input type="hidden" name="vsuffix" id="vsuffix" value="" />

                    <br><br>

                    <button type="submit" class="btn btn-success" style="background-color: #00a157; color: #ffffff">VALIDER</button>&nbsp;&nbsp; <button type="button" onclick="fermer()" class="btn btn-danger" style="color: #ffffff">ANNULER</button>

                </form>

            </div>
        </div>
    </div>
</div>
<!-- //app-->

<div class="exercice-update">

    <div id="wait" class="alert-info" style="padding:10px; font-size:12px; display:none"></div>

    <?= Html::beginForm(['decision'],'post',['id'=>'formsoumission','enctype' => 'multipart/form-data']);?>
    <br><br>

      <label>Choisir l'exercice</label>
<select name="exercice1" id="exercice1" onchange="myexo()" class="form-control" required >
<option value="" disabled selected>Faire un choix</option>
<?php 

    $exercices = Exercice::find()->where(['STATUT'=>'O'])->orderBy(['ANNEEEXIGIBLE'=>SORT_DESC])->all();

    foreach($exercices as $exercice) {

        echo '<option value="'.$exercice->ANNEEEXIGIBLE.'">'.$exercice->ANNEEEXIGIBLE.'</option>';
    }

?> 
</select>


    <?php

   /* echo '<label class="control-label">Choisir la date de debut </label>';
    echo DatePicker::widget([
        'name' => 'jour',
        'language' => 'fr',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Choisir une date'],

    ]); */

    ?>

    <?php

  /*  echo '<label class="control-label">Choisir la date de fin</label>';
    echo DatePicker::widget([
        'name' => 'jour2',
        'language' => 'fr',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Choisir une date'],

    ]); */


    ?><br>


  <label>Choisir la date de debut </label>

    <input type="date" required class="form-control" required name="jour" id="jour" /> <br>

      <label>Choisir la date de fin </label>

<input type="date" required class="form-control" required  name="jour2" id="jour2" /> <br>

    <label>Choisir la direction </label>

    <select name="direction" id="direction" required class="form-control" >
        <option value="" disabled selected>Faire un choix</option>
        <option value="0">Toutes les directions</option>
        <?php

        $services = \app\models\Direction::find()->orderBy(['LIBELLE'=>SORT_ASC])->all();

        foreach($services as $service) {

            echo '<option value="'.$service->ID.'">'.$service->LIBELLE.'</option>';
        }

        ?>
    </select><br>


    <label>Choisir le d&eacute;partement </label>

  <select name="departement" id="departement" required class="form-control" >
  <option value="" disabled selected>Faire un choix</option>
<option value="0">Tous les d&eacute;partements</option>
<?php 

    $services = Departements::find()->orderBy(['LIBELLE'=>SORT_ASC])->all();

    foreach($services as $service) {

        echo '<option value="'.$service->CODEDPT.'">'.$service->LIBELLE.'</option>';
    }

?> 
</select><br>

    <label>Choisir le service </label>

    <select name="service" id="service" required class="form-control" >
        <option value="" disabled selected>Faire un choix</option>
        <option value="0">Tous les services</option>
        <?php

        $services = \app\models\Service::find()->orderBy(['LIBELLE'=>SORT_ASC])->all();

        foreach($services as $service) {

            echo '<option value="'.$service->ID.'">'.$service->LIBELLE.'</option>';
        }

        ?>
    </select><br>


    <!-- <label>Suffix d&eacute;cision de cong&eacute;s (Ex: 18/ADC/DG/DH/DH.P/DHPP/SAD/ahm)</label>

   <input type="text" required class="form-control" required  name="suffix" id="suffix" /> <br>

   -->
    <input type="hidden" name="cle" id="cle" value="" />

    <br>


    <div class="form-group" id="zone_bt">

        <?php

     
            echo Html::submitButton('LANCER LA GENERATION', ['class' => 'btn btn-success']) . "&nbsp;&nbsp;";

           // echo '<a href="#" data-toggle="modal" data-target="#creation2" class="btn btn-success">LANCER LA GENERATION</a>' . "&nbsp;&nbsp;";

            echo Html::a('ANNULER', ['exercice/index'], ['class' => 'btn btn-danger']);

     

        ?>

    </div>

    <?= Html::endForm();?>

</div>

<?php

$lien = Yii::$app->getUrlManager()->createUrl('exercice/build');

$lien2 = Yii::$app->getUrlManager()->createUrl('exercice/check');

$script = <<< JS

    $(document).ready(function() {
        
    $("#wait").hide();    
    
    $("#formsoumission").on('submit', function(event){
        
    event.preventDefault(); $("#zone_bt").hide();
    
    $("#wait").html("Traitement en cours, veuillez patienter...");
    
    $("#wait").show();
    
     $.ajax({
     url: "$lien",
     data: $("#formsoumission").serialize(),
        success: function(data) {
        $("#formsoumission")[0].reset(); 
        
        var tab = data.split("@@");  $("#zone_bt").show();
        
        if(tab[1] == -1) {
            
            alert(tab[2]);   $("#wait").hide(); 
        }
        
        else {
        
         $("#mprojets").html(tab[0]); $("#qte").html(tab[1]); $("#vservice").val(tab[8]);
         
         $("#vjour").val(tab[2]);  $("#vjour2").val(tab[3]); $("#vdirection").val(tab[7]); 

         $("#vservice").val(tab[4]);   $("#vexercice").val(tab[5]); $("#vsuffix").val(tab[6]); 
         
         $("#wait").hide(); 
        
         $("#creation2").modal("toggle"); }

            }
        });

    });
    
    
});


function fermer(){
    
    $("#formcreation2")[0].reset();  $("#mprojets").html("");
    
    $("#creation2").modal('hide');
}

function myexo(){

    var exo = $("#exercice1").val();



      $.ajax({
     url: "$lien2",
     data: {'exercice':exo},
        success: function(data) {
            var tab = data.split(":");

            if(tab[0] != "0") {
                
                $("#jour").attr({ "min" : tab[0] }); $("#jour2").attr({ "min" : tab[0] });

            }

            if(tab[1] != "0") {
                
                $("#jour").attr({ "max" : tab[1] }); $("#jour2").attr({ "max" : tab[1] });

            } 

            // $('#jour').kvDatepicker({"format": "yyyy-mm-dd", "startDate" : tab[0],"endDate" : tab[1] });
            
           // $('#jour2').kvDatepicker({"format": "yyyy-mm-dd", "startDate" : tab[0],"endDate" : tab[1] });
           
         //   $("#jour").attr({ "min" : tab[0] }); $("#jour2").attr({ "min" : tab[0] });
            
           //  $("#jour").attr({ "max" : tab[1] }); $("#jour2").attr({ "max" : tab[1] });
             
           //  $('#jour').datepicker({"format": "yyyy-mm-dd", "minDate" : tab[0],"maxDate" : tab[1] });
         
            
         }
        });

}

JS;

$this->registerJs($script,View::POS_END);

?>
