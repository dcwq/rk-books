<?php

namespace app\models\DataProvider\Books;

use yii\base\Object;
use yii\data\ActiveDataProvider;
use yii\data\BaseDataProvider;

class BookItem extends Object
{
    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $book_date;

    /**
     * @var
     */
    public $male_avg_age;

    /**
     * @var
     */
    public $female_avg_age;

    /**
     * @var
     */
    public $compatibility;
}
