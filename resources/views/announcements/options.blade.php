<div class="page-aside">
    <div class="aside-header">
        <div class="title">Mensajería</div>
        <div class="aside-compose"><a href="{{ route('school.mensajes.create') }}"
                class="btn btn-primary btn-block fw-mediumbold">Redactar</a>
        </div>
    </div>

    <div class="aside-nav collapse" id="email-app-nav">
        <ul class="nav">
            <li class="{{ request()->routeIs('school.mensajes.index') ? 'active' : '' }}">
                <a href="{{ route('school.mensajes.index') }}">
                    <i class="flaticon-inbox"></i> Recibidos
                    @if ($count_no_read > 0)
                        <span class="badge badge-primary float-right">{{ $count_no_read }}</span>
                    @endif
                </a>
            </li>
            <li class="{{ request()->routeIs('school.mensajes.create') ? 'active' : '' }}">
                <a href="{{ route('school.mensajes.create') }}">
                    <i class="fa fa-envelope"></i> Enviar mensaje
                </a>
            </li>
            <li class="">
                <a href="{{ route('school.mensajes.demo') }}">
                    <i class="flaticon-interface-5"></i> Papelera
                </a>
            </li>
        </ul>




    </div>
</div>
