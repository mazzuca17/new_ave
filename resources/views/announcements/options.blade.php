<div class="page-aside">
    <div class="aside-header">
        <div class="title">Mail Service</div>
        <div class="description">Service Description</div>
        <a class="btn btn-primary toggle-email-nav" data-toggle="collapse" href="#email-app-nav" role="button"
            aria-expanded="false" aria-controls="email-nav">
            <span class="btn-label">
                <i class="icon-menu"></i>
            </span>
            Menu
        </a>
    </div>
    <div class="aside-nav collapse" id="email-app-nav">
        <ul class="nav">
            <li>
                <a href="{{ route('school.mensajes.index') }}">
                    <i class="flaticon-inbox"></i> Recibidos
                    <span class="badge badge-primary float-right">8</span>
                </a>
            </li>
            <li class="active">
                <a href="{{ route('school.mensajes.create') }}">
                    <i class="fa fa-envelope"></i> Enviar mensaje
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="flaticon-interface-5"></i> Trash
                </a>
            </li>

        </ul>


        <div class="aside-compose"><a href="{{ route('school.mensajes.create') }}"
                class="btn btn-primary btn-block fw-mediumbold">Compose Email</a>
        </div>
    </div>
</div>
