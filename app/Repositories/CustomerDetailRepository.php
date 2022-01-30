<?php


namespace App\Repositories;

use App\Models\CustomerDetail;
use App\Models\EducationDetail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use function PHPUnit\Framework\throwException;

class CustomerDetailRepository
{
    public $model;
    public $education;

    public function __construct(CustomerDetail $model, EducationDetail $education)
    {
        $this->model = $model;
        $this->education = $education;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function paginateCustomerDetails(array $params)
    {
        $sort_by = $params['sort_by'] ?? 'updated_at';
        $order = $params['order'] ?? 'desc';
        $page_length = $params['page_length'] ?? 15;
        $name = $params['name'] ?? null;
        $email = $params['email'] ?? null;
        $address = $params['address'] ?? null;
        $phone = $params['phone'] ?? null;
        $nationality = $params['nationality'] ?? null;
        $preferred_contact_mode = $params['preferred_contact_mode'] ?? null;
        $created_at_start_date = $params['created_at_start_date'] ?? null;
        $created_at_end_date = $params['created_at_end_date'] ?? null;
        $trashedRequests = $params['trashed'] == 'true' ? true : false;
        $query = $this->model->query();
        if ($trashedRequests) {
            $query = $this->model->onlyTrashed();
        }
        $query = $query->filterByName($name)
            ->filterByEmail($email)
            ->filterByPhone($phone)
            ->filterByAddress($address)
            ->filterByNationality($nationality)
            ->filterByPreferredContactMode($preferred_contact_mode)
            ->createdAtDateBetween([
                'start_date' => $created_at_start_date,
                'end_date' => $created_at_end_date,
            ]);

        $query->orderBy($sort_by, $order);
        return $page_length == "0" ? $query->paginate($query->count()) : $query->paginate($page_length);
    }

    /**
     * @param array $params
     * @return array
     */
    public function storeCustomerDetail(array $params): array
    {
        DB::beginTransaction();
        try {
            $customerDetail = $this->model->create($this->formatParams($params, 'create'));
            if (isset($params['education_details'])) {
                foreach ($params['education_details'] as $educationDetail) {
                    $customerDetail->education_details()->create($this->formatEducationDetailsParams($educationDetail, 'create'));
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

    /**
     * @param array $params
     * @param string $type
     * @return array
     */
    private function formatParams(array $params, string $type): array
    {
        $params = [
            'name' => $params['name'],
            'gender' => $params['gender'],
            'phone' => $params['phone'],
            'email' => $params['email'],
            'date_of_birth' => $params['date_of_birth'],
            'address' => $params['address'],
            'nationality' => $params['nationality'],
            'preferred_contact_mode' => $params['preferred_contact_mode']
        ];
        if ($type == 'create') {
            $params['guid'] = Str::uuid();
        }
        return $params;
    }

    /**
     * @param array $params
     * @param string $type
     * @return array
     */
    private function formatEducationDetailsParams(array $params, string $type): array
    {
        $format = [
            'education_type' => $params['education_type'],
            'institution_name' => $params['institution_name'],
            'institution_address' => $params['institution_address'],
            'start_date' => $params['start_date'],
            'current_status' => $params['current_status']
        ];
        if ($params['current_status'] == "Completed") {
            $format['end_date'] = $params['end_date'];
            $format['grade'] = $params['grade'];

        }
        if ($type == 'create') {
            $format['guid'] = Str::uuid();
        }
        return $format;
    }

    /**
     * @param string $guid
     * @return array
     */
    public function getCustomerDetail(string $guid): array
    {
        $customerDetail = $this->model->query()->where('guid', $guid)->with('education_details')->first();
        if ($customerDetail) {
            return [
                'status' => true,
                'customerDetails' => $customerDetail
            ];
        } else {
            return [
                'status' => false,
                'message' => 'The record you were trying to look for does not exist'
            ];
        }
    }

    /**
     * @param array $params
     * @param string $guid
     * @return array
     */
    public function updateCustomerDetails(array $params, string $guid): array
    {
        $customerDetail = $this->findOrFail($guid);
        DB::beginTransaction();
        try {
            $customerDetail->update($this->formatParams($params, 'update'));
            foreach ($params['education_details'] as $education_detail) {
                if (isset($education_detail['guid'])) {
                    $education = $this->education->query()->where('guid', $education_detail['guid'])->first();
                    if ($education) {
                        $education->update($this->formatEducationDetailsParams($education_detail, 'update'));
                    }
                } else {
                    $customerDetail->education_details()->create($this->formatEducationDetailsParams($education_detail, 'create'));
                }
            }
            DB::commit();
            return [
                'status' => true,
                'message' => 'Customer details have been updated.'
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Error while updating Customer Details: ' . $exception->getMessage());
            return [
                'status' => false,
                'message' => 'There was an error while trying to update the customers details. Please try again.'
            ];
        }
    }

    /**
     * @param string $guid
     * @return Builder|Model|object|null
     */
    public function findOrFail(string $guid)
    {
        $customerDetail = $this->model->query()->where('guid', $guid)->with('education_details')->first();

        if (!$customerDetail) {
            throw ValidationException::withMessages(['message' => 'The record you are looking for does not exist']);
        }

        return $customerDetail;
    }

    /**
     * @param string $guid
     * @return array
     */
    public function deleteEducationDetails(string $guid): array
    {
        DB::beginTransaction();
        try {
            $educationDetail = $this->education->query()->where('guid', $guid)->first();
            if ($educationDetail) {
                $educationDetail->delete();
                DB::commit();
                return [
                    'status' => true,
                    'message' => 'The education detail has been deleted.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'The record you are looking for does not exist'
                ];
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Error while trying to delete education details: ' . $exception->getMessage());
            return [
                'status' => false,
                'message' => 'There was an error while trying to delete the education details. Please try again.'
            ];
        }
    }

    /**
     * @param string $guid
     * @return array
     */
    public function deleteCustomerDetails(string $guid): array
    {
        DB::beginTransaction();
        try {
            $educationDetail = $this->model->query()->where('guid', $guid)->first();
            if ($educationDetail) {
                $educationDetail->delete();
                DB::commit();
                return [
                    'status' => true,
                    'message' => 'The customer detail has been deleted.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'The record you are looking for does not exist'
                ];
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Error while trying to delete customer details: ' . $exception->getMessage());
            return [
                'status' => false,
                'message' => 'There was an error while trying to delete the customer details. Please try again.'
            ];
        }
    }

    /**
     * @param array $guids
     * @return array
     */
    public function customerDetailsBulkDelete(array $guids): array
    {
        DB::beginTransaction();
        try {
            $this->model->query()->whereIn('guid', $guids)->delete();
            DB::commit();
            return [
                'status' => true,
                'message' => 'The selected Customer Details have been deleted.'
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Error while trying to bulk delete customer details: ' . $exception->getMessage());
            return [
                'status' => false,
                'message' => 'Error while trying to delete the customer details'
            ];
        }
    }

    /**
     * @param string $guid
     * @return array
     */
    public function restoreCustomerDetail(string $guid): array
    {
        DB::beginTransaction();
        try {
            $customerDetail = $this->model->onlyTrashed()->where('guid', $guid)->restore();
            DB::commit();
            return [
                'status' => true,
                'message' => 'Customer details have been restored.'
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Error while trying to restore Customer Details: ' . $exception->getMessage());
            return [
                'status' => true,
                'message' => 'There was an error while trying to restore Customer Details.'
            ];
        }
    }

    /**
     * @param array $guids
     * @return array
     */
    public function bulkRestoreCustomerDetails(array $guids): array
    {
        DB::beginTransaction();
        try {
            $customerDetail = $this->model->onlyTrashed()->whereIn('guid', $guids)->restore();
            DB::commit();
            return [
                'status' => true,
                'message' => 'The selected customer details have been restored.'
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Error while trying to bulk restore Customer Details: ' . $exception->getMessage());
            return [
                'status' => true,
                'message' => 'There was an error while trying to restore the selected customer Details.'
            ];
        }
    }

}
