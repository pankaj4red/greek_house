@component('mail::message')
{{-- Hello --}}
@if (! empty($hello))
Hello {!! bbcode($hello) !!},
@endif

{{-- Greeting --}}
@if (! empty($greeting))
# {!! bbcode($greeting) !!}
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{!! bbcode($line) !!}

@endforeach

{{-- Table --}}
@if (isset($table))
@component('mail::table')
@if ($table['header'])
| @foreach ($table['header'] as $th) {{ $th }} | @endforeach
@else
| @foreach ($table['rows'][0] as $td) &nbsp; | @endforeach
@endif

| @foreach ($table['rows'][0] as $td) - | @endforeach

@foreach ($table['rows'] as $row)
| @foreach ($row as $td) {{ $td }} | @endforeach

@endforeach
@endcomponent
@endif

{{-- Action Button --}}
@if (isset($actionText))
<?php
/** @noinspection PhpUndefinedVariableInspection */
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endif

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{!! bbcode($line) !!}

@endforeach

<!-- Salutation -->

@if (! empty($salutation))
{!! bbcode($salutation) !!}
@else
Best,
@endif

{{ config('app.name') }}



<!-- Subcopy -->
@if (isset($actionText))
@component('mail::subcopy')
If you’re having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below
into your web browser: [{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endif
@endcomponent
