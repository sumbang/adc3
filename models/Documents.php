<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "DOCUMENTS".
 *
 * @property int $ID
 * @property int $NATURE
 * @property string $LIBELLE
 * @property string $DOCUMENT
 * @property string $DATECREATION
 * @property int $IDUSER
 */
class Documents extends \yii\db\ActiveRecord
{
    public $fichier2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NATURE', 'IDUSER'], 'integer'],
            [['DATECREATION'], 'safe'],
            [['LIBELLE', 'DOCUMENT'], 'string', 'max' => 100],
            [['fichier2'], 'file', 'skipOnEmpty' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NATURE' => 'Nature',
            'LIBELLE' => 'Libellé',
            'DOCUMENT' => 'Document',
            'DATECREATION' => 'Date de création',
            'IDUSER' => 'Iduser',
        ];
    }


    public function getFichier(){

        $path = $this->DOCUMENT;

        if(!empty($path)) return "<a href='../web/uploads/$path' target='_blank'>Fichier actuel Ici</a><br><br>";

    }

    public function showImage(){

        $path = $this->DOCUMENT;

        if(!empty($path)) {return '../web/uploads/'.$path; }

    }
}
