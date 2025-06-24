<?php
namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Student;
use App\Models\Invoice;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function index(Student $student)
    {
        $debts = $student->debts()->get();
        return view('debts.index', compact('student', 'debts'));
    }

    public function create(Student $student)
    {
        return view('debts.create', compact('student'));
    }

    public function store(Request $request, Student $student)
    {
        $validated = $request->validate([
            'type' => 'required',
            'amount' => 'required|numeric',
            'installment_count' => 'required|integer|min:1',
            'due_date' => 'required|date'
        ]);

        $student->debts()->create($validated);

        return redirect()->route('students.debts', $student)->with('status', 'Debt created');
    }

    public function destroy(Debt $debt)
    {
        $student = $debt->student;
        $debt->delete();
        return redirect()->route('students.debts', $student)->with('status', 'Debt deleted');
    }
}
