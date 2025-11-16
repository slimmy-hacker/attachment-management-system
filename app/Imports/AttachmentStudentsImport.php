<?php
namespace App\Imports;
use App\Models\AttachmentSchedule;
use App\Models\AttachmentStudent;
use App\Models\Location;
use App\Models\Student;
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

class AttachmentStudentsImport implements ToModel, WithHeadingRow, SkipsOnFailure, WithValidation

{
use Importable, SkipsFailures;

    public $successCount = 0;
    public $failedRecords = [];

    public function rules(): array
    {
        return [
            '*.reg_no'            => ['required', 'exists:students,reg_no'],
            //'*.attachment_slug'   => ['required', 'exists:attachment_schedules,slug'],
        ];
    }



    public function model(array $row)
    {
        try {
            $reg = strtolower($row['reg_no'] ?? '');
            $slug = strtolower($row['attachment_slug'] ?? '');

            $student = Student::where('reg_no', $reg)->first();
            $attachment = AttachmentSchedule::where('slug', $slug)->first();

            $errors = [];

            if (!$student) {
                $errors[] = "Student with reg_no '{$row['reg_no']}' not found";
            }

            if (!$attachment) {
                $errors[] = "Attachment schedule with slug '{$row['attachment_slug']}' not found";
            }

            if (!empty($errors)) {
                $this->failedRecords[] = [
                    'row' => $row,
                    'reason' => implode(" | ", $errors)
                ];
                return null;
            }


            AttachmentStudent::create([
                'student_id' => $student->id,
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
