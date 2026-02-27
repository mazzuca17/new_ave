<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\Cursos;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $schoolId = $user->school_id;

        $studentsCount = Students::where('school_id', $schoolId)->count();
        $coursesCount = Cursos::where('school_id', $schoolId)->count();
        $globalPerformance = round((float) Students::where('school_id', $schoolId)->avg('promedio'), 2);
        $usersCount = User::where('school_id', $schoolId)->count();

        $topStudents = Students::with(['user', 'curso'])
            ->where('school_id', $schoolId)
            ->orderByDesc('promedio')
            ->take(5)
            ->get();

        return view('school.profile.index', compact(
            'user',
            'studentsCount',
            'coursesCount',
            'globalPerformance',
            'usersCount',
            'topStudents'
        ));
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'image_profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $path = $request->file('image_profile')->store('profile_images', 'public');
        $user->image_profile = $path;
        $user->save();

        return redirect()->route('school.profile.show')->with('success', 'Foto de perfil actualizada correctamente.');
    }
}
