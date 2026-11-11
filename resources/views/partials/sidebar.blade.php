<aside class="sidebar" id="sidebar">
    <div class="sidebar__brand">
        <div class="sidebar__brand-mark" aria-hidden="true">LM</div>
        <div class="sidebar__brand-text">
            <span class="sidebar__brand-name">La María</span>
            <span class="sidebar__brand-caption">Pastelería</span>
        </div>
    </div>

    <div class="sidebar__section-label">MENÚ PRINCIPAL</div>

    <nav class="sidebar__nav" aria-label="Navegación principal">
        <a href="{{ route('dashboard') }}"
           class="sidebar__link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}"
           @if(request()->routeIs('dashboard')) aria-current="page" @endif>
            <span class="sidebar__icon" aria-hidden="true">⌂</span>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('productos.index') }}"
           class="sidebar__link {{ request()->routeIs('productos.*') ? 'is-active' : '' }}"
           @if(request()->routeIs('productos.*')) aria-current="page" @endif>
            <span class="sidebar__icon" aria-hidden="true">◇</span>
            <span>Productos</span>
        </a>

        <a href="{{ route('categorias.index') }}"
           class="sidebar__link {{ request()->routeIs('categorias.*') ? 'is-active' : '' }}"
           @if(request()->routeIs('categorias.*')) aria-current="page" @endif>
            <span class="sidebar__icon" aria-hidden="true">▦</span>
            <span>Categorías</span>
        </a>

        <a href="{{ route('usuarios.index') }}"
           class="sidebar__link {{ request()->routeIs('usuarios.*') ? 'is-active' : '' }}"
           @if(request()->routeIs('usuarios.*')) aria-current="page" @endif>
            <span class="sidebar__icon" aria-hidden="true">♙</span>
            <span>Usuarios</span>
        </a>

        <a href="{{ route('roles.index') }}"
           class="sidebar__link {{ request()->routeIs('roles.*') ? 'is-active' : '' }}"
           @if(request()->routeIs('roles.*')) aria-current="page" @endif>
            <span class="sidebar__icon" aria-hidden="true">♧</span>
            <span>Roles</span>
        </a>

        <a href="{{ route('contacto') }}"
           class="sidebar__link {{ request()->routeIs('contacto') ? 'is-active' : '' }}"
           @if(request()->routeIs('contacto')) aria-current="page" @endif>
            <span class="sidebar__icon" aria-hidden="true">✉</span>
            <span>Contacto</span>
        </a>

        <a href="{{ route('cotizacion') }}"
           class="sidebar__link {{ request()->routeIs('cotizacion') ? 'is-active' : '' }}"
           @if(request()->routeIs('cotizacion')) aria-current="page" @endif>
            <span class="sidebar__icon" aria-hidden="true">✎</span>
            <span>Cotización</span>
        </a>

        <div class="sidebar__divider"></div>

        <a href="{{ route('empresa') }}"
           class="sidebar__link {{ request()->routeIs('empresa') ? 'is-active' : '' }}"
           @if(request()->routeIs('empresa')) aria-current="page" @endif>
            <span class="sidebar__icon" aria-hidden="true">⌂</span>
            <span>Empresa</span>
        </a>
    </nav>

    <div class="sidebar-logout">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">
            <span aria-hidden="true">⎋</span>
            <span>Cerrar sesión</span>
        </button>
    </form>
</div>

    <div class="sidebar__footer">
        <span class="sidebar__footer-dot" aria-hidden="true"></span>
        <span>Panel administrativo</span>
    </div>
</aside>
