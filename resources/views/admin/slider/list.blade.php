@extends ('admin.layouts.admin')

@section ('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Home Page Silder</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Slides
                </div>
               
                <div class="panel-body">
                    
                    <div class="table-responsive table-bordered">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>URL</th>
                                <th>Priority</th>
                                <th class="">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($list as $entry)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin::slider::update', [$entry->id]) }}">
                                        {{ $entry->id }}
                                        </a></td>
                                    <td>
                                        <a href="{{ route('admin::slider::update', [$entry->id]) }}">
                                       <img src="{{ route('system::image', [$entry->image]) }}" class="slider-image">
                                        </a>

                                    </td>
                                    <td width="60%">{{ wordwrap($entry->url) }}</td>
                                    <td>{{ $entry->priority }}</td>
                                    <td>  <a href="{{ route('admin::slider::update', [$entry->id]) }}"
                                             class="btn btn-default">Edit</a>
                                        <a href="{{ route('admin::slider::delete', [$entry->id]) }}"
                                           class="btn btn-danger">Delete</a>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-left">
                        <div class="table-entries">
                            Showing {{ ($list->currentPage()-1) * $list->perPage() + 1 }}
                            to {{ (($list->currentPage()-1) * $list->perPage()) + $list->count() }}
                            of {{ $list->total() }} entries
                        </div>
                    </div>
                    <div class="pull-right">
                        {!! $list->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->isType(['admin', 'support']))
        <div class="row">
            <div class="col-sm-12">
                <div class=" action-area pull-right">
                    <a href="{{ route('admin::slider::create', []) }}" class="btn btn-success">Create</a>
                </div>
            </div>
        </div>
    @endif
@endsection