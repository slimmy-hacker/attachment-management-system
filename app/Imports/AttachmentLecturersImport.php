<?php
namespace App\Imports;
use App\Models\AdministrativeUnit;
use App\Models\Attachment;
use App\Models\AttachmentLecturer;
use App\Models\Lecturer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class AttachmentLecturersImport implements ToModel, WithHeadingRow, SkipsOnFailure, WithValidation

{
use Importable, SkipsFailures;

    public $successCount = 0;
    public $failedRecords = [];

    public function rules(): array
    {
        return [
            '*.staff_number'            => ['required'],
            '*.attachment_slug'   => ['required'],
            '*.department_code'   => ['nullable'],
        ];
    }



    public function model(array $row)
    {
        try {
            $staff_no  = strtoupper(trim($row['staff_number'] ?? ''));
            $slug = strtolower(trim($row['attachment_slug'] ?? ''));
            $department_code = strtolower(trim($row['department_code'] ?? ''));
            $lecturer = Lecturer::where('staff_number', $staff_no)->first();
            $attachment = Attachment::where('slug', $slug)->first();

            $errors = [];

            if (!$lecturer) {
                $errors[] = "Lecturer with staff_no '{$row['staff_number']}' not found";
            }

            if (!$attachment) {
                $errors[] = "Attachment with slug '{$row['attachment_slug']}' not found";
            }
            if ($department_code) {
                $department = AdministrativeUnit::where('code', $department_code)
                                        ->where('level',2)
                                      ->first();
                if (!$department) {
                    $errors[] = "Department with code '{$row['department_code']}' not found";
                }
            }

            if($lecturer && $attachment) {
                $attachment_lecturer = AttachmentLecturer::where('lecturer_id', $lecturer->id)
                                                        ->where('attachment_id', $attachment->id)
                                                         ->where('department_id', $department->id ?? $lecturer->department_id)
                                                        ->first();
                if ($attachment_lecturer) {
                    $errors[] = "Lecturer with staff_no '{$row['staff_number']}' for attachment '{$row['attachment_slug']}' had already been uploaded";
                }
            }

            if (!empty($errors)) {
                $this->failedRecords[] = [
                    'row' => $row,
                    'reason' => implode(" | ", $errors)
                ];
                return null;
            }


            AttachmentLecturer::create([
                'lecturer_id' => $lecturer->id,
                'attachment_id' => $attachment->id,
                'department_id' => $department->id ?? $lecturer->department_id,
            ]);

            $this->successCount++;
        } catch (\Exception $e) {
            $this->failedRecords[] = [
                'row' => $row,
                'reason' => $e->getMessage()
            ];
            return null;
        }


    }

}
