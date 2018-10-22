<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin Area</title>

    <link href="{{ static_asset('admin-resources/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ static_asset('admin-resources/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ static_asset('admin-resources/sb-admin2/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ static_asset('admin-resources/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ static_asset('admin-resources/custom/style.css') . '?v=' . config('greekhouse.css_version') }}" rel="stylesheet" type="text/css">

    <!--[if lt IE 9]>
    <script src="{{ static_asset('js/html5shiv.min.js') }}"></script>
    <script src="{{ static_asset('js/respond.min.js') }}"></script>
    <![endif]-->

    <link href="{{ static_asset('fonts/stylesheet.css') }}" rel="stylesheet">
</head>
<body>
    <?php
    function rem($rem)
    {
        return round(13 * $rem, 2) . 'px';
    }
    function rem_text($rem)
    {
        return $rem . 'rem (' . round(13 * $rem, 2) . 'px)';
    }
    function font_spacing($spacing)
    {
        return 'letter-spacing: ' . $spacing . 'px;';
    }
    function font_size($size)
    {
        return 'font-size: ' . rem($size) . ';';
    }

    $fontAvenir = 'font-family: "Avenir Next W1G", "Helvetica Neue", Helvetica, Arial, sans-serif;';
    $fontRockwell = 'font-family: Rockwell, "Courier New", Courier, Georgia, Times, "Times New Roman", serif;';

    $fontBlue = 'color: #00a4d8;';
    $fontWhite = 'color: #fff;';
    $fontStaleGrey = 'color: #6e6e70;';
    $fontSpaceGrey = 'color: #65737e;';
    $fontBlack = 'color: #313131;';

    $upper = 'text-transform: uppercase;';


    ?>
    <style>
        .style-color {
            display: inline-block;
            padding: 5px;
            border-radius: 5px;
            margin: 5px;
            border: 1px solid #333;
            width: 120px;
        }

        .style-white {
            background: #ffffff;
            color: #333;
        }

        .style-blue {
            background: #00a4d8;
            color: white;
        }

        .style-blue-darker {
            background: #0083be;
            color: white;
        }

        .style-blue-darker2 {
            background: #0075ab;
            color: white;
        }

        .style-grey {
            background: #e5e5e5;
            color: #333;
        }

        .style-stale-grey {
            background: #6e6e70;
            color: white;
        }

        .style-space-grey {
            background: #65737e;
            color: white;
        }

        .style-black {
            background: #313131;
            color: white;
        }

        .style-soft-green {
            background: #6fc077;
            color: #333;
        }

        .style-soft-green-filler {
            background: #def4e0;
            color: #333;
        }

        .typography {
            margin-bottom: 4rem;
        }

    </style>
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Styles</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Colors
                    </div>
                    <div class="panel-body">
                        <div class="style-color style-white">white<br/>#fff</div>
                        <div class="style-color style-blue">blue<br/>#00a4d8</div>
                        <div class="style-color style-blue-darker">blue-darker<br/>#0083be</div>
                        <div class="style-color style-blue-darker"2>blue-darker2<br/>#0075ab</div>
                        <div class="style-color style-grey">grey<br/>#e5e5e5</div>
                        <div class="style-color style-stale-grey">stale-grey<br/>#6e6e70</div>
                        <div class="style-color style-space-grey">space-grey<br/>#65737e</div>
                        <div class="style-color style-black">black<br/>#313131</div>
                        <div class="style-color style-soft-green">soft-green<br/>#6fc077</div>
                        <div class="style-color style-soft-green-filler">soft-green-filler<br/>#def4e0</div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Sizes
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>/</th>
                                <th>base</th>
                                <th>lg</th>
                                <th>md</th>
                                <th>sm</th>
                                <th>xs</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>font-size-base</th>
                                <td style="font-size: 13px">13px</td>
                                <td style="font-size: 13px">13px</td>
                                <td style="font-size: 13px">13px</td>
                                <td style="font-size: 13px">13px</td>
                                <td style="font-size: 13px">13px</td>
                            </tr>
                            <tr>
                                <th>font-size-small</th>
                                <td style="font-size: {{ rem(0.8) }}">{{ rem_text(0.8) }}</td>
                                <td style="font-size: {{ rem(0.8) }}">{{ rem_text(0.8) }}</td>
                                <td style="font-size: {{ rem(0.8) }}">{{ rem_text(0.8) }}</td>
                                <td style="font-size: {{ rem(0.8) }}">{{ rem_text(0.8) }}</td>
                                <td style="font-size: {{ rem(0.8) }}">{{ rem_text(0.8) }}</td>
                            </tr>
                            <tr>
                                <th>font-size-regular</th>
                                <td style="font-size: {{ rem(1) }}">{{ rem_text(1) }}</td>
                                <td style="font-size: {{ rem(1) }}">{{ rem_text(1) }}</td>
                                <td style="font-size: {{ rem(1) }}">{{ rem_text(1) }}</td>
                                <td style="font-size: {{ rem(1) }}">{{ rem_text(1) }}</td>
                                <td style="font-size: {{ rem(1) }}">{{ rem_text(1) }}</td>
                            </tr>
                            <tr>
                                <th>font-size-large</th>
                                <td style="font-size: {{ rem(1.6) }}">{{ rem_text(1.6) }}</td>
                                <td style="font-size: {{ rem(1.4) }}">{{ rem_text(1.4) }}</td>
                                <td style="font-size: {{ rem(1.2) }}">{{ rem_text(1.2) }}</td>
                                <td style="font-size: {{ rem(1.2) }}">{{ rem_text(1.2) }}</td>
                                <td style="font-size: {{ rem(1.2) }}">{{ rem_text(1.2) }}</td>
                            </tr>
                            <tr>
                                <th>font-size-header-xs</th>
                                <td style="font-size: {{ rem(1.5) }}">{{ rem_text(1.5) }}</td>
                                <td style="font-size: {{ rem(1.4) }}">{{ rem_text(1.4) }}</td>
                                <td style="font-size: {{ rem(1.3) }}">{{ rem_text(1.3) }}</td>
                                <td style="font-size: {{ rem(1.2) }}">{{ rem_text(1.2) }}</td>
                                <td style="font-size: {{ rem(1.2) }}">{{ rem_text(1.2) }}</td>
                            </tr>
                            <tr>
                                <th>font-size-sub-header</th>
                                <td style="font-size: {{ rem(2) }}">{{ rem_text(2) }}</td>
                                <td style="font-size: {{ rem(1.7) }}">{{ rem_text(1.7) }}</td>
                                <td style="font-size: {{ rem(1.5) }}">{{ rem_text(1.5) }}</td>
                                <td style="font-size: {{ rem(1.5) }}">{{ rem_text(1.5) }}</td>
                                <td style="font-size: {{ rem(1.5) }}">{{ rem_text(1.5) }}</td>
                            </tr>
                            <tr>
                                <th>font-size-header</th>
                                <td style="font-size: {{ rem(1.85) }}">{{ rem_text(1.85) }}</td>
                                <td style="font-size: {{ rem(1.85) }}">{{ rem_text(1.85) }}</td>
                                <td style="font-size: {{ rem(1.8) }}">{{ rem_text(1.8) }}</td>
                                <td style="font-size: {{ rem(1.6) }}">{{ rem_text(1.6) }}</td>
                                <td style="font-size: {{ rem(1.6) }}">{{ rem_text(1.6) }}</td>
                            </tr>
                            <tr>
                                <th>font-size-large-header</th>
                                <td style="font-size: {{ rem(2.35) }}">{{ rem_text(2.35) }}</td>
                                <td style="font-size: {{ rem(2) }}">{{ rem_text(2) }}</td>
                                <td style="font-size: {{ rem(1.8) }}">{{ rem_text(1.8) }}</td>
                                <td style="font-size: {{ rem(1.6) }}">{{ rem_text(1.6) }}</td>
                                <td style="font-size: {{ rem(1.6) }}">{{ rem_text(1.6) }}</td>
                            </tr>
                            <tr>
                                <th>font-size-extra-large-header</th>
                                <td style="font-size: {{ rem(4.3) }}">{{ rem_text(4.3) }}</td>
                                <td style="font-size: {{ rem(3.5) }}">{{ rem_text(3.5) }}</td>
                                <td style="font-size: {{ rem(2.5) }}">{{ rem_text(2.5) }}</td>
                                <td style="font-size: {{ rem(2.2) }}">{{ rem_text(2.2) }}</td>
                                <td style="font-size: {{ rem(2) }}">{{ rem_text(2) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Typography
                    </div>
                    <div class="panel-body">
                        <div class="typography">
                            <h4>rockwell-extra-large-header</h4>
                            <p style="{{ $fontRockwell }} {{ $fontBlue }} {{ font_spacing(6.5) }} {{ $upper }} {{ font_size(4.3) }}">Lorem ipsum dolor sit amet, usu te sale ridens lucilius.</p>
                            <span>Rockwell; blue; 6.5px; upper; font-size-extra-large-header</span>
                        </div>
                        <div class="typography">
                            <h4>rockwell-extra-large-header-reversed</h4>
                            <p style="background-color: #00a4d8; {{ $fontRockwell }} {{ $fontWhite }} {{ font_spacing(6.5) }} {{ $upper }} {{ font_size(4.3) }}">Lorem ipsum dolor sit amet, usu te sale
                                ridens lucilius.</p>
                            <span>Rockwell; white; 6.5px; upper; font-size-extra-large-header</span>
                        </div>
                        <div class="typography">
                            <h4>rockwell-large-header</h4>
                            <p style="{{ $fontRockwell }} {{ $fontBlue }} {{ font_spacing(6.5) }} {{ $upper }} {{ font_size(2.35) }}">Lorem ipsum dolor sit amet, usu te sale ridens lucilius.</p>
                            <span>Rockwell; blue; 6.5px; upper; font-size-large-header</span>
                        </div>
                        <div class="typography">
                            <h4>rockwell-standard-header</h4>
                            <p style="{{ $fontRockwell }} {{ $fontBlue }} {{ font_spacing(3.5) }} {{ $upper }} {{ font_size(1.85) }}">Lorem ipsum dolor sit amet, usu te sale ridens lucilius.</p>
                            <span>Rockwell; blue; 3.5px; upper; font-size-header</span>
                        </div>
                        <div class="typography">
                            <h4>rockwell-sub-header</h4>
                            <p style="{{ $fontRockwell }} {{ $fontStaleGrey }} {{ font_spacing(3) }} {{ $upper }} {{ font_size(2) }}">Lorem ipsum dolor sit amet, usu te sale ridens lucilius.</p>
                            <span>Rockwell; stale-grey; 3px; upper; font-size-sub-header</span>
                        </div>
                        <div class="typography">
                            <h4>rockwell-xs-header</h4>
                            <p style="{{ $fontRockwell }} {{ $fontBlack }} {{ font_spacing(2) }} {{ $upper }} {{ font_size(1.5) }}">Lorem ipsum dolor sit amet, usu te sale ridens lucilius.</p>
                            <span>Rockwell; black; 3px; upper; font-size-header-xs</span>
                        </div>
                        <div class="typography">
                            <h4>avenir-regular-large</h4>
                            <p style="{{ $fontAvenir }} {{ $fontBlack }} {{ font_spacing(0.75) }} {{ font_size(1.6) }}">Lorem ipsum dolor sit amet, usu te sale ridens lucilius.</p>
                            <span>Rockwell; black; 3px; upper; font-size-large</span>
                        </div>
                        <div class="typography">
                            <h4>avenir-regular-large-reversed</h4>
                            <p style="background-color: #00a4d8; {{ $fontAvenir }} {{ $fontWhite }} {{ font_spacing(0.75) }} {{ font_size(2) }}">Lorem ipsum dolor sit amet, usu te sale
                                ridens
                                lucilius.</p>
                            <span>Rockwell; white; 3px; upper; font-size-large</span>
                        </div>
                        <div class="typography">
                            <h4>avenir-regular-space</h4>
                            <p style="{{ $fontAvenir }} {{ $fontSpaceGrey }} {{ font_spacing(0.75) }} {{ font_size(1) }}">Lorem ipsum dolor sit amet, usu te sale ridens lucilius.</p>
                            <span>Rockwell; stale-grey; 3px; upper; font-size-regular</span>
                        </div>
                        <div class="typography">
                            <h4>avenir-regular</h4>
                            <p style="{{ $fontAvenir }} {{ $fontBlack }} {{ font_spacing(0.75) }} {{ font_size(1) }}">Lorem ipsum dolor sit amet, usu te sale ridens lucilius.</p>
                            <span>Rockwell; black; 3px; upper; font-size-regular</span>
                        </div>
                        <div class="typography">
                            <h4>avenir-regular-reversed</h4>
                            <p style="background-color: #00a4d8; {{ $fontAvenir }} {{ $fontWhite }} {{ font_spacing(0.75) }} {{ font_size(1) }}">Lorem ipsum dolor sit amet, usu te sale
                                ridens
                                lucilius.</p>
                            <span>Rockwell; white; 3px; upper; font-size-regular</span>
                        </div>
                        <div class="typography">
                            <h4>avenir-small</h4>
                            <p style="{{ $fontAvenir }} {{ $fontBlack }} {{ font_spacing(0.75) }} {{ font_size(0.8) }}">Lorem ipsum dolor sit amet, usu te sale ridens lucilius.</p>
                            <span>Rockwell; black; 0.75px; upper; font-size-small</span>
                        </div>
                        <div class="typography">
                            <h4>avenir-minor-header</h4>
                            <p style="{{ $fontAvenir }} {{ $fontBlack }} {{ font_spacing(0.75) }} {{ font_size(1) }}">Lorem ipsum dolor sit amet, usu te sale ridens lucilius.</p>
                            <span>Rockwell; black; 0.75px; upper; font-size-regular</span>
                        </div>
                        <div class="typography">
                            <h4>avenir-minor-header-selected</h4>
                            <p style="{{ $fontAvenir }} {{ $fontBlack }} {{ font_spacing(1) }} {{ font_size(1) }}">Lorem ipsum dolor sit amet, usu te sale ridens lucilius.</p>
                            <span>Rockwell; black; 1px; upper; font-size-regular</span>
                        </div>
                        <div class="typography">
                            <h4>avenir-minor-header-deselected</h4>
                            <p style="{{ $fontAvenir }} {{ $fontStaleGrey }} {{ font_spacing(1.2) }} {{ font_size(1) }}">Lorem ipsum dolor sit amet, usu te sale ridens lucilius.</p>
                            <span>Rockwell; stale-grey; 1.2px; upper; font-size-regular</span>
                        </div>
                        <div class="typography">
                            <h4>avenir-caption</h4>
                            <p style="{{ $fontAvenir }} {{ $fontBlack }} {{ font_spacing(1.25) }} {{ font_size(1.6) }}">Lorem ipsum dolor sit amet, usu te sale ridens lucilius.</p>
                            <span>Rockwell; black; 1.25px; upper; font-size-large</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>