<?php

namespace App\Http\Controllers\Api\Admin;

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
     * @return JsonResponse
     */
    public function getAllCustomerDetails(): JsonResponse
    {
        return response()->json($this->repository->paginateCustomerDetails(request()->all()), 200);
    }

    /**
     * @param string $guid
     * @return JsonResponse
     */
    public function viewCustomerDetail(string $guid): JsonResponse
    {
        return response()->json($this->repository->findOrFail($guid));
    }

    /**
     * @param CustomerDetailRequest $request
     * @param string $guid
     * @return JsonResponse
     */
    public function updateCustomerDetail(CustomerDetailRequest $request, string $guid): JsonResponse
    {
        $updateCustomerDetail = $this->repository->updateCustomerDetails($request->all(), $guid);
        if ($updateCustomerDetail['status']) {
            return response()->json($updateCustomerDetail, 200);
        } else {
            return response()->json($updateCustomerDetail, 422);
        }
    }

    /**
     * @param string $guid
     * @return JsonResponse
     */
    public function deleteEducationDetails(string $guid): JsonResponse
    {
        $deleteEducationDetail = $this->repository->deleteEducationDetails($guid);
        if ($deleteEducationDetail['status']) {
            return response()->json($deleteEducationDetail, 200);
        } else {
            return response()->json($deleteEducationDetail, 422);
        }
    }

    /**
     * @param $guid
     * @return JsonResponse
     */
    public function deleteCustomerDetails($guid): JsonResponse
    {
        if (is_array($guid)) {
            $deleteCustomerDetail = $this->repository->customerDetailsBulkDelete($guid);
        } else {
            $deleteCustomerDetail = $this->repository->deleteCustomerDetails($guid);
        }
        if ($deleteCustomerDetail['status']) {
            return response()->json($deleteCustomerDetail, 200);
        } else {
            return response()->json($deleteCustomerDetail, 422);
        }
    }

    /**
     * @param $guid
     * @return JsonResponse
     */
    public function restoreCustomerDetails($guid): JsonResponse
    {
        if (is_array($guid)) {
            $restoreCustomerDetail = $this->repository->bulkRestoreCustomerDetails($guid);
        } else {
            $restoreCustomerDetail = $this->repository->restoreCustomerDetail($guid);
        }
        if ($restoreCustomerDetail['status']) {
            return response()->json($restoreCustomerDetail, 200);
        } else {
            return response()->json($restoreCustomerDetail, 422);
        }
    }
}
