<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\AcademicYearCourseStudent;
use App\Models\AcademicYears;
use App\Models\AttendanceRecords;
use App\Models\Materias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = Auth::user()->school_id;
        $records = AttendanceRecords::with(['enrollment.student.user', 'materia'])
            ->whereHas('enrollment.student', function ($query) use ($schoolId) {
                $query->where('school_id', $schoolId);
            })
            ->when($request->filled('date'), function ($query) use ($request) {
                $query->whereDate('date', $request->date);
            })
            ->orderByDesc('date')
            ->paginate(20);

        return view('school.attendance.index', compact('records'));
    }

    public function create()
    {
        $schoolId = Auth::user()->school_id;
        $activeYear = AcademicYears::where('school_id', $schoolId)
            ->where('status', AcademicYears::STATUS_ACTIVE)
            ->first();

        $enrollments = AcademicYearCourseStudent::with(['student.user'])
            ->whereHas('student', function ($query) use ($schoolId) {
                $query->where('school_id', $schoolId);
            })
            ->when($activeYear, function ($query) use ($activeYear) {
                $query->whereHas('academicYearCourse', function ($yearQuery) use ($activeYear) {
                    $yearQuery->where('academic_year_id', $activeYear->id);
                });
            })
            ->get();

        $subjects = Materias::where('school_id', $schoolId)->get();

        return view('school.attendance.create', compact('enrollments', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_enrollment_id' => 'required|exists:student_enrollments,id',
            'subject_course_id' => 'required|exists:materias,id',
            'date' => 'required|date',
            'status' => 'required|in:presente,ausente,justificado',
        ]);

        AttendanceRecords::create($validated);

        return redirect()->route('school.attendance.index')->with('success', 'Asistencia registrada correctamente.');
    }

    public function edit(int $id)
    {
        $record = AttendanceRecords::findOrFail($id);
        $schoolId = Auth::user()->school_id;

        $enrollments = AcademicYearCourseStudent::with(['student.user'])
            ->whereHas('student', function ($query) use ($schoolId) {
                $query->where('school_id', $schoolId);
            })
            ->get();

        $subjects = Materias::where('school_id', $schoolId)->get();

        return view('school.attendance.edit', compact('record', 'enrollments', 'subjects'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'student_enrollment_id' => 'required|exists:student_enrollments,id',
            'subject_course_id' => 'required|exists:materias,id',
            'date' => 'required|date',
            'status' => 'required|in:presente,ausente,justificado',
        ]);

        $record = AttendanceRecords::findOrFail($id);
        $record->update($validated);

        return redirect()->route('school.attendance.index')->with('success', 'Asistencia actualizada correctamente.');
    }
}
