<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CONTRAT".
 *
 * @property string $CODECONT
 * @property string $LIBELLE
 *
 * @property EMPLOYE[] $eMPLOYEs
 */
class Contrat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contrat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CODECONT'], 'required'],
            [['CODECONT'], 'string', 'max' => 5],
            [['LIBELLE'], 'string', 'max' => 200],
            [['CODECONT'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CODECONT' => 'Codecont',
            'LIBELLE' => 'Libelle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEMPLOYEs()
    {
        return $this->hasMany(EMPLOYE::className(), ['CODECONT' => 'CODECONT']);
    }
}
