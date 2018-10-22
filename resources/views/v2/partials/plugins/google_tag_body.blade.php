@if ((!isset($print) || $print == false) && config('services.gtag.enabled'))
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id={{ config('services.gtag.key') }}"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- Google Tag Manager (noscript) -->
@endif