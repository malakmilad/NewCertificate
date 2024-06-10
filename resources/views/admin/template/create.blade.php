@extends('admin.layout.app')
@section('content')
    <form action="">
        <div class="row gy-5 g-xl-8">
            <div class="col-xl-8">
                <div class="card card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Members Statistics</span>
                        </h3>
                    </div>
                    <canvas id="canva" class="card-body py-3">
                    </canvas>
                </div>
            </div>
        </div>
        @include('admin.template.create_options')
    </form>
@endsection
