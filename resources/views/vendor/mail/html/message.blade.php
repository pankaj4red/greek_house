@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img align="center" alt="Greek House"
                 src="https://gallery.mailchimp.com/3239900ed8a57c8a5b21c2af0/images/3c353ab9-41bd-410f-b952-7ad7c41bbc23.jpg"
                 width="150"
                 style="max-width:150px; padding-bottom: 0; display: inline !important; vertical-align: bottom;"
                 class="mcnImage">
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @if (isset($subcopy))
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endif

    {{-- Footer --}}
    @slot('footer')
        @component('mail::social')
        @endcomponent
        @component('mail::footer')
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
