@extends('layouts.app_system')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Todas las notificaciones</h4>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="list-group">
                                @forelse ($notifications as $notification)
                                    <a href="{{ url('/mensajes/' . $notification->data['announcement_id']) }}"
                                        class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ $notification->data['subject'] }}</h5>
                                            <small>{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1">
                                            {{ $notification->data['message'] ?? 'Tienes una nueva notificación.' }}</p>
                                    </a>
                                @empty
                                    <p class="text-muted">No tienes notificaciones.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
