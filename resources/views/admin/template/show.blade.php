@extends('admin.layout.app')
@push('css')
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
                width: 100px;
                heigth: 100px;
            }
        @endforeach
        #canvas {
            position: relative;
            width: 100%;
            height: 700px;
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
        }

        #student {
            position: absolute;
            top: {{ number_format($template->options['student']['position_percent_y'], 2) }}%;
            left: {{ number_format($template->options['student']['position_percent_x'], 2) }}%;
            color: {{ $template->options['student']['color'] }};
            font-size: {{ $template->options['student']['font_size'] }}px;
            font-family: {{ $template->options['student']['font_family'] }};
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
@endpush
@section('content')
    <div class="card">
        <div id="canvas" class="card-img-top">
            <div id="student">{{ $template->options['student']['content'] }}</div>
            <div id="course">{{ $template->options['course']['content'] }}</div>
            <div id="date">{{ $template->options['date']['content'] }}</div>
            <img id="qrImg" src="{{ $template->options['qr_code']['content'] }}"></img>
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
                <img id="signature{{ $key }}" src="{{asset($signature['content'])}}"></img>
            @endforeach
        </div>
    </div>
@endsection
