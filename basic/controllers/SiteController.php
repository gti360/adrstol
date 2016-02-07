<?php

namespace app\controllers;


use app\models\City;
use app\models\Firstname;
use app\models\Lastname;
use app\models\Main;
use app\models\Midname;
use app\models\Street;
use Yii;
use yii\db\Query;
use yii\debug\models\search\Mail;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\District;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\FindForm;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\web\UrlManager;

class SiteController extends Controller
{
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSay($message = "")
    {
        return $this->render('say', ['message' => $message]);
    }

    public function actionFind()
    {

        $searchForm = new FindForm();

        $view['districtList'] = ArrayHelper::map(
            District::find()->where("district != ''")->orderBy('district')->all(), 'id_district', 'district');

        $params = ArrayHelper::merge(Yii::$app->request->getQueryParams(), Yii::$app->request->post());
        $searchForm->load($params);

        if(implode('', $searchForm->toArray())) {
            //$view['list'] = $searchForm->search();
        } else {
            $amount = (integer) ArrayHelper::getValue(Main::findBySql("select count(id_person) as amount from main")->asArray()->one(), 'amount');
        }

        $view['pagination'] =  new Pagination(
            [
                'pageSize'=>10,
            ]
        );

        //dd($amount);

        $dataProvider = new ActiveDataProvider([
            'query' => $searchForm->getSearchQuery(),
            'totalCount' => $amount ? $amount : null,
            'pagination' => $view['pagination']
        ]);

        //dd($dataProvider);

        $view['dataProvider'] = $dataProvider;


        $view['searchForm'] = $searchForm;

        return $this->render('find', $view);
    }

    public function actionAjaxSearch ()
    {
        if(Yii::$app->request->getIsAjax()) {
            $params = Yii::$app->request->getQueryParams();

            $list = [];

            switch($params['t']) {
                case "lastname":
                    $list = ArrayHelper::getColumn(
                        Lastname::find()->where(['like', 'lastname', $params['term'] . "%", false])
                        ->limit(100)->asArray()->all(), 'lastname');
                    break;
                case "firstname":
                    $list = ArrayHelper::getColumn(
                        Firstname::find()->where(['like', 'firstname', $params['term'] . "%", false])
                        ->limit(100)->asArray()->all(), 'firstname');
                    break;
                case "midname":
                    $list = ArrayHelper::getColumn(
                        Midname::find()->where(['like', 'midname', $params['term'] . "%", false])
                        ->limit(100)->asArray()->all(), 'midname');
                    break;
                case "city":
                    $list = ArrayHelper::getColumn(
                        City::find()->where(['like', 'city', $params['term']])
                        ->limit(100)->asArray()->all(), 'city');
                    break;
                case "street":
                    $list = ArrayHelper::getColumn(
                        Street::find()->where(['like', 'street', $params['term']])
                        ->limit(100)->asArray()->all(), 'street');
                    break;
            }

            return $this->renderAjax('ajax-search', ['list' => $list]);
        } else {
            throw new NotFoundHttpException('');
        }
    }
}
