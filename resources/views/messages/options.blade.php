<div class="page-aside">
    <div class="aside-header">
        <div class="title">Mensajería</div>
        <div class="aside-compose">
            <a href="{{ route('mensajes.create') }}" class="text-white btn btn-primary btn-block fw-mediumbold">
                <i class="fas fa-pencil-alt mr-1"></i> Redactar
            </a>
        </div>
    </div>

    <div class="aside-nav collapse" id="email-app-nav">
        <ul class="nav">
            <li class="{{ request()->routeIs('mensajes.index') ? 'active' : '' }}">
                <a href="{{ route('mensajes.index') }}">
                    <i class="fas fa-inbox mr-1"></i> Recibidos
                    @if ($count_no_read > 0)
                        <span class="badge badge-primary float-right">{{ $count_no_read }}</span>
                    @endif
                </a>
            </li>

            <li class="{{ request()->routeIs('mensajes.enviados') ? 'active' : '' }}">
                <a href="{{ route('mensajes.enviados') }}">
                    <i class="fas fa-paper-plane mr-1"></i> Enviados
                </a>
            </li>

            <li class="{{ request()->routeIs('mensajes.create') ? 'active' : '' }}">
                <a href="{{ route('mensajes.create') }}">
                    <i class="fas fa-envelope mr-1"></i> Enviar mensaje
                </a>
            </li>

        </ul>
    </div>
</div>
