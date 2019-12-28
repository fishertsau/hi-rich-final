<?php


namespace App\Filterable;


/**
 * Interface FilterableInterface
 * @package Acme\Tool\Filterable
 */
interface FilterableInterface
{
    /**
     * @param array $queryTerm
     * @param $qtyPerPage
     * @return mixed
     */
    public function getList($queryTerm = []);
}