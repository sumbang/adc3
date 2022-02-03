<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "NATURE".
 *
 * @property int $ID
 * @property string $LIBELLE
 */
class Nature extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nature';
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
