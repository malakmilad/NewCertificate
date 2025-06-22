@extends('admin.layout.app')
@push('css')
    <style>
        @foreach ($template->options['texts'] as $index => $text)
            #text{{ $index }} {
                position: absolute;
                transform: translateX(25%);
                top: {{ $text['position_percent_y'] }}%;
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
            left: {{ $template->options['student']['position_percent_x'] }}%;
            color: {{ $template->options['student']['color'] }};
            font-size: {{ $template->options['student']['font_size'] }}px;
            font-family: {{ $template->options['student']['font_family'] }};

        }

        #qrImg {
            position: absolute;
            top: {{$template->options['qr_code']['position_percent_y']}}%;
            left: {{ $template->options['qr_code']['position_percent_x']}}%;
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
        <div id="canvas" class="card-img-top">
            <div id="student">{{ $template->options['student']['content'] }}</div>
            <div id="course">{{ $template->options['course']['content'] }}</div>
            <div id="date">{{ $template->options['date']['content'] }}</div>
            @if ($template->options['qr_code']['content'])
                <img id="qrImg" src="{{ $template->options['qr_code']['content'] }}"></img>
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
