<?php
namespace App\Imports;
use App\Models\Attachment;
use App\Models\AttachmentLecturer;
use App\Models\AttachmentStudent;
use App\Models\Department;
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
            '*.staff_no'            => ['required'],
            '*.attachment_slug'   => ['required'],
            '*.department_code'   => ['nullable'],
        ];
    }



    public function model(array $row)
    {
        try {
            $staff_no  = strtoupper(trim($row['staff_no'] ?? ''));
            $slug = strtolower(trim($row['attachment_slug'] ?? ''));
            $department_code = strtolower(trim($row['department_code'] ?? ''));
            $lecturer = Lecturer::where('staff_number', $staff_no)->first();
            $attachment = Attachment::where('slug', $slug)->first();

            $errors = [];

            if (!$lecturer) {
                $errors[] = "Lecturer with staff_no '{$row['staff_no']}' not found";
            }

            if (!$attachment) {
                $errors[] = "Attachment with slug '{$row['attachment_slug']}' not found";
            }
            //::where('code', $department_code)->first();
            if($lecturer && $attachment) {
                $attachment_lecturer = AttachmentLecturer::where('lecturer_id', $lecturer->id)
                                                        ->where('attachment_id', $attachment->id)
                                                        ->first();
                if ($attachment_lecturer) {
                    $errors[] = "Lecturer with staff_no '{$row['staff_no']}' for attachment '{$row['attachment_slug']}' had already been uploaded";
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
