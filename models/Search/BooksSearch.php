<?php

namespace app\models\Search;

use app\models\Books;
use app\models\Query\BooksQuery;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class BooksSearch extends ActiveRecord
{
    /**
     * Book name
     * @var
     */
    public $name;

    /**
     * Reviewers age
     * @var
     */
    public $age;

    /** @inheritdoc */
    public function rules()
    {
        return [
            'fieldsSafe' => [['name', 'age'], 'safe']
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $this->load($params, '');

        $booksQuery = new BooksQuery(Books::className());
        $booksQuery->searchParams = $params;

        $booksQuery->searchForStatistics();
        $booksQuery->searchByAge($params['age']);
        $booksQuery->searchByName($params['name']);

        if (!$booksQuery->count()) {

            $booksQuery = new BooksQuery(Books::className());
            $booksQuery->searchParams = $params;

            $booksQuery->searchForStatistics();
            $booksQuery->searchByAge($params['age']);
        }

        return new ActiveDataProvider([
            'query' => $booksQuery
        ]);
    }

}
