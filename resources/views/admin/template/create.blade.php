@extends('admin.layout.app')
@push('css')
<style>
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
    #student{
        position: absolute;
    }
    #course{
        position: absolute;
    }
    #date{
        position: absolute;
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
                        <div id="student"></div>
                        <div id="course"></div>
                        <div id="date"></div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.template.options')
        @include('admin.template.error')
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
