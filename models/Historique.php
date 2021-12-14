<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "HISTORIQUE".
 *
 * @property int $ID
 * @property string $LIBELLE
 * @property int $QUANTITE
 * @property string $FICHIER
 * @property int $TYPES
 */
class Historique extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'HISTORIQUE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LIBELLE', 'QUANTITE', 'FICHIER'], 'required'],
            [['QUANTITE','TYPES'], 'integer'],
            [['LIBELLE', 'FICHIER'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'LIBELLE' => 'Libelle',
            'QUANTITE' => 'Nombre de fichiers',
            'FICHIER' => 'Fichier',
            'TYPES' => 'Types'
        ];
    }

    public function getFile(){

        if(isset($_GET["id"])){

            $path = $this->FICHIER;

            if(!empty($path)) echo "<a href='../web/uploads/$path' target='_blank'>Fichier actuel Ici</a><br><br>";
        }

    }

    public function showFile(){

        $path = $this->FICHIER;

        if(!empty($path)) { return '../web/uploads/'.$path;   }

    }
}
