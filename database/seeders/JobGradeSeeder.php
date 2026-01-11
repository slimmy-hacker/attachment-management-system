<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobGrade;

class JobGradeSeeder extends Seeder
{
    public function run(): void
    {
        JobGrade::insert([
            [
                'public_service_group' => 'U',
                'dekut_grade' => '18',
                'designation' => 'Vice Chancellors',
                'daily_allowance' => 18200,
                'applies_to' => 'All Towns',
            ],
            [
                'public_service_group' => 'T',
                'dekut_grade' => '17',
                'designation' => 'Deputy Vice Chancellors',
                'daily_allowance' => 16800,
                'applies_to' => 'All Towns',
            ],
            [
                'public_service_group' => 'S',
                'dekut_grade' => '15 & 16',
                'designation' => 'Principals / Professors / Registrars / Finance Officers',
                'daily_allowance' => 16800,
                'applies_to' => 'All Towns',
            ],
            [
                'public_service_group' => 'R',
                'dekut_grade' => '14',
                'designation' => 'Associate Professors / Deputy Registrars / Deputy Finance Officers',
                'daily_allowance' => 14000,
                'applies_to' => 'All Towns',
            ],
            [
                'public_service_group' => 'Q',
                'dekut_grade' => '13',
                'designation' => 'Senior Lecturers / Senior Assistant Registrars',
                'daily_allowance' => 14000,
                'applies_to' => 'All Towns',
            ],
            [
                'public_service_group' => 'P',
                'dekut_grade' => '12',
                'designation' => 'Lecturers / Assistant Registrars',
                'daily_allowance' => 11200,
                'applies_to' => 'All Towns',
            ],
            [
                'public_service_group' => 'N',
                'dekut_grade' => '11',
                'designation' => 'Assistant Registrars / Senior Administration Officers',
                'daily_allowance' => 11200,
                'applies_to' => 'All Towns',
            ],
            [
                'public_service_group' => 'M',
                'dekut_grade' => '10',
                'designation' => 'Administrative Officers',
                'daily_allowance' => 11200,
                'applies_to' => 'All Towns',
            ],
            [
                'public_service_group' => 'L',
                'dekut_grade' => '9',
                'designation' => 'Assistant Administrative Officers (Entry Level)',
                'daily_allowance' => 11200,
                'applies_to' => 'All Towns',
            ],
            [
                'public_service_group' => 'K',
                'dekut_grade' => '8',
                'designation' => 'Senior Administrative Assistants',
                'daily_allowance' => 6300,
                'applies_to' => 'All Towns',
            ],
            [
                'public_service_group' => 'J',
                'dekut_grade' => '7',
                'designation' => 'Administrative Assistants',
                'daily_allowance' => 6300,
                'applies_to' => 'All Towns',
            ],
            [
                'public_service_group' => 'H',
                'dekut_grade' => '5 & 6',
                'designation' => 'Senior Clerical Staff',
                'daily_allowance' => 6300,
                'applies_to' => 'All Towns',
            ],
            [
                'public_service_group' => 'G',
                'dekut_grade' => '3 & 4',
                'designation' => 'Senior Support Staff',
                'daily_allowance' => 4200,
                'applies_to' => 'All Towns',
            ],
            [
                'public_service_group' => 'F',
                'dekut_grade' => '1 & 2',
                'designation' => 'Support Staff (Office Assistants / Cleaners)',
                'daily_allowance' => 4200,
                'applies_to' => 'All Towns',
            ],
        ]);
    }
}
