@extends ('admin_old.admin')

@section ('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Trending</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Trending
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    {{ Form::open() }}
                    <div class="table-responsive table-bordered" id="design-list">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Campaign</th>
                                <th>Sort</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($list as $entry)
                                <tr>
                                    <td>{{ $entry->id }}</td>
                                    <td>
                                        <a href="{{ route('admin::design::read', [$entry->id]) }}">{{ $entry->name }}<br/><img src="{{ route('system::image', [$entry->getThumbnail()]) }}"
                                                                                                                               class="mw-100"/></a>
                                    </td>
                                    <td>
                                        @if ($entry->campaign_id)
                                            <a href="{{ route('admin::campaign::read', [$entry->campaign_id]) }}">{{ $entry->campaign->name }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        {{ Form::text('sort_' . $entry->id, $entry->sort, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class=" action-area pull-right mt-2">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection