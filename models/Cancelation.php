<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CANCELATION".
 *
 * @property int $ID
 * @property int $JOUISSANCE
 * @property string $DEBUT
 * @property int $PERIODE
 * @property string $COMMENTAIRE
 * @property string $FICHIER
 * @property int $IDUSER
 * @property string $DATECREATION
 * @property int $STATUT
 */
class Cancelation extends \yii\db\ActiveRecord
{
    public $DOCUMENTFILE;
    public $employe;
    public $decision;
    public $jouissances;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CANCELATION';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['JOUISSANCE', 'PERIODE', 'IDUSER','STATUT'], 'integer'],
            [['DEBUT', 'DATECREATION','employe','decision','jouissances'], 'safe'],
            [['COMMENTAIRE'], 'string'],
            [['FICHIER'], 'string', 'max' => 200],
            [['DOCUMENTFILE'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpeg,jpg,PNG,JPEG,JPG,pdf,PDF,doc,docx,DOC,DOCX'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'JOUISSANCE' => 'Jouissance',
            'DEBUT' => 'Date de suspension',
            'PERIODE' => 'Période de suspension (en jours)',
            'COMMENTAIRE' => 'Commentaire',
            'FICHIER' => 'Fichier',
            'IDUSER' => 'Iduser',
            'DATECREATION' => 'Datecreation',
            'DOCUMENT' => 'Document',
            'employe' => 'Employé',
            'decision' => 'Décision de congés',
            'jouissances' => 'Jouissance de congés'
        ];
    }

    public function getDOC(){

        $path = $this->FICHIER;

        if(!empty($path)) echo "<a href='../web/uploads/$path' target='_blank'>Fichier actuel Ici</a><br><br>";

    }

    public function showFile(){

        $path = $this->FICHIER;

        if(!empty($path)) { return '../web/uploads/'.$path;   }

    }

    public function getJouissance()
    {
        if($this->JOUISSANCE != null) {

            $type = \app\models\Jouissance::findOne($this->JOUISSANCE);

            if($type != null) return $type->NUMERO; else return "";
        }
        return "";
    }
}
