@if ((!isset($print) || $print == false) && config('services.hubspot.javascript.enabled'))
    <!-- Start of HubSpot Embed Code -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/2266317.js"></script>
    <!-- End of HubSpot Embed Code -->
@endif
