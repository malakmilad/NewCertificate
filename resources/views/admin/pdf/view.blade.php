<!DOCTYPE html>
<html lang="en">

<head>
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
        #canvas {
            position: relative;
            width: 100%;
            height: 395px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            overflow: hidden;
            background-image: url('{{ public_path($template->image) }}');
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
            font-family: {{ $template->options['date']['font_family'] }};
        }
    </style>
</head>

<body>
    <div id="canvas" class="card-img-top">
        <div id="student">{{ $student->name }}</div>
        <div id="course">{{ $student->courses[0]->name }}</div>
        <div id="date">{{ $template->options['date']['content'] }}</div>
        <img id="qrImg" src="https://quickchart.io/qr?text={{url('scan/'.$student->id)}}"></img>
    </div>
</body>

</html>
