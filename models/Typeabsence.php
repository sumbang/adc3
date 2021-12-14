<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "TYPEABSENCE".
 *
 * @property string $CODEABS
 * @property string $LIBELLE
 *
 * @property ABSENCEPONCTUEL[] $aBSENCEPONCTUELs
 */
class Typeabsence extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TYPEABSENCE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CODEABS'], 'required'],
            [['CODEABS'], 'string', 'max' => 5],
            [['LIBELLE'], 'string', 'max' => 50],
            [['CODEABS'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CODEABS' => 'Code abscence',
            'LIBELLE' => 'Libellé',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getABSENCEPONCTUELs()
    {
        return $this->hasMany(ABSENCEPONCTUEL::className(), ['CODEABS' => 'CODEABS']);
    }
}
