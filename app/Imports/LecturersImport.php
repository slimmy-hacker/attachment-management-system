<?php
namespace App\Imports;

use App\Models\AdministrativeUnit;
use App\Models\User;
use App\Models\Lecturer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class LecturersImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use Importable, SkipsFailures;
    public $successCount = 0;
    public $failedRecords = [];
    public function model(array $row)
    {
        try {
            // Validate the row
            $validator = Validator::make($row, [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'phone_number' => 'nullable|unique:users,phone_number',
                'staff_number' => 'required',
                'department_code' => [
                    'required',
                    Rule::exists('administrative_units', 'code')->where('level', 2),
                ],

                'office_location' => 'nullable|string',
            ]);

            if ($validator->fails()) {

                // Collect all validation error messages
                $this->failedRecords[] = [
                    'reason' => implode(" | ", $validator->errors()->all())
                ];

                return null;
            }

            // DB transaction for safe saving
            return DB::transaction(function () use ($row) {

                $staff_no = Str::upper(trim($row['staff_number']));
                $email = Str::lower(trim($row['email']));
                $department_code = Str::lower(trim($row['department_code']));

                // Create or update the user
                $user = User::Create([
                        'email' => $email,
                        'name' => $row['name'],
                        'phone_number' => $row['phone_number'],
                        'password' => bcrypt($staff_no),
                        'role' => 'lecturer',
                    ]);
                $department = AdministrativeUnit::where('code', $department_code)
                                ->where('level',2)
                                ->first();
                if(!$department){
                    $this->failedRecords[] = [
                        'reason' => 'Department Not Found'
                    ];
                    return null;
                }
                Lecturer::create([
                        'user_id' => $user->id,
                        'staff_number' => $staff_no,
                        'department_id' => $department->id ?? '',
                        'office_location' => $row['office_location'] ?? null,
                        'office_phone' => $row['phone_number'] ?? null,
                    ]);


                $this->successCount++;

                return $user;
            });

        } catch (\Exception $e) {

            $this->failedRecords[] = [
                'reason' => $e->getMessage()
            ];

            return null;
        }
    }
}
