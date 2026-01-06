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

        * {
            box-sizing: border-box;
        }

        body {
            width: 100vw;
            height: 100vh;
            margin: 0;
            padding: 0;
            font-family: 'Cairo', sans-serif;
            line-height: 1.8;
            direction: rtl;
            text-align: right;
            @php
                $imagePath = public_path($template->image);
                $imageData = base64_encode(file_get_contents($imagePath));
                $imageSrc = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;
            @endphp
            background-image: url('{{ $imageSrc }}');
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
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
                font-weight: 600;
                direction: rtl;
                line-height: 1.4;
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
            width: 100%;
            transform: translateX(-50%);
            text-align: center;
            top: {{ $template->options['course']['position_percent_y'] }}%;
            left: {{ $template->options['course']['position_percent_x'] }}%;
            color: {{ $template->options['course']['color'] }};
            font-size: {{ $template->options['course']['font_size'] }}px;
            font-family: {{ $template->options['course']['font_family'] }};
            font-weight: 700;
            direction: rtl;
            line-height: 1.4;
        }

        #student {
            position: absolute;
            transform: translateX(-25%);
            top: {{ $template->options['student']['position_percent_y'] }}%;
            left: {{ $template->options['student']['position_percent_x']}}%;
            color: {{ $template->options['student']['color'] }};
            font-size: {{ $template->options['student']['font_size'] }}px;
            font-family: {{ $template->options['student']['font_family'] }};
            font-weight: 700;
            direction: rtl;
            line-height: 1.4;
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
            font-family: {{ $template->options['date']['font_family'] ?? 'Cairo' }};
            font-weight: 600;
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
        @php
            $sigPath = public_path($signature['content']);
            if (file_exists($sigPath)) {
                $sigData = base64_encode(file_get_contents($sigPath));
                $sigSrc = 'data:image/' . pathinfo($sigPath, PATHINFO_EXTENSION) . ';base64,' . $sigData;
            } else {
                $sigSrc = '';
            }
        @endphp
        <img id="signature{{ $key }}" src="{{ $sigSrc }}"></img>
    @endforeach
</body>

</html>
