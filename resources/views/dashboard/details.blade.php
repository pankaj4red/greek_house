@extends ('customer')

@section ('title', $campaign->name)

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="page-header cancel-header-margin cancel-bottom-margin">
        <div class="container">
            <span class="pull-left page-title">{{ $campaign->name }}</span>
            <div class="pull-right page-info">
                CAMPAIGN#
                <span class="field-nid state_{{ $campaign->state }}"> {{ $campaign->id }}</span> |
                <span class="page-info-text"><i>Created:</i></span> {{ date('m/d/Y H:i:s', strtotime($campaign->created_at)) }}
                |
                @if (\Auth::user()->isType(['support', 'admin', 'junior_designer', 'designer', 'art_director']) && $campaign->decorator_id)
                    <span class="page-info-text"><i>Decorator:</i></span> {{ $campaign->decorator->getFullName() }} |
                @endif
                <span class="page-info-text"><i>Due:</i></span> {{ $campaign->scheduled_date?date('m/d/Y', strtotime($campaign->scheduled_date)):'Pending' }}
                |
                <span class="page-info-text"><i>Campaign Status:</i></span>
                <span class="page-info-state">{!! campaign_state_caption($campaign->state, true, $campaign, Auth::user()) !!}</span>
            </div>
        </div>
    </div>
    @include ('partials.dashboard_tab')
    <div class="container">
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
    </div>
    <div class="container">
        @if ($campaignView->getBoth())
            <div class="row">
                <div class="col-md-12">
                    @foreach ($campaignView->getBoth() as $block)
                        @if ($block->isVisible())
                            {!! $block->handleBlock() !!}
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-4">
                @foreach ($campaignView->getLeft() as $block)
                    @if ($block->isVisible())
                        {!! $block->handleBlock() !!}
                    @endif
                @endforeach
            </div>
            <div class="col-md-8">
                @foreach ($campaignView->getRight() as $block)
                    @if ($block->isVisible())
                        {!! $block->handleBlock() !!}
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section ('javascript')
    <script type="text/javascript">
        $(".order-detail-page").click(function (event) {
            event.preventDefault();
            $.fancybox({
                padding: 0,
                margin: 0,
                width: $(this).attr('data-width') ? $(this).attr('data-width') : '700px',
                height: 'auto',
                autoSize: false,
                href: $(this).attr('href'),
                type: 'ajax',
                scrolling: 'auto',
                wrapCSS: 'custom-detail-page',

            });
            return false;
        });
        $(".approve-design").click(function (event) {
            event.preventDefault();
            $.fancybox({
                padding: 0,
                margin: 0,
                width: $(this).attr('data-width') ? $(this).attr('data-width') : '700px',
                height: 'auto',
                autoSize: false,
                href: $(this).attr('href'),
                type: 'ajax',
                scrolling: 'auto',
                wrapCSS: 'custom-detail-page',
                closeClick  : false,
                helpers     : {
                    overlay : {closeClick: false}
                },
                keys : {
                    close  : null
                },
                'closeBtn':false
            });
            return false;
        });
        $(document).ready(function () {
            $(".userfancybox").click(function (event) {
                event.preventDefault();
                $.fancybox({
                    padding: 0,
                    margin: 0,
                    width: 'auto',
                    height: 'auto',
                    autoSize: true,
                    href: $(this).attr('href'),
                    type: 'ajax',
                    scrolling: 'auto',
                    wrapCSS: 'custom-detail-page transparent-panel'
                });
                return false;
            });
        });
        @if ($popup)
        $(document).ready(function () {
            $('.{{ $popup }}.order-detail-page').click();
        });
        @endif
    </script>
@append