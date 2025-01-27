@extends('admin.layout.app')
@section('content')
    <div class="row gy-5 g-xl-8">
        <div class="col-xl-12">
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Templates</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Over {{ count($templates) }}</span>
                    </h3>
                    <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                        title="Click to add a Template">
                        <a href="{{ route('template.create') }}" class="btn btn-sm btn-light btn-active-primary">
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                        transform="rotate(-90 11.364 20.364)" fill="black" />
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                        fill="black" />
                                </svg>
                            </span>
                            New Template</a>
                    </div>
                </div>
                <div class="card-body py-3">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fw-bolder text-muted">
                                    <th class="w-25px">ID</th>
                                    <th class="min-w-150px">Name</th>
                                    <th class="min-w-100px text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($templates as $template)
                                    <tr>
                                        <td>
                                            {{ $template->id }}
                                        </td>
                                        <td>
                                            {{ $template->name }}
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-end flex-shrink-0">
                                                <a href="{{ route('template.show' , Hashids::encode($template->id)) }}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                                        <path
                                                            d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('template.delete' , Hashids::encode($template->id)) }}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none">
                                                            <path
                                                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                fill="black"></path>
                                                            <path opacity="0.5"
                                                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                fill="black"></path>
                                                            <path opacity="0.5"
                                                                d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                fill="black"></path>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
