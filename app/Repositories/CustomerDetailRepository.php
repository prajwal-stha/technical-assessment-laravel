<?php


namespace App\Repositories;

use App\Models\CustomerDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CustomerDetailRepository
{
    public $model;

    public function __construct(CustomerDetail $model)
    {
        $this->model = $model;
    }

    public function storeCustomerDetail(array $params): array
    {
        DB::beginTransaction();
        try {
            $customerDetail = $this->model->create($this->formatParams($params));
            if (isset($params['education_details'])) {
                foreach ($params['education_details'] as $educationDetail) {
                    $customerDetail->education_details()->create($this->formatEducationDetailsParams($educationDetail));
                }
            }
            DB::commit();
            return [
                'status' => true,
                'message' => 'Your details have been stored.'
            ];
        } catch (\Exception $exception) {
            Log::error('Error while trying to store customer details: ' . $exception->getMessage());
            DB::rollBack();
            return [
                'status' => false,
                'message' => 'There was an error while trying to process your request. Please try again.'
            ];
        }
    }

    private function formatParams(array $params): array
    {
        return [
            'guid' => Str::uuid(),
            'name' => $params['name'],
            'gender' => $params['gender'],
            'phone' => $params['phone'],
            'email' => $params['email'],
            'date_of_birth' => $params['date_of_birth'],
            'address' => $params['address'],
            'nationality' => $params['nationality'],
            'preferred_contact_mode' => $params['preferred_contact_mode']
        ];
    }

    private function formatEducationDetailsParams(array $params): array
    {
        return [
            'education_type' => $params['education_type'],
            'institution_name' => $params['institution_name'],
            'institution_address' => $params['institution_address'],
            'grade' => $params['grade'],
            'start_date' => $params['start_date'],
            'end_date' => $params['end_date'],
            'current_status' => $params['current_status']
        ];
    }
}
