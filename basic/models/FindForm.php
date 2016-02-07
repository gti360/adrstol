<?php
/**
 * Created by PhpStorm.
 * User: gti
 * Date: 02.02.16
 * Time: 21:15
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

class FindForm extends Model
{
    public $firstname;
    public $lastname;
    public $midname;
    public $byear;
    public $bmonth;
    public $bdate;
    public $district;
    public $city;
    public $street;
    public $bld;
    public $flat;

    public function rules ()
    {
        return [
            ['byear', 'number', 'min' => 1850, 'max'=>9999]
        ];
    }

    public function scenarios ()
    {
        return [
            'default' => [
                'firstname', 'lastname', 'midname', 'byear', 'bmonth', 'bdate',
                'district', 'city', 'street', 'bld', 'flat'
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'firstname' =>\Yii::t('app', 'Имя'),
            'lastname' =>\Yii::t('app', 'Фамилия'),
            'midname' =>\Yii::t('app', 'Отчество'),
            'byear' =>\Yii::t('app', 'Год'),
            'bmonth' =>\Yii::t('app', 'Месяц'),
            'bdate' =>\Yii::t('app', 'День'),
            'district' =>\Yii::t('app', 'Район'),
            'city' =>\Yii::t('app', 'Город'),
            'street' =>\Yii::t('app', 'Улица'),
            'bld' =>\Yii::t('app', 'Дом'),
            'flat' =>\Yii::t('app', 'Кв.')
        ];
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Query
     */
    public function getSearchQuery ()
    {
        $query = (new Query())->select(['ln.lastname', 'fn.firstname', 'mn.midname', 'm.byear', 'm.bmonth',
            'm.bdate', 'd.district', 'ct.city', 's.street', 'm.bld', 'm.flat'])->
        from(['m' => 'main']);

        $query->innerJoin('firstname AS fn', 'm.id_firstname = fn.id_firstname');
        $query->innerJoin('lastname AS ln', 'm.id_lastname = ln.id_lastname');
        $query->innerJoin('midname AS mn', 'm.id_midname = mn.id_midname');
        $query->innerJoin('city AS ct', 'm.id_city = ct.id_city');
        $query->innerJoin('district AS d', 'm.id_district = d.id_district');
        $query->innerJoin('street AS s', 'm.id_street = s.id_street');

        if($this->lastname) {
            $query->andFilterWhere(['like', 'ln.lastname', $this->lastname . "%", false]);
        }

        if($this->firstname) {
            $query->andFilterWhere(['like', 'fn.firstname', $this->firstname . "%", false]);
        }

        if($this->midname) {
            $query->andFilterWhere(['like', 'mn.midname', $this->midname . "%", false]);
        }

        $query->andFilterWhere(['like', 'ct.city', $this->city])->
        andFilterWhere(['like', 's.street', $this->street])->
        andFilterWhere(['m.id_district' => $this->district])->
        andFilterWhere(['m.byear' => $this->byear])->
        andFilterWhere(['m.bmonth' => $this->bmonth])->
        andFilterWhere(['m.bdate' => $this->bdate])->
        andFilterWhere(['m.bld' => $this->bld])->
        andFilterWhere(['m.flat' => $this->flat]);

        return $query;
    }

    public function search ($limit = 20, $offset =0)
    {
        return $this->getSearchQuery()->limit($limit)->offset($offset)->all();
    }

}