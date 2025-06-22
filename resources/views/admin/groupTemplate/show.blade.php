@extends('admin.layout.app')
@push('css')
    <style>
        @foreach ($template->options['texts'] as $index => $text)
            #text{{ $index }} {
                position: absolute;
                transform: translateX(25%);
                top: {{ $text['position_percent_y']}}%;
                left: {{ $text['position_percent_x']}}%;
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
                left: {{ $signature['position_percent_x']}}%;
                width: 150px;
                height: 100px;
            }
        @endforeach
        #canvas {
            position: relative;
           width: 1123px;
height: 794px;
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
            overflow: hidden;
            background-image: url('{{ asset($template->image) }}');
        }

        #course {
            position: absolute;
            transform: translateX(-30%);
            top: {{ $template->options['course']['position_percent_y'] }}%;
            left: {{ $template->options['course']['position_percent_x'] }}%;
            color: {{ $template->options['course']['color'] }};
            font-size: {{ $template->options['course']['font_size'] }}px;
            font-family: {{ $template->options['course']['font_family'] }};
        }

        #student {
            position: absolute;
            transform: translateX(-25%);
            top: {{ $template->options['student']['position_percent_y'] }}%;
            left: {{ $template->options['student']['position_percent_x']}}%;
            color: {{ $template->options['student']['color'] }};
            font-size: {{ $template->options['student']['font_size'] }}px;
            font-family: {{ $template->options['student']['font_family'] }};
        }

        #qrImg {
            position: absolute;
            top: {{ $template->options['qr_code']['position_percent_y']}}%;
            left: {{ $template->options['qr_code']['position_percent_x'] }}%;
            width: 75px;
            height: 75px;
        }

        #date {
            position: absolute;
            top: {{ $template->options['date']['position_percent_y'] }}%;
            left: {{ $template->options['date']['position_percent_x'] }}%;
            color: {{ $template->options['date']['color'] }};
            font-size: {{ $template->options['date']['font_size'] }}px;
        }
    </style>
@endpush
@section('content')
    <div>
        <div class="card-body">
            <a href="{{ route('generate.download', [Hashids::encode($student->id), $course->id, $template->id, $group_id]) }}"
                class="btn btn-light-primary mb-10">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                    <path
                        d="M5.523 12.424q.21-.124.459-.238a8 8 0 0 1-.45.606c-.28.337-.498.516-.635.572l-.035.012a.3.3 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647q-.178.037-.356.078a21 21 0 0 0 .5-1.05 12 12 0 0 0 .51.858q-.326.048-.654.114m2.525.939a4 4 0 0 1-.435-.41q.344.007.612.054c.317.057.466.147.518.209a.1.1 0 0 1 .026.064.44.44 0 0 1-.06.2.3.3 0 0 1-.094.124.1.1 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a5 5 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.5.5 0 0 1 .145-.04c.013.03.028.092.032.198q.008.183-.038.465z" />
                    <path fill-rule="evenodd"
                        d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.7 11.7 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.86.86 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.84.84 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.8 5.8 0 0 0-1.335-.05 11 11 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.24 1.24 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a20 20 0 0 1-1.062 2.227 7.7 7.7 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103" />
                </svg>
                download
            </a>
        </div>
        <div id="canvas" class="card-img-top">
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
                <img id="signature{{ $key }}" src="{{ asset($signature['content']) }}"></img>
            @endforeach
        </div>
    </div>
@endsection
