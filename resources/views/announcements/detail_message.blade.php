@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="container container-full" style="max-width: none !important">
            <div class="page-inner page-inner-fill">
                <div class="page-with-aside mail-wrapper bg-white">

                    @include('announcements.options')

                    <div class="page-content mail-content">
                        <div class="email-head d-lg-flex d-block align-items-center justify-content-between">
                            <h3>
                                {{ $message->subject }}
                            </h3>
                            <div class="controls mt-3 mt-lg-0">
                                {{-- <a href="{{ route('messages.reply', $message->id) }}" title="Responder"><i
                                        class="fa fa-reply"></i></a>
                                <a href="{{ route('messages.destroy', $message->id) }}"
                                    onclick="return confirm('¿Estás seguro de eliminar este mensaje?')" title="Eliminar">
                                    <i class="fa fa-trash"></i>
                                </a> --}}
                            </div>
                        </div>

                        <div class="email-sender d-flex align-items-center justify-content-between mt-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar mr-3">
                                    <img src="{{ $message->sender->avatar_url ?? asset('assets/img/default-avatar.jpg') }}"
                                        alt="Avatar de {{ $message->sender->name }}"
                                        style="width: 40px; height: 40px; border-radius: 50%;">
                                </div>
                                <div class="sender">
                                    <strong>{{ $message->sender->name }}</strong> a <span class="to">mí</span>
                                    <div class="action ml-1">
                                        <a data-toggle="dropdown" class="dropdown-toggle"></a>
                                        <div role="menu" class="dropdown-menu">
                                            <form action="{{ route('school.mensajes.markRead', $message->id) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="action"
                                                    value="{{ $message->is_read ? 'unread' : 'read' }}">
                                                <button type="submit" class="dropdown-item">
                                                    @if ($message->is_read)
                                                        Marcar como no leído
                                                    @else
                                                        Marcar como leído
                                                    @endif
                                                </button>
                                            </form>

                                            <div class="dropdown-divider"></div>
                                            {{-- <a href="{{ route('messages.destroy', $message->id) }}" class="dropdown-item"
                                                onclick="return confirm('¿Eliminar mensaje?')">Eliminar</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="date text-muted">
                                {{ $message->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <div class="email-body mt-4">
                            {!! $message->content !!}
                        </div>


                        @if ($message->files->count())
                            <div class="email-attachments mt-4">
                                <div class="title mb-2">
                                    Adjuntos <span>({{ $message->files->count() }} archivo(s))</span>
                                </div>
                                <ul class="list-unstyled">
                                    @foreach ($message->files as $file)
                                        <li class="mb-2">
                                            <a href="{{ $file->url }}" target="_blank">
                                                <i class="fa fa-paperclip mr-2"></i>
                                                {{ $file->name }}
                                                <span class="text-muted ml-1">({{ number_format($file->size / 1024, 2) }}
                                                    KB)</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
