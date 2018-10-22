@extends ('customer')

@section ('title', 'Start Here - Choose Category')

@section ('content')
    @if (config('services.crazy_egg.enabled'))
        <script type="text/javascript">
            setTimeout(function(){var a=document.createElement("script");
                var b=document.getElementsByTagName("script")[0];
                a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0050/4238.js?"+Math.floor(new Date().getTime()/3600000);
                a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
        </script>
    @endif
    <img src="{{ static_asset('images/download.gif') }}" class="image-preload"/>
    <div class="container">
        @include ('partials.progress')
        <div class="form-header">
            <h1><i class="icon icon-squares"></i><span class="icon-text">Choose Category</span></h1>
            <hr/>
        </div>
        <form method="post" id="form">
            {!! csrf_field() !!}
            <input type="hidden" name="gender-id" id="gender-id" value="0"/>
            <div class="row text-center margin-bottom">
                <?php $i = 0; ?>
                @foreach($list as $category)
                    @if ($i%4 == 0 && $i != 0)
            </div>
            <div class="row text-center margin-bottom">
                @endif
                <div class="col-md-4 category-option no-float">
                    <div class="category-option-container">
                        <a href="#" class="link-submit" data-id="{{ $category->id }}" id="link-{{ $category->name }}">
                            <img src="{{ route('system::image', [$category->image_id]) }}" class="image-gender"/>
                        </a><br/>
                        <h2><span>{{ $category->name }}</span></h2>
                    </div>
                </div>
                <?php $i++; ?>
                @endforeach
            </div>
            <div class="action-row">
                <button type="submit" name="next" value="next" class="hidden">Next</button>
                <a type="submit" name="cancel" class="button-back btn btn-default back-btn">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@section ('javascript')
    <script>
        $('.link-submit').click(function (event) {
            event.preventDefault();
            $('#gender-id').val($(this).attr('data-id'));
            $('#form').submit();
            return false;
        });
    </script>
@append