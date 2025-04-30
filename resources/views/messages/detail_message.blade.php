@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="container container-full" style="max-width: none !important">
            <div class="page-inner page-inner-fill">
                <div class="page-with-aside mail-wrapper bg-white">

                    @include('messages.options')

                    <div class="page-content mail-content">
                        <div class="email-head d-lg-flex d-block align-items-center justify-content-between">
                            <h3>
                                {{ $data_message->email->subject }}
                            </h3>
                            <div class="controls mt-3 mt-lg-0">
                                {{-- <a href="{{ route('messages.reply', $data_message->email->id) }}" title="Responder"><i
                                        class="fa fa-reply"></i></a>
                                <a href="{{ route('messages.destroy', $data_message->email->id) }}"
                                    onclick="return confirm('¿Estás seguro de eliminar este mensaje?')" title="Eliminar">
                                    <i class="fa fa-trash"></i>
                                </a> --}}
                            </div>
                        </div>

                        <div class="email-sender d-flex align-items-center justify-content-between mt-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar mr-3">
                                    <img src="{{ $data_message->email->sender->avatar_url ?? asset('img/profile.jpg') }}"
                                        alt="Avatar de {{ $data_message->email->sender->name }}"
                                        style="width: 40px; height: 40px; border-radius: 50%;">
                                </div>
                                <div class="sender">
                                    <strong>De:
                                        <b>
                                            {{ $data_message->email->sender->name }}
                                        </b>
                                    </strong> <br>
                                    Para <span class="to">mí</span>

                                </div>
                            </div>
                            <div class="date text-muted">
                                {{ $data_message->email->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <div class="email-body mt-4">
                            {!! $data_message->email->body !!}
                        </div>


                        @if ($data_message->email->attachments->count())
                            <div class="email-attachments mt-4">
                                <h5 class="mb-3">
                                    <i class="fa fa-paperclip"></i> Adjuntos
                                    <span class="text-muted">({{ $data_message->email->attachments->count() }}
                                        archivo{{ $data_message->email->attachments->count() > 1 ? 's' : '' }})</span>
                                </h5>

                                <div class="list-group">
                                    @foreach ($data_message->email->attachments as $attachment)
                                        <div
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-file mr-2 text-primary"></i>
                                                <strong>{{ basename($attachment->file_path) }}</strong>
                                            </div>
                                            <div class="btn-group">
                                                <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                    class="btn btn-sm btn-outline-success" download>
                                                    <i class="fa fa-download"></i> Descargar
                                                </a>
                                                <button class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                                    data-target="#viewModal-{{ $attachment->id }}">
                                                    <i class="fa fa-eye"></i> Ver
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="viewModal-{{ $attachment->id }}" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Vista previa:
                                                            {{ basename($attachment->file_path) }}</h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        @php
                                                            $ext = pathinfo($attachment->file_path, PATHINFO_EXTENSION);
                                                        @endphp

                                                        @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                                            <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                                                class="img-fluid rounded shadow">
                                                        @elseif (in_array($ext, ['pdf']))
                                                            <embed src="{{ asset('storage/' . $attachment->file_path) }}"
                                                                type="application/pdf" width="100%" height="600px" />
                                                        @else
                                                            <div class="alert alert-info">
                                                                Este tipo de archivo no tiene vista previa disponible.
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
