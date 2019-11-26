<?php
/**
 * For tritium_test.
 * User: ttt
 * Date: 25.11.2019
 * Time: 13:09
 */

namespace app\commands;

use app\models\Personal;
use ruskid\csvimporter\CSVImporter;
// use ruskid\csvimporter\CSVReader;
use ruskid\csvimporter\MultipleImportStrategy;
use yii\console\Controller;
use yii\console\ExitCode;

use Port\Csv\CsvReader;

class ImportController extends Controller {

    public function actionPersonal($fileName) {

        $reader = new CsvReader(new \SplFileObject($fileName),";");
        $reader->setHeaderRowNumber(0);

        $count = 0;
        foreach ($reader as $row) {

            $person = new Personal();
            if( $person->load( ['person' => $row ], 'person' ) && $person->save()){
                $count++;
            }elseif ($person->hasErrors()){
                $errorText = '';
                foreach ($person->getErrors() as $field => $errors){
                    $errorText .= "{$field}: " . implode(',', $errors);
                }

                throw new \Exception($errorText);
            }
        }

        echo "import {$count} row";
        return ExitCode::OK;
    }
}