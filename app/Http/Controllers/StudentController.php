<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Services\ActiveDirectoryService;

class StudentController extends Controller
{
    public function index()
    {
        $this->requireAdmin();
        $students = Student::with('user')->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $this->requireAdmin();
        return view('students.create');
    }

    public function store(Request $request)
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'student_number' => 'required|unique:students,student_number',
            'department' => 'required',
            'class' => 'required',
            'phone' => 'nullable'
        ]);

        $ad = new ActiveDirectoryService();
        $ad->connect();
        $adData = $ad->fetchUser($validated['student_number']);
        if (!empty($adData['mail'][0])) {
            $validated['email'] = $adData['mail'][0];
        }
        if (!empty($adData['displayname'][0])) {
            $validated['name'] = $adData['displayname'][0];
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student'
        ]);

        Student::create([
            'user_id' => $user->id,
            'student_number' => $validated['student_number'],
            'department' => $validated['department'],
            'class' => $validated['class'],
            'phone' => $validated['phone'] ?? null
        ]);

        return redirect()->route('students.index')->with('status', 'Student created');
    }

    public function show(Student $student)
    {
        $this->requireAuth();
        if (Auth::user()->role !== 'admin' && Auth::id() !== $student->user_id) {
            abort(403);
        }
        $student->load('user');
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $this->requireAdmin();
        $student->load('user');
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'student_number' => 'required|unique:students,student_number,' . $student->id,
            'department' => 'required',
            'class' => 'required',
            'phone' => 'nullable'
        ]);

        $student->user->update([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);

        $student->update([
            'student_number' => $validated['student_number'],
            'department' => $validated['department'],
            'class' => $validated['class'],
            'phone' => $validated['phone'] ?? null
        ]);

        return redirect()->route('students.show', $student)->with('status', 'Student updated');
    }

    public function destroy(Student $student)
    {
        $this->requireAdmin();
        $student->user->delete();
        return redirect()->route('students.index')->with('status', 'Student deleted');
    }
}

