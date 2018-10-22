@extends('v2.layouts.campaign')

@section('title', $campaign->name)

@section ('content')
    <div class="container">
        @include ('v2.customer.dashboard.campaign_tab')
        @if ($campaignView->getBoth())
            <div class="row flex-lg-row flex-column-reverse">
                <div class="col-lg-12">
                    @foreach ($campaignView->getBoth() as $block)
                        @if ($block->isVisible())
                            {!! $block->handleBlock() !!}
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-3 campaign__left">
                @foreach ($campaignView->getLeft() as $block)
                    @if ($block->isVisible())
                        {!! $block->handleBlock() !!}
                    @endif
                @endforeach
            </div>
            <div class="col-lg-9">
                @foreach ($campaignView->getRight() as $block)
                    @if ($block->isVisible())
                        {!! $block->handleBlock() !!}
                    @endif
                @endforeach
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach ($campaignView->getRightTabs() as $tab)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $tab->id }}-tab" data-toggle="tab" href="#{{ $tab->id }}" role="tab" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $tab->caption }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content" id="myTabContent">
                    @foreach ($campaignView->getRightTabs() as $tab)
                        <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="{{ $tab->id }}" role="tabpanel">
                            @foreach ($tab->blocks as $block)
                                @if ($block->isVisible())
                                    {!! $block->handleBlock() !!}
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
