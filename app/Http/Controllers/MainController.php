<?php

namespace App\Http\Controllers;


use App\Services\JsonResponseService;

/**
 * Class MainController
 * @package App\Http\Controllers
 */
class MainController extends Controller
{

    /**
     * @var JsonResponseService
     */
    protected $response;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->response = new JsonResponseService;
    }

}
