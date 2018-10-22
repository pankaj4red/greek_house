@if ((!isset($print) || $print == false) && config('services.freshmarketer.enabled'))
    <script src='//cdn.freshmarketer.com/105349/174851.js'></script>
@endif