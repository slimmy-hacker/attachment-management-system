<?php
namespace App\Imports;

use App\Models\AdministrativeUnit;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Validator;

class StudentsImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
use Importable, SkipsFailures;
public $successCount = 0;
public $failedRecords = [];
public function model(array $row)
{
// Validate the row
    try{
$validator = Validator::make($row, [
    'name' => 'required|string',
    'email' => 'required|email|unique:users,email',
    'phone_number' => 'nullable|string',
    'reg_no' => 'required|string',
    'year_of_study' => 'nullable|string',
    'program_code' => [
        'required',
        Rule::exists('administrative_units', 'code')->where('level', 3),
    ],
]);

    if ($validator->fails()) {
        $this->failedRecords[] = [
            'reason' => implode(" | ", $validator->errors()->all())
        ];

        return null;
    }

    return DB::transaction(function () use ($row) {
        $reg_no = Str::upper($row['reg_no']);
        $email= Str::lower($row['email']);
        $programme_code= Str::lower($row['program_code']);
        $programme = AdministrativeUnit::where('level', 3)->where('code', $programme_code)->first();
            if(!$programme){
                $this->failedRecords[] = [
                    'reason' => 'Programme Not Found'
                ];
                return null;
            }
        $user = User::create([
                    'email' => $email,
                    'name' => $row['name'],
                    'phone_number' => $row['phone_number'],
                    'password' =>bcrypt($reg_no),
                    'role' => 'student',
                    ]);

            Student::create([
                'user_id' => $user->id,
                'reg_no' => $reg_no,
                'program_id' => $programme->id,
                'year_of_study' => $row['year_of_study'],
                'phone_number' => $row['phone_number'],
                ]
                );

            $this->successCount++;
    return $user;
    });
}
catch(\Exception $e){
    $this->failedRecords[] = $e->getMessage();}
}

}
