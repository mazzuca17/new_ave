{{-- resources/views/partials/avatar.blade.php --}}
@php
    $avatar = '';
    $initials = strtoupper(substr($user->name, 0, 1)) . strtoupper(substr($user->last_name, 0, 1));

    if ($user->role_name == 'Alumno') {
        $avatar = $user->student_image ?? 'default.jpg';
    } elseif ($user->role_name == 'Profesor') {
        $avatar = $user->profesor_image ?? 'default.jpg';
    }
@endphp

@if ($avatar)
    <img src="{{ asset('storage/' . $avatar) }}" alt="Imagen de perfil" class="rounded-circle" width="30" height="30"
        style="margin-right: 10px;">
@else
    <div class="avatar avatar-xxl">
        <span class="avatar-title rounded-circle border border-white" style="width: 30px; height: 30px;">
            {{ $initials }}
        </span>
    </div>
@endif
