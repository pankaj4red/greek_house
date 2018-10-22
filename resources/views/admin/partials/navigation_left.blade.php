<!-- Sidebar -->
<ul class="sidebar navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin::index') }}"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</a>
    </li>
    @if (Auth::user()->isType(['admin', 'support']))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin::campaign::list') }}"><i class="fas fa-th fa-fw"></i> Campaigns</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin::user::list') }}"><i class="fas fa-users fa-fw"></i> Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin::order::list') }}"><i class="fas fa-credit-card fa-fw"></i>
                Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin::store::list') }}"><i class="fas fa-archive fa-fw"></i>
                Manage Stores</a>
        </li>
    @endif
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin::product::list') }}"><i class="fas fa-cubes fa-fw"></i> Products</a>
    </li>
    @if (Auth::user()->isType(['admin', 'product_qa', 'product_manager']))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin::garment_brand::list') }}"><i class="fas fa-tags fa-fw"></i> Garment
                Brands</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin::garment_category::list') }}"><i class="fas fa-folder fa-fw"></i>
                Garment Categories</a>
        </li>
    @endif
    @if (Auth::user()->isType(['support', 'admin']))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin::design::list') }}"><i class="fas fa-images fa-fw"></i>
                Designs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin::design::trending') }}"><i class="fas fa-comments fa-fw"></i>
                Trending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin::supplier::list') }}"><i class="fas fa-sitemap fa-fw"></i> Supplies</a>
        </li>
    @endif

    @if (Auth::user()->isType(['admin']))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin::transaction::list') }}"><i class="fas fa-stream fa-fw"></i>
                Transactions</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin::log::list') }}"><i class="fas fa-bug fa-fw"></i>
                Logs</a>
        </li>
    @endif
</ul>