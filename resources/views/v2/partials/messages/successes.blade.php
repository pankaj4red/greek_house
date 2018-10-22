@if (Session::get('successes'))
    @foreach (Session::get('successes') as $success)
        <div class="alert alert-success">{{ $success }}</div>
    @endforeach
@endif
