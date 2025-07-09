<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @foreach ($fonts as $font)
        <style>
            @font-face {
                font-family: '{{ $font->name }}';
                src: url('{{ public_path($font->path) }}') format('truetype');
            }
        </style>
    @endforeach
    <style>
        @page {
            size: a4 landscape;
            margin: 0;
        }

        body {
            width: 1024px;
            height: 768px;
            background-image: url('{{ public_path($template->image) }}');
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
        }

        @foreach ($template->options['texts'] as $index => $text)
            #text{{ $index }} {
                position: absolute;
                transform: translateX(25%);
                top: {{ $text['position_percent_y'] }}%;
                left: {{ $text['position_percent_x'] }}%;
                color: {{ $text['color'] }};
                font-size: {{ $text['font_size'] }}px;
                font-family: {{ $text['font_family'] }};
                direction: rtl;
            }
        @endforeach
        @foreach ($template->options['signatures'] as $key => $signature)
            #signature{{ $key }} {
                position: absolute;
                top: {{ $signature['position_percent_y'] }}%;
                left: {{ $signature['position_percent_x'] }}%;
                width: 150px;
                height: 100px;
            }
        @endforeach
        #course {
            position: absolute;
            transform: translateX(-30%);
            top: {{ $template->options['course']['position_percent_y'] }}%;
            left: {{ $template->options['course']['position_percent_x'] }}%;
            color: {{ $template->options['course']['color'] }};
            font-size: {{ $template->options['course']['font_size'] }}px;
            font-family: {{ $template->options['course']['font_family'] }};
            direction: rtl;
        }

        #student {
            position: absolute;
            transform: translateX(-25%);
            top: {{ $template->options['student']['position_percent_y'] }}%;
            left: {{ $template->options['student']['position_percent_x']}}%;
            color: {{ $template->options['student']['color'] }};
            font-size: {{ $template->options['student']['font_size'] }}px;
            font-family: {{ $template->options['student']['font_family'] }};
            direction: rtl;
        }

        #qrImg {
            position: absolute;
            top: {{ $template->options['qr_code']['position_percent_y'] }}%;
            left: {{$template->options['qr_code']['position_percent_x'] }}%;
            width: 75px;
            height: 75px;
        }

        #date {
            position: absolute;
            top: {{ $template->options['date']['position_percent_y']}}%;
            left: {{ $template->options['date']['position_percent_x']}}%;
            color: {{ $template->options['date']['color'] }};
            font-size: {{ $template->options['date']['font_size'] }}px;
        }
    </style>
</head>

<body>
    <div id="student">{{ $student->name }}</div>
    <div id="course">{{ $course->name }}</div>
    <div id="date">{{ $template->options['date']['content'] }}</div>
    @if ($template->options['qr_code']['content'])
        <img id="qrImg"
            src="https://quickchart.io/qr?text={{ url('scan/' . Hashids::encode($student->id) . '/' . $course->id . '/' . $template->id) }}">
    @endif

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
        <img id="signature{{ $key }}" src="{{ public_path($signature['content']) }}"></img>
    @endforeach
</body>

</html>
