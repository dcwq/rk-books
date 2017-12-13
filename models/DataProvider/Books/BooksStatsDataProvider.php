<?php

namespace app\models\DataProvider\Books;

use app\components\Similarity;
use yii\data\ActiveDataProvider;
use yii\data\BaseDataProvider;

class BooksStatsDataProvider extends BaseDataProvider
{
    /**
     * @var ActiveDataProvider
     */
    private $baseDataProvider;

    /**
     * BooksStats constructor.
     * @param ActiveDataProvider $dataProvider
     */
    public function __construct(ActiveDataProvider $dataProvider)
    {
        $this->baseDataProvider = $dataProvider;
    }

    /**
     * Prepares the data models that will be made available in the current page.
     * @return array the available data models
     */
    protected function prepareModels()
    {
        $models = [];

        foreach ($this->baseDataProvider->getModels() as $model)
        {
            $models[] = new BookItem([
                'name' => $model->name,
                'book_date' => $model->book_date,
                'male_avg_age' => $model->male_avg_age ?? 0,
                'female_avg_age' => $model->female_avg_age ?? 0,
                'compatibility' => Similarity::getSimilarity($this->baseDataProvider->query->searchParams['name'], $model->name)
            ]);
        }

        //set default sort
        usort($models, function ($a, $b) {
            return $a->compatibility < $b->compatibility;
        });

        return $models;
    }

    /**
     * Prepares the keys associated with the currently available data models.
     * @param array $models the available data models
     * @return array the keys
     */
    protected function prepareKeys($models)
    {
        return array_keys($models);
    }

    /**
     * Returns a value indicating the total number of data models in this data provider.
     * @return int total number of data models in this data provider.
     */
    protected function prepareTotalCount()
    {
        return count($this->getModels());
    }

}
