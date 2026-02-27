@extends('layouts.app_system')

@section('content')
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
                                    @php
                                        $url = $notification->data['url'] ??
                                            (isset($notification->data['announcement_id'])
                                                ? url('/mensajes/' . $notification->data['announcement_id'])
                                                : '#');
                                    @endphp
                                    <a href="{{ $url }}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ $notification->data['subject'] ?? ($notification->data['title'] ?? 'Notificación') }}</h5>
                                            <small>{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1">{{ $notification->data['message'] ?? ($notification->data['content'] ?? 'Tienes una nueva notificación.') }}</p>
                                    </a>
                                @empty
                                    <p class="text-muted">No tienes notificaciones.</p>
                                @endforelse
                            </div>
                            <div class="mt-3">{{ $notifications->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
