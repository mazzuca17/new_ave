@extends('layouts.app_system')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-entradas-borrador">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <a class="link_panel" href="#">
                                    <h2 class="title-borrador">{{ __('Entradas en borrador: ') }}</h2>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <h3 class="title-publish cant-borrador"></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-entradas-borrador">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <a class="link_panel" href="#">
                                    <h2 class="title-borrador">{{ __('Entradas en borrador: ') }}</h2>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <h3 class="title-publish cant-borrador"></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
