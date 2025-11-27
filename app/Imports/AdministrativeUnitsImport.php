<?php
namespace App\Imports;
use App\Models\AdministrativeUnit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Validator;

class AdministrativeUnitsImport implements ToModel, WithHeadingRow, SkipsOnFailure, WithValidation

{
use Importable, SkipsFailures;

    public function rules(): array
    {
        return [
            '*.name'        => 'required|string',
            '*.code'        => 'required|unique:administrative_units,code',
            '*.parent_code' => 'nullable',
            '*.level'       => 'required',
        ];
    }


    public function model(array $row)
    {
        return DB::transaction(function () use ($row) {
            return AdministrativeUnit ::updateOrCreate(
                ['code' => strtolower($row['code'])],
                [
                    'name'        => $row['name'],
                    'parent_code' => strtolower($row['parent_code']) ?? null,
                    'level'       => $row['level'],
                ]
            );
        });
    }


}
