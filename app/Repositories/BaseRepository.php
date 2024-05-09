<?php

namespace App\Repositories;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseRepository {

    public QueryBuilder $filter;

    public function __construct()
    {
        $filter = QueryBuilder::for($this->setModel());

        if (count($this->filterAvailable()) > 0){
            $filter = $filter->allowedFilters($this->filterAvailable());
        }

        if (count($this->sortAvailable()) > 0){
            $filter = $filter->allowedSorts($this->sortAvailable());
        }

        if (count($this->includesAvailable()) > 0){
            $filter = $filter->allowedIncludes($this->includesAvailable());
        }

        $this->filter = $filter;
    }

    public function get (){
        return $this->filter->get();
    }

    public function first(){
        return $this->filter->first();
    }

    public function paginate()
    {
       return $this->filter->paginate();
    }

    public function find($id)
    {
        return $this->filter->find($id);
    }

    abstract function setModel(): string;

    abstract function filterAvailable(): array;

    abstract function sortAvailable(): array;

    abstract function includesAvailable(): array;

}
