<?php

namespace App\Filterable;

use App\Models\Product;

class ProductFilter extends Filterable
{

    public $queryTermKeys = [
        'published',
        'keyword',
        'cat_ids'
    ];

    /**
     * @param array $queryTerm
     * @return mixed
     */
    protected function modelQueryBuilder(array $queryTerm)
    {
        return
            Product::
            orderByRanking()
                ->status($queryTerm['published'])
                ->categories($queryTerm['cat_ids'])
                ->keyword($queryTerm['keyword']);
    }

    /**
     * @param array $queryTerm
     * @param null $qtyPerPage
     * @return mixed
     * @override
     */
    public function getList($queryTerm = [], $qtyPerPage = null)
    {
        $queryTerm = $this->organizeQueryTerm($queryTerm);

        return $this->modelQueryBuilder($queryTerm->toArray())
            ->paginate();
    }
}