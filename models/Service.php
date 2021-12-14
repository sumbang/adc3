<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SERVICE".
 *
 * @property int $ID
 * @property string $LIBELLE
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SERVICE';
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
