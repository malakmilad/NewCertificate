<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layout.head')
    <style>
           #canvas {
            position: relative;
            width: 100%;
            height: 673px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            overflow: hidden;
            background-image: url('{{ asset($templateId->image) }}');
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

<body id="kt_body" class="bg-white position-relative">
    <div class="d-flex flex-column flex-root">
        <div class="mb-n10 mb-lg-n20 z-index-2">
            <div class="container">
                <div class="text-center mb-17">
                    <h3 class="fs-2hx text-dark mb-5" id="how-it-works">Welcome {{ $studentName }}</h3>
                </div>
                <div class="tns tns-default">
                    <div>
                        <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10">
                            <div id="canvas" class="card-rounded shadow mw-100">
                                <div id="student">{{ $studentName }}</div>
                                <div id="course">{{ $courseName }}</div>
                                <div id="date">{{ $templateId->options['date']['content'] }}</div>
                                <img id="qrImg" src="https://quickchart.io/qr?text={{url('scan/'.Hashids::encode($studentId))}}"></img>
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
