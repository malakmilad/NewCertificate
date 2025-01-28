@extends('admin.layout.app')
@push('css')
<style>
    #student{
        position: absolute;
        left:{{old('student_x')}}px;
        top:{{old('student_y')}}px;
        color:{{old('student_color')}};
        font-size:{{old('student_font_size')}}px;
        font-family:{{old('student_font_family')}};
        font-weight:normal;
        font-style:normal;
    }
    #course{
        position: absolute;
        left:{{old('course_x')}}px;
        top:{{old('course_y')}}px;
        color:{{old('course_color')}};
        font-size:{{old('course_font_size')}}px;
        font-family:{{old('course_font_family')}};
        font-weight:normal;
        font-style:normal;
    }
    #date{
        position: absolute;
        left:{{old('date_x')}}px;
        top:{{old('date_y')}}px;
        color:{{old('date_color')}};
        font-size:{{old('date_font_size')}}px;
    }
    #canvas{
        position: relative;
        width: 100%;
        height: 470px;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        overflow: hidden;
        background-image: url({{asset('assets/media/illustrations/placeholder.jpg')}});
    }
</style>
@endpush
@section('content')
    <form action="{{route('template.store')}}" method="POST" enctype="multipart/form-data" >
        @csrf
        <button class="btn btn-light-primary mb-10">Save</button>
        <div class="row gy-5 g-xl-8">
            <div class="col-xl-8">
                <div class="card card-xl-stretch mb-5 mb-xl-8">
                    <div id="canvas" class="card-body py-3">
                        <div id="student">{{old('student_content')}}</div>
                        <div id="course">{{old('course_content')}}</div>
                        <div id="date">{{old('date_content')}}</div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.template.options')
        {{-- @include('admin.template.error') --}}
    </form>
@endsection
@push('script')
<script src="{{asset('assets/template/create.js')}}"></script>
<script>
    let fonts =
        @php
            echo json_encode($fonts);
        @endphp
</script>
<script src="{{asset('assets/template/text.js')}}"></script>
<script src="{{asset('assets/template/signature.js')}}"></script>

@endpush
