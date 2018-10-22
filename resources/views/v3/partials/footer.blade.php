<footer class="container-fluid">
    <div class="container">
        <div class="float-left d-inline-block">
            <p>CopyRight @ 2015-{{ \Carbon\Carbon::now()->format('Y') }} | All Rights Reserved.</p>
        </div>
        <div class="float-right d-inline-block">
            <ul>
                <li><a href="mailto:support@greekhouse.org">Contact us</a></li>
                <li><a href="{{ route('home::privacy') }}">Privacy &amp; Policy</a></li>
                <li><a href="{{ route('home::tos') }}">Terms &amp; Conditions</a></li>
                <li><a href="https://greekhouse.zendesk.com/" target="_blank">Help</a></li>
            </ul>
        </div>
    </div>
</footer>
