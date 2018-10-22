<div class="modal-popup">
    <div class="modal-header">
        <div class="modal-title">
            @yield('title')
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="ajax-messages"></div>
        @yield('content_campaign')
        @yield('javascript')
    </div>
</div>

