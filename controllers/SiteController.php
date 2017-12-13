<?php

namespace app\controllers;

use app\components\Stats;
use app\models\Books;
use app\models\BooksSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
use yii\grid\GridView;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', []);
    }

}
