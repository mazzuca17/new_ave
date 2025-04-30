<div class="page-aside">
    <div class="aside-header">
        <div class="title">Mensajería</div>
        <div class="aside-compose"><a href="{{ route('mensajes.create') }}"
                class="btn btn-primary btn-block fw-mediumbold">Redactar</a>
        </div>
    </div>

    <div class="aside-nav collapse" id="email-app-nav">
        <ul class="nav">
            <li class="{{ request()->routeIs('school.mensajes.index') ? 'active' : '' }}">
                <a href="{{ route('mensajes.index') }}">
                    <i class="flaticon-inbox"></i> Recibidos
                    @if ($count_no_read > 0)
                        <span class="badge badge-primary float-right">{{ $count_no_read }}</span>
                    @endif
                </a>
            </li>
            <li class="{{ request()->routeIs('school.mensajes.create') ? 'active' : '' }}">
                <a href="{{ route('mensajes.create') }}">
                    <i class="fa fa-envelope"></i> Enviar mensaje
                </a>
            </li>

        </ul>




    </div>
</div>
