@extends('admin.layout.app')
@section('content')
    <div class="row gy-5 g-xl-8">
        <div class="col-xl-12">
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Student</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Over</span>
                    </h3>
                    <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                        title="Click to add a Generate">
                        <a class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_invite_friends">
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                        transform="rotate(-90 11.364 20.364)" fill="black" />
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                        fill="black" />
                                </svg>
                            </span>
                            New Generate</a>
                    </div>
                </div>
                <div class="card-body py-3">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fw-bolder text-muted">
                                    <th class="w-25px">ID</th>
                                    <th class="min-w-150px">Name</th>
                                    <th class="min-w-150px">Email</th>
                                    <th class="min-w-150px">Uuid</th>
                                    <th class="min-w-150px">Phone</th>
                                    <th class="min-w-150px">Courses</th>
                                    <th class="min-w-150px">Template</th>
                                    <th class="min-w-100px text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td>{{ $student['id'] }}</td>
                                    <td>{{ $student['name'] }}</td>
                                    <td>{{ $student['email'] }}</td>
                                    <td>{{ $student['uuid'] }}</td>
                                    <td>{{ $student['phone'] }}</td>
                                    <td>
                                            @foreach($student['courses'] as $course)
                                            <span class="badge badge-light-danger">{{ $course }}</span>

                                            @endforeach
                                    </td>
                                    <td>{{ $student['template'] }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-primary">Edit</button>
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
    @include('admin.groupTemplate.create')
@endsection
