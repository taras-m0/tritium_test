<?php

namespace app\controllers;

use app\models\CsvfileForm;
use app\models\Personal;
use Port\Csv\CsvReader;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $form = new CsvfileForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            if($file = \yii\web\UploadedFile::getInstance($form, 'csv')) {

                $reader = new CsvReader(new \SplFileObject($file->tempName),";");
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

                Yii::$app->session->setFlash('success', "Success {$count} rows!");
            }

            return $this->redirect(['site/index']);
        }

        return $this->render('index', [ 'model' => $form ]);
    }

    public function actionPersonal(){
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        $query = Personal::find();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ],
        ]);

        $personals = $provider->getModels();

        return $personals;
        return  array_map(function ($item){
            return $item->toArray();
        }, $personals );
    }
}
