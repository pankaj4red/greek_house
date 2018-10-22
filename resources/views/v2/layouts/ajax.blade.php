<div class="module-popup">
    <div class="module-header">
        <div class="module-title">
            @yield('title')
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
    <div class="module-body">
        <div class="module-content">
            @yield('content')
        </div>
        @yield('javascript')
    </div>
</div>