<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layout.head')
    <style>
        @foreach ($template->options['texts'] as $index => $text)
            #text{{ $index }} {
                position: absolute;
                top: {{ number_format($text['position_percent_y'], 2) }}%;
                left: {{ number_format($text['position_percent_x'], 2) }}%;
                color: {{ $text['color'] }};
                font-size: {{ $text['font_size'] }}px;
                font-family: {{ $text['font_family'] }};
                direction: rtl;
            }
        @endforeach
        @foreach ($template->options['signatures'] as $key => $signature)
            #signature{{ $key }} {
                position: absolute;
                top: {{ number_format($signature['position_percent_y'], 2) }}%;
                left: {{ number_format($signature['position_percent_x'], 2) }}%;
                width: 200px;
                heigth: 100px;
            }
        @endforeach
        #canvas {
            position: relative;
            width: 100%;
            height: 673px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            overflow: hidden;
            background-image: url('{{ asset($template->image) }}');
        }
        #course {
            position: absolute;
            top: {{ number_format($template->options['course']['position_percent_y'], 2) }}%;
            left: {{ number_format($template->options['course']['position_percent_x'], 2) }}%;
            color: {{ $template->options['course']['color'] }};
            font-size: {{ $template->options['course']['font_size'] }}px;
            font-family: {{ $template->options['course']['font_family'] }};
            direction: rtl;
        }

        #student {
            position: absolute;
            top: {{ number_format($template->options['student']['position_percent_y'], 2) }}%;
            left: {{ number_format($template->options['student']['position_percent_x'], 2) }}%;
            color: {{ $template->options['student']['color'] }};
            font-size: {{ $template->options['student']['font_size'] }}px;
            font-family: {{ $template->options['student']['font_family'] }};
            direction: rtl;
        }

        #qrImg {
            position: absolute;
            top: {{ number_format($template->options['qr_code']['position_percent_y'], 2) }}%;
            left: {{ number_format($template->options['qr_code']['position_percent_x'], 2) }}%;
            width: 75px;
            height: 75px;
        }

        #date {
            position: absolute;
            top: {{ number_format($template->options['date']['position_percent_y'], 2) }}%;
            left: {{ number_format($template->options['date']['position_percent_x'], 2) }}%;
            color: {{ $template->options['date']['color'] }};
            font-size: {{ $template->options['date']['font_size'] }}px;
        }
    </style>
</head>

<body id="kt_body" class="bg-white position-relative">
    <div class="d-flex flex-column flex-root">
        <div class="mb-n10 mb-lg-n20 z-index-2">
            <div class="container">
                <div class="text-center mb-17">
                    <h3 class="fs-2hx text-dark mb-5" id="how-it-works">Welcome {{ $student->name }}</h3>
                </div>
                <div class="tns tns-default">
                    <div>
                        <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10">
                            <div id="canvas" class="card-rounded shadow mw-100">
                                <div id="student">{{ $student->name }}</div>
                                <div id="course">{{ $course->name }}</div>
                                <div id="date">{{ $template->options['date']['content'] }}</div>
                                <img id="qrImg" src="https://quickchart.io/qr?text={{ url('scan/' . Hashids::encode($student->id).'/'. $course->id.'/'.$template->id) }}">

                                @php
                                    $texts = $template->options['texts'];
                                @endphp
                                @foreach ($texts as $index => $text)
                                    <div id="text{{ $index }}">{{ $text['content'] }}</div>
                                @endforeach
                                @php
                                    $signatures = $template->options['signatures'];
                                @endphp
                                @foreach ($signatures as $key => $signature)
                                    <img id="signature{{ $key }}"
                                        src="{{ asset($signature['content']) }}"></img>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layout.scripts')
</body>

</html>
