<?php

namespace app\components;

use app\models\DataProvider\Books\BooksStatsDataProvider;
use app\models\Search\BooksSearch;
use yii\base\Component;

class Stats extends Component
{
    /**
     * @param $params
     * @return string
     */
    public static function show_statistics(string $params)
    {
        $params = self::parseParams($params);

        $booksSearch = \Yii::createObject(BooksSearch::className());
        $booksStatsDataProvider = \Yii::createObject(BooksStatsDataProvider::className(), [$booksSearch->search($params)]);

        return \yii\grid\GridView::widget([
            'dataProvider' => $booksStatsDataProvider,
            'columns' => [
                'name',
                [
                    'attribute' => 'compatibility',
                    'value' => function($model) {
                        return number_format($model->compatibility, 2) . ' %';
                    },
                ],
                'book_date',
                [
                    'attribute' => 'female_avg_age',
                    'format' => ['decimal', 2]
                ],
                [
                    'attribute' => 'male_avg_age',
                    'format' => ['decimal', 2]
                ]
            ]
        ]);
    }

    /**
     * @param $params
     * @return array
     */
    private static function parseParams(string $params)
    {
        $splittedParams = explode('|', $params);

        return [
            'name' => $splittedParams[0] ?? null,
            'age' => $splittedParams[1] ?? null
        ];
    }
}
