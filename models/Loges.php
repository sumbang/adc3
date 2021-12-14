<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "LOGES".
 *
 * @property int $ID
 * @property string $DATEOP
 * @property int $USERID
 * @property string $USERNAME
 * @property string $OPERATION
 */
class Loges extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'LOGES';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DATEOP'], 'safe'],
            [['USERID'], 'integer'],
            [['OPERATION'], 'string'],
            [['USERNAME'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'DATEOP' => 'Dateop',
            'USERID' => 'Userid',
            'USERNAME' => 'Username',
            'OPERATION' => 'Operation',
        ];
    }
}
