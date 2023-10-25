<?php

namespace App\Services;

use Illuminate\Http\Request;

interface BaseService
{
    /**
     * @return mixed
     */
    public function all();

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request);

    /**
     * @param $id
     * @return mixed
     */
    public function deleteById($id);

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param null $searchBy
     * @param null $searchParam
     * @param int $limit
     * @param array|string[] $columns
     * @param string $pageName
     * @param null $page
     * @return mixed
     */
    public function paginate(Request $request);

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function updateById($id, Request $request);
}
