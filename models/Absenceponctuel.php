<?php

namespace app\models;

use Yii;
use app\models\Employe;
use app\models\Exercice;
use app\models\Typeabsence;

/**
 * This is the model class for table "ABSENCEPONCTUEL".
 *
 * @property int $ID_ABSENCE
 * @property string $CODEABS
 * @property string $MATICULE
 * @property int $ANNEEEXIGIBLE
 * @property string $DATEDEBUT
 * @property string $DATEFIN
 * @property string $STATUT
 * @property int $IMPUTERCONGES
 * @property string $DATEEMIS
 * @property string $DATEVAL
 * @property string $DATEANN
 * @property string $COMMENTAIRE
 * @property string $DOCUMENT
 * @property int $IDUSER
 * @property int $TYPE_DEMANDE
 * @property int $DUREE
 * @property int $DEJA
 *
 * @property EMPLOYE $mATICULE
 * @property EXERCICE $aNNEEEXIGIBLE
 * @property TYPEABSENCE $cODEABS
 */
class Absenceponctuel extends \yii\db\ActiveRecord
{
    public $DOCUMENTFILE;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ABSENCEPONCTUEL';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ANNEEEXIGIBLE','DUREE','DEJA'], 'integer'],
            [['DATEDEBUT', 'DATEFIN', 'DATEEMIS', 'DATEVAL', 'DATEANN','IDUSER','DUREE','TYPE_DEMANDE'], 'safe'],
            [['CODEABS', 'STATUT'], 'string', 'max' => 5],
            [['ANNEEEXIGIBLE','MATICULE','CODEABS','STATUT','TYPE_DEMANDE'], 'required','on'=>['create','update']],
            [['ANNEEEXIGIBLE'], 'required','on'=>'export'],
            [['MATICULE'], 'string', 'max' => 10],
            [['DOCUMENTFILE'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpeg,jpg,PNG,JPEG,JPG,pdf,PDF,doc,docx,DOC,DOCX'],
            [['IMPUTERCONGES'], 'string', 'max' => 1],
            [['MATICULE'], 'exist', 'skipOnError' => true, 'targetClass' => Employe::className(), 'targetAttribute' => ['MATRICULE' => 'MATRICULE']],
            [['ANNEEEXIGIBLE'], 'exist', 'skipOnError' => true, 'targetClass' => Exercice::className(), 'targetAttribute' => ['ANNEEEXIGIBLE' => 'ANNEEEXIGIBLE']],
            [['CODEABS'], 'exist', 'skipOnError' => true, 'targetClass' => Typeabsence::className(), 'targetAttribute' => ['CODEABS' => 'CODEABS']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_ABSENCE' => 'Id  Absence',
            'CODEABS' => 'Code absence',
            'MATICULE' => 'Employé',
            'ANNEEEXIGIBLE' => 'Exercice',
            'DATEDEBUT' => 'Date de début',
            'DATEFIN' => 'Date de fin',
            'STATUT' => 'Statut',
            'IMPUTERCONGES' => 'Imputer sur les congés',
            'DATEEMIS' => 'Date émission',
            'DATEVAL' => 'Date validation',
            'DATEANN' => 'Date annulation',
            'COMMENTAIRE' => 'Commentaire',
            'DOCUMENT' => 'Document',
            'DUREE'=>'Durée de la permission'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMATICULE()
    {
        return $this->hasOne(EMPLOYE::className(), ['MATICULE' => 'MATICULE']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getANNEEEXIGIBLE()
    {
        return $this->hasOne(EXERCICE::className(), ['ANNEEEXIGIBLE' => 'ANNEEEXIGIBLE']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCODEABS()
    {
        return $this->hasOne(TYPEABSENCE::className(), ['CODEABS' => 'CODEABS']);
    }

    public function getStatut(){

        if($this->STATUT == "E") return "EMIS";

        else if($this->STATUT == "A") return "ANNULER";

        else if($this->STATUT == "V") return "VALIDER";

    }

    public function getTypeDemande(){

        if($this->TYPE_DEMANDE == 0) return "Jour";

        else if($this->TYPE_DEMANDE == 1) return "Heure";

    }

    public function getGenre(){

        return $this->IMPUTERCONGES==1?'Oui':'Non';
    }

    public function getType()
    {
        if($this->CODEABS != null) {

            $type = Typeabsence::findOne($this->CODEABS);

            if($type != null) return $type->LIBELLE; else return "";
        }
        return "";
    }

    public function getAnnee()
    {
        if($this->ANNEEEXIGIBLE != null) {

            $type = Exercice::findOne($this->ANNEEEXIGIBLE);

            if($type != null) return $type->ANNEEEXIGIBLE; else return "";
        }
        return "";
    }

    public function getEmploi()
    {
        if($this->MATICULE != null) {

            $type = Employe::findOne($this->MATICULE);

            if($type != null) return $type->getfullname(); else return "";
        }
        return "";
    }
    
    public function getDOC(){

        $path = $this->DOCUMENT;

        if(!empty($path)) echo "<a href='../web/uploads/$path' target='_blank'>-> Document lié</a><br><br>";

    }

    public function showFile(){

        $path = $this->DOCUMENT;

        if(!empty($path)) { return '../web/uploads/'.$path;   }

    }
}
