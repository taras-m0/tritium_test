<?php
/**
 * For tritium_test.
 * User: ttt
 * Date: 25.11.2019
 * Time: 22:12
 */

namespace app\models;
use yii\base\Model;

class CsvfileForm extends Model {
    public $csv;

    public function rules() {
        return [
            ['csv', 'file']
        ];
    }
}