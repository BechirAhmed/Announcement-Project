
<div class="side-menu" id="admin-side-menu">
    <a class="is-hidden-desktop" id="admin-slideout-btn">
        <span class="icon"><i class="mdi mdi-arrow-right-bold-hexagon-outline" id=""></i></span>
    </a>
    <aside class="menu">
        <p class="menu-label">
            General
        </p>
        <ul class="menu-list">
            <li><a href="{{ route('public.home') }}" class="link-noUnderline {{ Nav::isRoute('public.home') }}">Dashboard</a></li>
        </ul>
        <p class="menu-label">
            Management
        </p>
        <ul class="menu-list">
            <li><a href="{{ route('products.product.index') }}" class="link-noUnderline {{ Nav::isResource('products') }}">Products</a></li>
            <li><a href="{{ route('categories.category.index') }}" class="link-noUnderline {{ Nav::isResource('categories.category.index') }}">Categories</a></li>
            <li><a href="{{ route('sub_categories.sub_category.index') }}" class="link-noUnderline {{ Nav::isRoute('sub_categories.sub_category.index') }}">Sub Categories</a></li>
            <li><a href="{{ route('unit_relateds.unit_related.index') }}" class="link-noUnderline {{ Nav::isRoute('unit_relateds.unit_related.index') }}">Units Related</a></li>
            <li><a href="{{ route('regions.region.index') }}" class="link-noUnderline {{ Nav::isRoute('regions.region.index') }}">Regions</a></li>
        </ul>
        <p class="menu-label">
            Administration
        </p>
        <ul class="menu-list">
            <li>
                <a class="has-submenu {{ Nav::isResource('users') }} link-noUnderline">
                    {{ Lang::get('titles.adminUsers') }}
                    <i class="mdi mdi-chevron-down is-pulled-right"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="{{route('users')}}" class="link-noUnderline {{ Nav::isRoute('users') }}">{{ Lang::get('titles.adminUserList') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('users.create') }}" class="link-noUnderline {{ Nav::isRoute('users.create') }}">{{ Lang::get('titles.adminNewUser') }}</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('themes') }}" class="link-noUnderline {{ Nav::isRoute('themes') }}">{{ Lang::get('titles.adminThemesList') }}</a>
            </li>
            <li><a href="{{ url('/logs') }}" class="link-noUnderline {{ Request::is('logs') ? 'is-active' : null }}">{{ Lang::get('titles.adminLogs') }}</a></li>
            <li><a href="{{ route('laravelPhpInfo::phpinfo') }}" class="link-noUnderline {{ Nav::isRoute('laravelPhpInfo::phpinfo') }}">{{ Lang::get('titles.adminPHP') }}</a></li>
            <li><a href="{{ url('/routes') }}" class="link-noUnderline {{ Request::is('routes') ? 'is-active' : null }}">{{ Lang::get('titles.adminRoutes') }}</a></li>
        </ul>
    </aside>
</div>