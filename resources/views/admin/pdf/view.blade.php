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
            padding: 0;
            box-sizing: border-box;
        }

        body {
            position: relative;
            width: 100%;
            height: 100%;
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            overflow: hidden;
            background-image: url('{{ public_path($template->image) }}');
        }

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
