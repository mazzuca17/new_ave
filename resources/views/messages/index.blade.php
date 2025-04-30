@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="container container-full" style="max-width: none !important">
            <div class="page-inner page-inner-fill">
                <div class="page-with-aside mail-wrapper bg-white">
                    @include('messages.options')
                    <div class="page-content mail-content">
                        <div class="inbox-head d-lg-flex d-block">
                            <h3>Inbox</h3>
                            <form action="{{ route('mensajes.index') }}" method="GET" class="ml-auto">
                                <div class="input-group">
                                    <input type="text" name="q" value="{{ request('q') }}"
                                        placeholder="Search Email" class="form-control">
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
                                @include('messages.list_messages')

                            @empty
                                <div class="email-list-detail">
                                    <p class="msg text-center">No tienes mensajes.</p>
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
