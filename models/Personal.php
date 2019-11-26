<?php
/**
 * For tritium_test.
 * User: ttt
 * Date: 25.11.2019
 * Time: 13:51
 */

namespace app\models;
use yii\db\ActiveRecord;

class Personal extends ActiveRecord {
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['ACTIVE', 'NAME', 'LAST_NAME', 'XML_ID', 'PERSONAL_GENDER', 'WORK_POSITION', 'Region', 'City'], 'string'],
            // email has to be a valid email address
            ['EMAIL', 'email'],
            [['PERSONAL_BIRTHDAY'], function ($attribute, $params) {
                if( $date = \DateTime::createFromFormat('d.m.Y', $this->{$attribute})){
                    $this->{$attribute} = $date->format('Y-m-d');
                }else{
                    $this->addError($attribute, 'Incorrect format');
                }
            }],
            // name, email, subject and body are required
            //[[], 'required'],
        ];
    }

    public function fields() {
        $json                  = parent::fields();
        $json[ 'countregions' ] = function () {
            return $this->countregions ? count( $this->countregions ) : 0;
        };

        return $json;
    }


    public function getCountregions()
    {
        return $this->hasMany(self::class, ['Region' => 'Region']);
    }
}