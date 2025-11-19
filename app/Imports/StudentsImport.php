<?php
namespace App\Imports;

use App\Models\AdministrativeUnit;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Validator;

class StudentsImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
use Importable, SkipsFailures;

public function model(array $row)
{
// Validate the row
$validator = Validator::make($row, [
'name' => 'required|string',
'email' => 'required|email|unique:users,email',
'phone_number' => 'nullable|string',
'reg_no' => 'required|string',
'year_of_study' => 'nullable|string',
'programme' => 'required|string|exists:administrative_units,code',
]);

if ($validator->fails()) {
// Skip this row, errors are collected in SkipsFailures
$this->onFailure($validator->errors()->all());
return null;
}

// Use DB transaction to ensure consistency
return DB::transaction(function () use ($row) {
$reg_no = Str::upper($row['reg_no']);
$email= Str::lower($row['email']);
$programme_code= Str::upper($row['programme']);
$programme = AdministrativeUnit::where('level', 3)->where('code', $programme_code)->first();

$user = User::updateOrCreate(
                ['email' => $email],
                [
                'name' => $row['name'],
                'phone_number' => $row['phone_number'],
                'password' => Hash::make($reg_no),
                    'role' => 'student',
                ]
            );

Student::updateOrCreate(
['user_id' => $user->id],
[
'reg_no' => $reg_no,
'programme_id' => $programme->id,
'year_of_study' => $row['year_of_study'],
'phone_number' => $row['phone_number'],
]
);

return $user;
});
}
}
