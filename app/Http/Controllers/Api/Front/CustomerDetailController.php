<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerDetailRequest;
use App\Repositories\CustomerDetailRepository;
use Illuminate\Http\Request;

class CustomerDetailController extends Controller
{
    public $repo;

    public function __construct(CustomerDetailRepository $repo)
    {
        $this->repo = $repo;
    }

    public function store(CustomerDetailRequest $request): \Illuminate\Http\JsonResponse
    {
        $storeRequest = $this->repo->storeCustomerDetail($request->all());
        if ($storeRequest['status']) {
            return response()->json($storeRequest, 200);
        } else {
            return response()->json($storeRequest, 422);
        }
    }
}
