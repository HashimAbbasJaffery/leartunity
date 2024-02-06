<?php 

namespace App\Classes;


class Pagination {
    protected $array;
    protected $per_page;
    protected $request;
    protected $current_page;
    protected $path;
    protected $query;
    public function __construct(
        $array,
        $request,
        $per_page = 5,
    ) {
        $this->array = $array;
        $this->request = $request;
        $this->per_page = $per_page;
    }
    public function manualPaginate() {
        $request = $this->request;
        $pagination = pagination($this->array, [
            "per_page" => $this->per_page,
            "current_page" => $request->page,
            "path" => $request->path(),
            "query" => $request->query()
        ]);

        return $pagination;
    }
}