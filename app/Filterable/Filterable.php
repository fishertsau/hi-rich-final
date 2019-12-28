<?php


namespace App\Filterable;


/**
 * Class Filterable
 */
abstract class Filterable implements FilterableInterface
{

    public $queryTermKeys = [];

    /**
     * @param array $queryTerm
     * @param $admin
     * @return mixed
     */
    abstract protected function modelQueryBuilder(array $queryTerm);

    /**
     * Filter constructor.
     */
    public function __construct()
    {
        $this->queryTermKeys = collect($this->queryTermKeys);
    }


    /**
     * @param $queryTerm
     * @return \Illuminate\Support\Collection
     */
    protected function organizeQueryTerm($queryTerm)
    {
        $queryTerm = collect($queryTerm);

        $this->queryTermKeys->each(function ($key) use (&$queryTerm) {
            if (!$queryTerm->has($key)) {
                $queryTerm[$key] = '';
            }
        });

        return $queryTerm;
    }

    /**
     * @param array $queryTerm
     * @param bool|false $qtyPerPage
     * @return mixed
     */
    public function getList($queryTerm = [], $qtyPerPage = null)
    {
        $queryTerm = $this->organizeQueryTerm($queryTerm);

        return $this->modelQueryBuilder($queryTerm->toArray())->paginate($qtyPerPage);
    }
}