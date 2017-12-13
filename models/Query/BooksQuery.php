<?php

namespace app\models\Query;

use app\models\Reviews;

/**
 * This is the ActiveQuery class for [[Books]].
 *
 * @see Books
 */
class BooksQuery extends \yii\db\ActiveQuery
{
    /**
     * @var
     */
    public $searchParams;

    /**
     * @param $params
     * @return $this
     */
    public function searchForStatistics()
    {
        $this->addSelect([
            "books.id",
            "books.name",
            'books.book_date',
            'reviews.age',
            'male_avg_age',
            'female_avg_age'
        ])
            ->from(["books"])
            ->leftJoin('reviews', 'reviews.book_id = books.id')
            ->groupBy(['books.id']);

        //join sex avg queries
        $this->joinSexAvgQueries();

        return $this;
    }

    public function searchByName($name)
    {
        $this->andFilterWhere(['or', ['like', 'name', $name],]);
    }

    public function searchByAge($age)
    {
        $this->andWhere($age);
    }

    /**
     * Join sex AVG queries
     */
    private function joinSexAvgQueries()
    {
        $sexQueryMale = new ReviewsQuery(Reviews::className());
        $sexQueryMale->getSexAvgQuery(Reviews::SEX_MALE, 'male_avg_age');

        $this->leftJoin(['male_avg_age' => $sexQueryMale], 'male_avg_age.book_id = books.id');

        $sexQueryFemale = new ReviewsQuery(Reviews::className());
        $sexQueryFemale->getSexAvgQuery(Reviews::SEX_FEMALE, 'female_avg_age');

        $this->leftJoin(['female_avg_age' => $sexQueryFemale], 'female_avg_age.book_id = books.id');
    }

}
