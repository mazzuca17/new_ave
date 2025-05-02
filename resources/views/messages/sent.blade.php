@extends('layouts.app_system')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/messages.css') }}">
    <div class="content">
        <div class="container container-full" style="max-width: none !important">
            <div class="page-inner page-inner-fill">
                <div class="page-with-aside mail-wrapper bg-white">
                    @include('messages.options')
                    <div class="page-content mail-content">
                        <div class="inbox-head d-lg-flex d-block">
                            <h3>Enviados</h3>
                            <form action="{{ route('mensajes.index') }}" method="GET" class="ml-auto">
                                <div class="input-group">
                                    <input type="text" name="q" value="{{ request('q') }}"
                                        placeholder="Buscar mensajes..." class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-search search-icon"></i>
                                        </span>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="inbox-body">

                            @forelse ($messages as $item)
                                <div class="email-list">
                                    <a href="{{ route('mensajes.show_sent', $item->id) }}" class="email-list-item "
                                        aria-label="Ver mensaje de {{ $item->sender->name }}">
                                        <article class="email-list-detail">
                                            <span class="date float-right">
                                                @if ($item->attachments->count() > 0)
                                                    <i class="fa fa-paperclip paperclip" aria-hidden="true"></i>
                                                @endif
                                                {{ $item->created_at->format('d M') }}
                                            </span>
                                            <span class="from">{{ $item->sender->name }} </span>
                                            <p class="msg mb-0">{{ $item->subject }}</p>
                                        </article>
                                    </a>
                                </div>
                            @empty
                                <div class="email-list-detail">
                                    <p class="msg text-center">No has enviado mensajes.</p>
                                </div>
                            @endforelse
                            <div class="mt-4 d-flex justify-content-center">
                                {{ $messages->links() }}
                            </div>



                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
