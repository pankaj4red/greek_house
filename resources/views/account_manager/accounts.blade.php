@extends ('customer')

@section ('title', 'Campus Manager - Accounts')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="page-header cancel-header-margin">
        <div class="container">
            <span class="pull-left page-title">Campus Manager - Accounts</span>
            <div class="pull-right new-order">
                <a role="button" href="{{ route('account_manager::accounts') }}" class="btn btn-default add-new-btn"
                   id="account-manager-accounts">
                    <span>Accounts</span>
                </a>
            </div>
            <div class="pull-right new-order">
                <a role="button" href="{{ route('account_manager::share') }}" class="btn btn-default add-new-btn"
                   id="account-manager-share">
                    <span>Share</span>
                </a>
            </div>
        </div>
    </div>
    <div class="container">
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
    </div>
    @foreach ($tables as $table)
        @include ('partials.dashboard_table', $table)
    @endforeach
@endsection