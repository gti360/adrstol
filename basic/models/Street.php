<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "street".
 *
 * @property integer $id_street
 * @property string $street
 */
class Street extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'street';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_street'], 'required'],
            [['id_street'], 'integer'],
            [['street'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_street' => 'Id Street',
            'street' => 'Street',
        ];
    }
}
