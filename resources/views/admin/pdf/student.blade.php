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
            background-image: url('{{ public_path($templateId->image) }}');
        }

        #course {
            position: absolute;
            top: {{ number_format($templateId->options['course']['position_percent_y'], 2) }}%;
            left: {{ number_format($templateId->options['course']['position_percent_x'], 2) }}%;
            color: {{ $templateId->options['course']['color'] }};
            font-size: {{ $templateId->options['course']['font_size'] }}px;
            font-family: {{ $templateId->options['course']['font_family'] }};
            direction: rtl;
        }

        #student {
            position: absolute;
            top: {{ number_format($templateId->options['student']['position_percent_y'], 2) }}%;
            left: {{ number_format($templateId->options['student']['position_percent_x'], 2) }}%;
            color: {{ $templateId->options['student']['color'] }};
            font-size: {{ $templateId->options['student']['font_size'] }}px;
            font-family: {{ $templateId->options['student']['font_family'] }};
            direction: rtl;
        }

        #qrImg {
            position: absolute;
            top: {{ number_format($templateId->options['qr_code']['position_percent_y'], 2) }}%;
            left: {{ number_format($templateId->options['qr_code']['position_percent_x'], 2) }}%;
            width: 75px;
            height: 75px;
        }

        #date {
            position: absolute;
            top: {{ number_format($templateId->options['date']['position_percent_y'], 2) }}%;
            left: {{ number_format($templateId->options['date']['position_percent_x'], 2) }}%;
            color: {{ $templateId->options['date']['color'] }};
            font-size: {{ $templateId->options['date']['font_size'] }}px;
            font-family: {{ $templateId->options['date']['font_family'] }};
        }
    </style>
</head>

<body>
    <div id="canvas" class="card-img-top">
        <div id="student">{{ $studentName }}</div>
        <div id="course">{{ $courseName }}</div>
        <div id="date">{{ $templateId->options['date']['content'] }}</div>
        <img id="qrImg" src="https://quickchart.io/qr?text={{url('scan/'.Hashids::encode($studentId))}}"></img>
    </div>
</body>

</html>
