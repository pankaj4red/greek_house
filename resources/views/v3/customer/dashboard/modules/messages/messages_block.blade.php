<div class="border-1 border-gray border-round p-3">
    <div class="messages">
        <div class="message-list">
            @foreach ($list as $comment)
                <div class="message {{ $comment->user_id == Auth::user()->id ? 'answer' : ''}}">
                    <div class="message-body">
                        <div class="message-avatar"
                             style="background-image: url({{ $comment->user_id && $comment->user->avatar_id ? route('system::image', $comment->user->avatar_id) : static_asset('images/user-image-default.png') }})"
                             title="{{ $comment->user_id ? $comment->user->getFullName() : 'System' }}"></div>
                        <div class="message-text">
                            {!! bbcode($comment->body) !!}
                            @if ($comment->file)
                                @if ($comment->file->type == 'image')
                                    <div class="message-image">
                                        <a href="{{ route('system::image_download', [$comment->file_id]) }}">
                                            <img src="{{ route('system::image', [$comment->file_id]) }}"/>
                                        </a>
                                    </div>
                                @else
                                    <div class="message-file">
                                        <a href="{{ route('system::file', [$comment->file_id]) }}">
                                            {{ $comment->file->name }}
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="message-date">{{ $comment->created_at->format('m/d/Y | h:i a') }}</div>
                </div>
            @endforeach
        </div>
        @if ($edit)
            <div class="messages-send">
                {{ Form::open(['url' => $blockUrl, 'class' => 'messages-send-form']) }}
                {{ Form::hidden('channel', $channel) }}
                @include ('v3.partials.filepicker', ['class' => 'messages-send-file-wrapper', 'url' => '', 'filename' => '', 'id' => 0, 'fieldName' => 'file', 'type' => 'any'])
                <textarea type="text" placeholder="Type your message" name="body" class="form-control autogrow"></textarea>
                <button type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                {{ Form::close() }}
            </div>
        @endif
    </div>
</div>
