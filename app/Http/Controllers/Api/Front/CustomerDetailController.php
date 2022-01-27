<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerDetailRequest;
use App\Repositories\CustomerDetailRepository;
use Illuminate\Http\JsonResponse;

class CustomerDetailController extends Controller
{
    public $repository;

    public function __construct(CustomerDetailRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CustomerDetailRequest $request
     * @return JsonResponse
     */
    public function store(CustomerDetailRequest $request): JsonResponse
    {
        $storeRequest = $this->repository->storeCustomerDetail($request->all());
        if ($storeRequest['status']) {
            return response()->json($storeRequest, 200);
        } else {
            return response()->json($storeRequest, 422);
        }
    }
}
