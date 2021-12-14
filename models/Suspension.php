<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SUSPENSION".
 *
 * @property int $ID_SUSPENSION
 * @property string $MATICULE
 * @property int $ANNEEEXIGIBLE
 * @property string $DATEDEBUT
 * @property string $DATEFIN
 * @property string $STATUT
 * @property string $DATEEMIS
 * @property string $DATEVAL
 * @property string $DATEANN
 * @property string $COMMENTAIRE
 * @property string $DOCUMENT
 * @property int $NATURE
 * @property string $DOCUMENT2
 * @property int $STATUTLEVE
 * @property string $DATELEVEE
 * @property int $IDUSER
 * @property int $DEJA
 */
class Suspension extends \yii\db\ActiveRecord
{
    public $DOCUMENTFILE;
    public $DOCUMENTFILE2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SUSPENSION';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ANNEEEXIGIBLE','NATURE','STATUTLEVE','DEJA'], 'integer'],
            [['ANNEEEXIGIBLE','MATICULE','NATURE'], 'required'],
            [['DATEDEBUT', 'DATEFIN', 'DATEEMIS', 'DATEVAL', 'DATEANN','COMMENTAIRE','DOCUMENT','DOCUMENT2','DATELEVEE','IDUSER'], 'safe'],
            [['MATICULE'], 'string', 'max' => 10],
            [['STATUT'], 'string', 'max' => 5],
            [['DOCUMENTFILE','DOCUMENTFILE2'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpeg,jpg,PNG,JPEG,JPG,pdf,PDF,doc,docx,DOC,DOCX'],
        
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_SUSPENSION' => 'Id  Suspension',
            'MATICULE' => 'Matricule',
            'ANNEEEXIGIBLE' => 'Annee exigible',
            'DATEDEBUT' => 'Date de debut',
            'DATEFIN' => 'Date de fin',
            'STATUT' => 'Statut',
            'DATEEMIS' => 'Dateemis',
            'DATEVAL' => 'Dateval',
            'DATEANN' => 'Dateann',
            'COMMENTAIRE' => 'Commentaire',
            'DOCUMENT' => 'Attestion de suspension',
            'DOCUMENT2' => 'Attestion de levee de suspension',
            'DOCUMENTFILE' => 'Attestion de suspension',
            'DOCUMENTFILE2' => 'Attestion de levee de suspension',
            'NATURE' => 'Nature de la suspension'
        ];
    }

    public function getDOC(){

        $path = $this->DOCUMENT;

        if(!empty($path)) echo "<a href='../web/uploads/$path' target='_blank'>Fichier actuel Ici</a><br><br>";

    }

    public function getDOC2(){

        $path = $this->DOCUMENT2;

        if(!empty($path)) echo "<a href='../web/uploads/$path' target='_blank'>Fichier actuel Ici</a><br><br>";

    }

    public function showFile(){

        $path = $this->DOCUMENT;

        if(!empty($path)) { return '../web/uploads/'.$path;   }

    }

    public function showFile2(){

        $path = $this->DOCUMENT2;

        if(!empty($path)) { return '../web/uploads/'.$path;   }

    }

    public function getStatut($statut){

        if($statut == "B") return "Brouillon";

        else if($statut == "A") return "Annulé";

        else if($statut == "V") return "Validé";

        else if($statut == "L") return "Levé";
    }

    public function getStatut2($statut){

        if($statut == 0) return "Aucun statut";

        else if($statut == 1) return "Suspension en cours";

        else if($statut == 2) return "Suspension levee";
    }

    public function getNature($nat){

       $nature = \app\models\Nature::findOne($nat);

       if($nature != null) return $nature->LIBELLE;

       else return "";
    }
}
