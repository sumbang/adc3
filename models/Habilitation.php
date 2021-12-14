<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Habilitation".
 *
 * @property int $ID
 * @property string $CODEMENU
 * @property string $CODEROLE
 * @property int $ACREATE
 * @property int $AREAD
 * @property int $AUPDATE
 * @property int $ADELETE
 */
class Habilitation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'HABILITATION';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CODEMENU', 'CODEROLE', 'ACREATE', 'AREAD', 'AUPDATE', 'ADELETE'], 'required'],
            [['ACREATE', 'AREAD', 'AUPDATE', 'ADELETE'], 'integer'],
            [['CODEMENU', 'CODEROLE'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CODEMENU' => 'Menu',
            'CODEROLE' => 'Role',
            'ACREATE' => 'Création',
            'AREAD' => 'Lecture',
            'AUPDATE' => 'Modification',
            'ADELETE' => 'Suppression',
        ];
    }

    public function getRole(){

        $current = Roles::findOne($this->CODEROLE);

        if($current == null) return "";

        else return $current->LIBELLE;
    }

    public function getMenu(){

        $current = Menus::findOne($this->CODEMENU);

        if($current == null) return "";

        else return $current->LIBELLE;
    }
}
