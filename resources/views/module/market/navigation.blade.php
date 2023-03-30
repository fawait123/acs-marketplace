<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ route('market.index') }}" class="nav-link {{ Request::is('market') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Market
                    <span class="right badge badge-danger">New</span>
                </p>
            </a>
        </li>
        <li class="nav-item {{ Request::is('market/asset*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('market/asset*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-database"></i>
                <p>
                    Core
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (in_array('asset', $permissionAccess->toArray()))
                    <li class="nav-item">
                        <a href="{{ route('asset.index') }}"
                            class="nav-link {{ Request::is('market/asset*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Asset</p>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    </ul>
</nav>
