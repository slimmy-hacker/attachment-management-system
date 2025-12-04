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
                'phone_number' => 'nullable|string',
                'staff_number' => 'required|string',
                'department_code' => [
                    'required',
                    'string',
                    Rule::exists('locations', 'code')->where('level', 2),
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
                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $row['name'],
                        'phone_number' => $row['phone_number'],
                        'password' => Hash::make($staff_no),
                        'role' => 'lecturer',
                    ]
                );
                $department = AdministrativeUnit::where('code', $department_code)
                                ->where('level',2)
                                ->first();
                // Create or update lecturer
                Lecturer::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'staff_number' => $staff_no,
                        'department_id' => $department->id ?? '',
                        'office_location' => $row['office_location'] ?? null,
                        'office_phone' => $row['phone_number'] ?? null,
                    ]
                );

                // Count successful rows
                $this->successCount++;

                return $user;
            });

        } catch (\Exception $e) {

            // Handle DB errors like Unique constraint: users.email
            $this->failedRecords[] = [
                'reason' => $e->getMessage()
            ];

            return null;
        }
    }
}
