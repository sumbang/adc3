<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ARRET".
 *
 * @property int $ID_SUSPENSION
 * @property string $JOUISSANCE
 * @property string $DATEDEBUT
 * @property string $DATEFIN
 * @property string $STATUT
 * @property string $DATEEMIS
 * @property string $DATEVAL
 * @property string $DATEANN
 * @property string $COMMENTAIRE
 * @property string $DOCUMENT
 * @property int $IDUSER
 */
class Arret extends \yii\db\ActiveRecord
{
    public $DOCUMENTFILE;
    public $employe;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'arret';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['JOUISSANCE','DATEDEBUT'],'required'],
            [['DATEDEBUT', 'DATEFIN', 'DATEEMIS', 'DATEVAL', 'DATEANN','IDUSER','employe'], 'safe'],
            [['COMMENTAIRE'], 'string'],
            [['JOUISSANCE', 'DOCUMENT'], 'string', 'max' => 100],
            [['STATUT'], 'string', 'max' => 5],
            [['DOCUMENTFILE'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpeg,jpg,PNG,JPEG,JPG,pdf,PDF,doc,docx,DOC,DOCX'],
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_SUSPENSION' => 'Id  Suspension',
            'JOUISSANCE' => 'Jouissance',
            'DATEDEBUT' => 'Date de début',
            'DATEFIN' => 'Date de fin',
            'STATUT' => 'Statut',
            'DATEEMIS' => 'Date émis',
            'DATEVAL' => 'Date validation',
            'DATEANN' => 'Date annulation',
            'COMMENTAIRE' => 'Commentaire',
            'DOCUMENT' => 'Document',
            'employe' => 'Employé'
        ];
    }

    public function getDOC(){

        $path = $this->DOCUMENT;

        if(!empty($path)) echo "<a href='../web/uploads/$path' target='_blank'>Fichier actuel Ici</a><br><br>";

    }

    public function showFile(){

        $path = $this->DOCUMENT;

        if(!empty($path)) { return '../web/uploads/'.$path;   }

    }

    public function getStatut($statut){

        if($statut == "B") return "Brouillon";

        else if($statut == "A") return "Annulé";

        else if($statut == "V") return "Validé";
    }

}
