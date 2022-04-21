<?php

namespace app\commands;

use app\models\Direction;
use app\models\Emploi;
use app\models\Employe;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class EmployeController extends Controller
{
    public function actionIndex()
    {

        $fileHandler=fopen(Yii::getAlias('@webfile'). DIRECTORY_SEPARATOR."conges1.csv",'r');

        if($fileHandler){

           // echo "Ligne \n\r";

            while($line=fgetcsv($fileHandler,1000)){

                //echo "ligne ".$line[0]."\n\r\n\r";

                $tab = explode(";",$line[0]);

                $matricule = $tab[0];

                if(strlen($matricule) < 5) {
                    for($i = 0; $i < (5 - strlen($tab[0])); $i++) {
                        $matricule = "0".$matricule;
                    }
                }

               /// echo "0".$matricule."\n\r";

                $tab_exclus = array("02148","00662","02258","01156","02497","02505","00577","02344","00347","01747","02175","02017","00817","01866","01504","01769","00190","01579","00383","02440","02180","00946","00956","01961","02032","02031","01585","01563","00872","00387");

                //if(in_array($matricule,$tab_exclus)) {

                   $exist = Employe::findOne(["MATRICULE" => $matricule]);

                    if($exist == null) {

                      //  echo "Debut ".$matricule."\n\r";

                      //  echo "ligne ".$line[0]."\n\r\n\r";

                        if (array_key_exists(11,$tab)) {

                            $tab_categorie = explode(" ",$tab[11]);
                            $categorie = $tab_categorie[0]; $echellon = $tab_categorie[1];

                            $emploi = utf8_encode($tab[8]); $direction = substr($tab[9],16);
                            $direction = utf8_encode($direction);

                            $job = Emploi::find()->where(["LIKE","LIBELLE",$emploi])->one();
                            if($job == null) {
                                $job = new Emploi();
                                $job->LIBELLE = $emploi;
                                $job->save(false);
                            }

                            $direct = Direction::find()->where(["LIKE","LIBELLE",$direction])->one();
                            if($direct == null) {
                                $direct = new Direction();
                                $direct->LIBELLE = $direction;
                                $direct->save(false);
                            }

                            $employe = new Employe();
                            $employe->MATRICULE = $matricule;
                            $employe->CODECAT = $categorie;
                            $employe->CODEECH = $echellon;
                            $employe->CODEEMP = $job->CODEEMP;
                            $employe->CODEETS = $tab[7];
                            $employe->CODECIV = $tab[2];
                            $employe->CODECONT = $tab[12];
                            $employe->CODEETS_EMB  = $tab[10];
                            $employe->NOM = utf8_encode($tab[3]);
                            $employe->PRENOM = utf8_encode($tab[4]);
                            $employe->DATEEMBAUCHE = $tab[6];
                            $employe->SOLDEAVANCE = 0.0;
                            $employe->SOLDECREDIT = 0.0;
                            $employe->DATECALCUL = date('Y-m-d',strtotime($tab[22]));
                            $employe->LASTCONGE =  date('Y-m-d',strtotime($tab[21].' -1 day'));
                            $employe->DEPLACE = ($tab[7] != $tab[10]) ? 1 : 0;
                            $employe->DATNAISS = date('Y-m-d',strtotime($tab[5]));
                            $employe->STATUT = 1;
                            $employe->DIRECTION = $direct->ID;
                            $employe->save(false);

                            //echo "Enregistrement ".$employe->MATRICULE." - ".$employe->NOM." ".$employe->PRENOM."\n\r";

                        }

                        else {
                            echo "non enregistrement ".$matricule."\n\r";
                        }
                    }

            //    }

            }
        }

        return ExitCode::OK;

    }

}