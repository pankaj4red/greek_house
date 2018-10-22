[Greek House]<br/><br/>
<p><b>Exception:</b> {{ $exception->getMessage() }}</p>
<p><b>Url:</b> {{ Request::url() }}</p>
<p>
    <b>Parameters:</b><br/>
</p>
<pre>{{ print_r(Request::all(), true) }}</pre>
<p>
    <b>Session</b><br/>
</p>
<pre>{{ print_r(Session::all(), true) }}</pre>
<p>
    <b>Server</b><br/>
</p>
<pre>{{ print_r([
        'HTTP_ACCEPT' => isset($_SERVER['HTTP_ACCEPT'])?$_SERVER['HTTP_ACCEPT']:'',
        'HTTP_ACCEPT_CHARSET' => isset($_SERVER['HTTP_ACCEPT_CHARSET'])?$_SERVER['HTTP_ACCEPT_CHARSET']:'',
        'HTTP_ACCEPT_ENCODING' => isset($_SERVER['HTTP_ACCEPT_ENCODING'])?$_SERVER['HTTP_ACCEPT_ENCODING']:'',
        'HTTP_ACCEPT_LANGUAGE' => isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])?$_SERVER['HTTP_ACCEPT_LANGUAGE']:'',
        'HTTP_REFERRER' => isset($_SERVER['HTTP_REFERRER'])?$_SERVER['HTTP_REFERRER']:'',
        'HTTP_USER_AGENT' => isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:''
    ]) }}</pre>
<p><b>Client Ip:</b> {{ Request::getClientIp() }}</p>
<p>
    <b>User:</b><br/>
</p>
<pre>{{ Auth::user()?print_r(Auth::user()->toArray()):'N/A' }}</pre>
<p><b>Exception</b></p>
<p>{{ print_r($exception, true) }}</p>
<p><b>Line:</b> {{ $exception->getLine() }}</p>
<p><b>File:</b> {{ $exception->getFile() }}</p>
<p>
    <b>Stack trace:</b>
</p>
<pre>{{$exception->getTraceAsString() }}</pre>