<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\EducationalLevels;
use App\Models\SchoolEducationalLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EducationalLevelController extends Controller
{
    public function index()
    {
        Log::debug('demo');
        $niveles = EducationalLevels::with('EducationSchoolLevel')->get();

        return view('school.educational_level.index', compact('niveles'));
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',

        ]);

        $schoolId = Auth::user()->school->id;

        // Usamos transacción por seguridad si algo falla
        DB::beginTransaction();

        try {
            $educationalLevel = EducationalLevels::create([
                'name'        => $request->name,
                'description' => $request->description,
                'school_id'   => $schoolId,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            SchoolEducationalLevel::create([
                'school_id'            => $schoolId,
                'educational_level_id' => $educationalLevel->id,
                'status'               => $request->get('agree'),
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('school.educational_level.index')
                ->with('success', EducationalLevels::MESSAGE_EDUCATIONALLEVELS_SUCCESS);
        } catch (\Exception $e) {
            DB::rollBack();
            // Log del error para debugging
            Log::error('Error al crear nivel educativo: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('danger', EducationalLevels::ERROR_MESSAGE_VALIDATOR);
        }
    }

    public function updateStatusLevel(Request $request)
    {
        $request->validate([
            'level_id' => 'required',
            'action'   => 'required|string',
        ]);

        $schoolId = Auth::user()->school->id;

        // Usamos transacción por seguridad si algo falla
        DB::beginTransaction();

        try {
            // primero, identifico si es uno de los default
            $data_level = EducationalLevels::find($request->get('level_id'));
            // evaluamsos la accion
            if ($request->get('action') == 'activate' && $data_level->school_id == null) {
                SchoolEducationalLevel::create([
                    'school_id'            => $schoolId,
                    'educational_level_id' => $data_level->id,
                    'active'               => true,
                    'created_at'           => now(),
                    'updated_at'           => now(),
                ]);
            } else {
                SchoolEducationalLevel::where('educational_level_id', $data_level->id)->update([
                    'school_id'            => $schoolId,
                    'educational_level_id' => $data_level->id,
                    'active'               => $request->get('action') == 'active' ? true : false,
                    'created_at'           => now(),
                    'updated_at'           => now(),
                ]);
            }
            DB::commit();

            return redirect()
                ->route('school.educational_level.index')
                ->with('success', EducationalLevels::MESSAGE_EDUCATIONALLEVELS_ACTIVE_SUCCESS);
        } catch (\Exception $e) {
            DB::rollBack();
            // Log del error para debugging
            Log::error('Error al crear nivel educativo: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('danger', EducationalLevels::MESSAGE_EDUCATIONALLEVELS_ACTIVE_ERROR);
        }
    }
}
