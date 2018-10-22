<div class="panel panel-default panel-comments">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-mail"></i><span
                    class="icon-text">Messages & Notifications{{ $channel == 'fulfillment' ? ': Fulfillment':'' }}</span>
        </h3>
    </div>
    <div class="panel-body">
        <div class="comment-list">
            @foreach ($list as $comment)
                <div class="row comment comment-{{ $comment->user_id==Auth::user()->id?'own':'other' }}">
                    @if ($comment->user_id != Auth::user()->id)
                        <div class="col-xs-2 comment-avatar">
                            @if ($comment->user_id && $comment->user->avatar_id)
                                <img src="{{ route('system::image', $comment->user->avatar_id) }}"/>
                            @else
                                <img src="{{ static_asset('images/user-image-default.png') }}"/>
                            @endif
                        </div>
                    @endif
                    <div class="comment-content-wrapper col-xs-10">
                        <div class="comment-content">
                            <div class="comment-title">
                                <div class="pull-left">
                                    @if ($comment->user_id)
                                        {{ $comment->user->getFullName() }}
                                    @else
                                        System
                                    @endif
                                </div>
                                <div class="pull-right">
                                    {{ date('m/d/Y | h:i a', strtotime($comment->created_at)) }}
                                </div>
                            </div>
                            <div class="comment-body">
                                {!! bbcode($comment->body) !!}
                            </div>
                            @if ($comment->file)
                                @if ($comment->file->type == 'image')
                                    <div class="comment-image">
                                        <a href="{{ route('system::image_download', [$comment->file_id]) }}">
                                            <img src="{{ route('system::image', [$comment->file_id]) }}"/>
                                        </a>
                                    </div>
                                @else
                                    <a href="{{ route('system::file', [$comment->file_id]) }}">
                                        {{ $comment->file->name }}
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($edit)
            <div class="comment-new">
                {{ Form::open(['url' => $blockUrl]) }}
                {{ Form::hidden('channel', $channel) }}
                <div class="file-entry hidden-override">
                    <input type="hidden" value="" name="file_url">
                    <input type="hidden" value="" name="file_filename">
                    <input type="hidden" value="0" name="file_id">
                    <input type="hidden" value="existing" name="file_action">
                </div>
                <div class="col-xs-1">
                    <a href="javascript: void(0)" class="comment-new-file filepicker" data-type="any" id="file"><img
                                src="{{ static_asset('images/icon-upload.png') }}"/></a>
                </div>
                <div class="col-xs-10">
                    <textarea class="comment-new-body" name="body" placeholder="Write a Message{{ $channel == 'customer' && $campaign->state == 'collecting_payment' ? ' -or- Post Sizes':'' }}"></textarea>
                </div>
                <div class="col-xs-1">
                    <button type="submit" class="comment-new-send" name="comment_new_button">
                        <img src="{{ static_asset('images/sbmt-arrow.png') }}" alt="submit"/>
                    </button>
                </div>
                {{ Form::close() }}
            </div>
        @endif
    </div>
</div>

@section ('include')
    @include ('partials.enable_filepicker')
    <?php register_js(static_asset('js/jquery.ns-autogrow.min.js')) ?>
@append

@section ('javascript')
    <script>
        $('.comment-new-body').autogrow({vertical: true, horizontal: false, flickering: false});
    </script>
@append