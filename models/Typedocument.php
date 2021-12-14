<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "TYPEDOCUMENT".
 *
 * @property int $ID
 * @property string $LIBELLE
 */
class Typedocument extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TYPEDOCUMENT';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LIBELLE'], 'required'],
            [['LIBELLE'], 'string', 'max' => 100],
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
        ];
    }
}
