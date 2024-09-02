@extends('admin.layout.app')
@section('content')
    <div class="row gy-5 g-xl-8">
        <div class="col-xl-12">
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Student</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Over :{{count($students)}}</span>
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
                        <table id="generate" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fw-bolder text-muted">
                                    <th class="w-25px">ID</th>
                                    <th class="min-w-100px">Name</th>
                                    <th class="min-w-150px">Email</th>
                                    <th class="min-w-150px">NotionalID OR Passport</th>
                                    <th class="min-w-150px">Phone</th>
                                    <th class="min-w-150px">Courses</th>
                                    <th class="min-w-100px">Template</th>
                                    <th class="min-w-100px">Group</th>
                                    <th class="min-w-100px text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student['id'] }}</td>
                                        <td>{{ $student['name'] }}</td>
                                        <td>{{ $student['email'] }}</td>
                                        <td>{{ $student['uuid'] }}</td>
                                        <td>{{ $student['phone'] }}</td>
                                        <td><span class="badge badge-light-danger">{{ $student['course'] }}</span></td> <!-- Single course per row -->
                                        <td>{{ $student['template'] }}</td>
                                        <td>{{ $student['group']['name'] }}</td>
                                        <td>
                                            <div class="d-flex justify-content-end flex-shrink-0">
                                                <a href="{{ route('generate.show', [Hashids::encode($student['id']), $student['course_id'],$student['template_id']]) }}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                                        <path
                                                            d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
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
    @include('admin.groupTemplate.create')
@endsection
@push('script')
<script>
    new DataTable('#generate');
</script>
@endpush
