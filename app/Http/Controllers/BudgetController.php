<?php

namespace App\Http\Controllers;
use App\Models\Budget;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    

public function index()
{
    $lecturers = Lecturer::with(['jobGrade', 'assessmentVisits'])->get();

    $budgets = $lecturers->map(function ($lecturer) {

        $dailyAllowance = $lecturer->jobGrade->daily_allowance;

        $subsistenceTotal = 0;
        $transportTotal = 0;
        $studentsTotal = 0;

        foreach ($lecturer->assessmentVisits as $visit) {
            $subsistenceTotal +=
                $dailyAllowance * $visit->days * $visit->students_count;

            $transportTotal += $visit->transport_amount;
            $studentsTotal += $visit->students_count;
        }

        return [
            'lecturer' => $lecturer,
            'areas' => $lecturer->assessmentVisits,
            'students_total' => $studentsTotal,
            'subsistence_total' => $subsistenceTotal,
            'transport_total' => $transportTotal,
            'subtotal' => $subsistenceTotal + $transportTotal,
        ];
    });

    return view('budgets.index', compact('budgets'));
}
    public function budgets()
    {
        $lecturers = Lecturer::with([
            'jobGrade',
            'budgets'
        ])->get();

        return view('admin.budgets', compact('lecturers'));
    }
}



