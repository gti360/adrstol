<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "main".
 *
 * @property integer $id_person
 * @property integer $id_lastname
 * @property integer $id_firstname
 * @property integer $id_midname
 * @property integer $bdate
 * @property integer $bmonth
 * @property integer $byear
 * @property integer $id_city
 * @property integer $id_district
 * @property integer $id_street
 * @property string $bld
 * @property string $flat
 */
class Main extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'main';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_person'], 'required'],
            [['id_person', 'id_lastname', 'id_firstname', 'id_midname', 'bdate', 'bmonth', 'byear', 'id_city', 'id_district', 'id_street'], 'integer'],
            [['bld'], 'string', 'max' => 10],
            [['flat'], 'string', 'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_person' => 'Id Person',
            'id_lastname' => 'Id Lastname',
            'id_firstname' => 'Id Firstname',
            'id_midname' => 'Id Midname',
            'bdate' => 'Bdate',
            'bmonth' => 'Bmonth',
            'byear' => 'Byear',
            'id_city' => 'Id City',
            'id_district' => 'Id District',
            'id_street' => 'Id Street',
            'bld' => 'Bld',
            'flat' => 'Flat',
        ];
    }

    public static function getMonthList()
    {
        return [
            '' => '',
            1 => Yii::t('app', 'Январь'),
            2 => Yii::t('app', 'Февраль'),
            3 => Yii::t('app', 'Март'),
            4 => Yii::t('app', 'Апрель'),
            5 => Yii::t('app', 'Май'),
            6 => Yii::t('app', 'Июнь'),
            7 => Yii::t('app', 'Июль'),
            8 => Yii::t('app', 'Август'),
            9 => Yii::t('app', 'Сентябрь'),
            10 => Yii::t('app', 'Октябрь'),
            11 => Yii::t('app', 'Ноябрь'),
            12 => Yii::t('app', 'Декабрь'),
        ];
    }

    public static function getDateList()
    {
        $list = ['' => ''];
        for($i = 1; $i <= 31; $i++) {
            $list[$i] = $i;
        }

        return $list;
    }
}
