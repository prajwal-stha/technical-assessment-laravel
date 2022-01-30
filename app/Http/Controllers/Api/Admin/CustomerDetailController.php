<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerDetailRequest;
use App\Repositories\CustomerDetailRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @param string $guid
     * @return JsonResponse
     */
    public function deleteCustomerDetails(string $guid): JsonResponse
    {
        $deleteEducationDetail = $this->repository->deleteCustomerDetails($guid);
        if ($deleteEducationDetail['status']) {
            return response()->json($deleteEducationDetail, 200);
        } else {
            return response()->json($deleteEducationDetail, 422);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function bulkDeleteCustomerDetails(Request $request): JsonResponse
    {
        $deleteCustomerDetail = $this->repository->customerDetailsBulkDelete($request->get('guids'));
        if ($deleteCustomerDetail['status']) {
            return response()->json($deleteCustomerDetail, 200);
        } else {
            return response()->json($deleteCustomerDetail, 422);
        }
    }

    /**
     * @param string $guid
     * @return JsonResponse
     */
    public function restoreCustomerDetails(string $guid): JsonResponse
    {
        $restoreCustomerDetail = $this->repository->restoreCustomerDetail($guid);
        if ($restoreCustomerDetail['status']) {
            return response()->json($restoreCustomerDetail, 200);
        } else {
            return response()->json($restoreCustomerDetail, 422);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function bulkRestoreCustomerDetails(Request $request): JsonResponse
    {
        $restoreCustomerDetail = $this->repository->bulkRestoreCustomerDetails($request->get('guids'));
        if ($restoreCustomerDetail['status']) {
            return response()->json($restoreCustomerDetail, 200);
        } else {
            return response()->json($restoreCustomerDetail, 422);
        }
    }
}
