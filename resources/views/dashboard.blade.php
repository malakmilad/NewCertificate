@extends('admin.layout.app')
@section('content')
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-15">
            <div  class="mb-10 pt-lg-10">
                <img alt="Logo" src="{{asset('assets/media/logos/logo.png')}}" class="h-40px mb-5" />
            </div>
            <div class="pt-lg-10 mb-10">
                <h1 class="fw-bolder fs-2qx text-gray-800 mb-7">Welcome {{Auth::user()->name}} to EEIC</h1>
                <div class="fw-bold fs-3 text-muted mb-15">Plan your Certificate .</div>
            </div>
            <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url({{asset('assets/media/illustrations/10.png')}}"></div>
        </div>
    </div>
</div>
@endsection
