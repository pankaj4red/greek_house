<div class="block-info-rounded">
    <div class="block-messages">
        @foreach ($list as $comment)
            <div class="messages__item {{ $comment->user_id == Auth::user()->id ? 'answer' : ''}}">
                <div class="item__message">
                    <div class="message__avatar"
                         style="background-image: url({{ $comment->user_id && $comment->user->avatar_id ? route('system::image', $comment->user->avatar_id) : static_asset('images/user-image-default.png') }})"
                         title="{{ $comment->user_id ? $comment->user->getFullName() : 'System' }}"></div>
                    <div class="message__text">
                        {!! bbcode($comment->body) !!}
                        @if ($comment->file)
                            @if ($comment->file->type == 'image')
                                <div class="message__image">
                                    <a href="{{ route('system::image_download', [$comment->file_id]) }}">
                                        <img src="{{ route('system::image', [$comment->file_id]) }}"/>
                                    </a>
                                </div>
                            @else
                                <div>
                                    <a href="{{ route('system::file', [$comment->file_id]) }}">
                                        {{ $comment->file->name }}
                                    </a>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="item__date">{{ $comment->created_at->format('m/d/Y | h:i a') }}</div>
            </div>
        @endforeach
    </div>
    @if ($edit)
        <div class="message__send">
            {{ Form::open(['url' => $blockUrl, 'class' => 'send__input']) }}
            {{ Form::hidden('channel', $channel) }}
            @include ('v2.partials.filepicker', ['class' => 'send__attachment_wrapper', 'url' => '', 'filename' => '', 'id' => 0, 'fieldName' => 'file', 'type' => 'any'])
            <textarea type="text" placeholder="Type your message" name="body" class="gh-control autogrow"></textarea>
            <button type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            {{ Form::close() }}
        </div>
    @endif
</div>
