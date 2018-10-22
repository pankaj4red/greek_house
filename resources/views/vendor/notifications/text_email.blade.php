<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    @if (! empty($hello))
        Hey {!! bbcode($hello) !!},<br/><br/>
    @endif

    @if (! empty($greeting))
        {!! bbcode($greeting) !!}<br/><br/>
    @endif

    @foreach ($introLines as $line)
        {!! bbcode($line) !!}<br/><br/>
    @endforeach

    @if (isset($actionText))
        {!! bbcode('[url=' . $actionUrl . ']' . $actionText . '[/url]') !!}<br/><br/>
    @endif

    @foreach ($outroLines as $line)
        {!! bbcode($line) !!}<br/><br/>
    @endforeach

    @if (! empty($salutation))
        {!! bbcode($salutation) !!}<br/><br/>
    @else
        Talk to you soon,<br/>
    @endif
        {{ config('app.name') }}
</body>
</html>
