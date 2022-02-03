<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "DIRECTION".
 *
 * @property int $ID
 * @property string $LIBELLE
 */
class Direction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'direction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LIBELLE'], 'required'],
            [['LIBELLE'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'LIBELLE' => 'Libelle',
        ];
    }
}
