<?php
namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Student;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebtController extends Controller
{
    public function index(Student $student)
    {
        $this->requireAuth();
        if (Auth::user()->role !== 'admin' && Auth::id() !== $student->user_id) {
            abort(403);
        }
        $debts = $student->debts()->get();
        return view('debts.index', compact('student', 'debts'));
    }

    public function create(Student $student)
    {
        $this->requireAdmin();
        return view('debts.create', compact('student'));
    }

    public function store(Request $request, Student $student)
    {
        $this->requireAdmin();
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
        $this->requireAdmin();
        $student = $debt->student;
        $debt->delete();
        return redirect()->route('students.debts', $student)->with('status', 'Debt deleted');
    }
}
