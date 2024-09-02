@extends('admin.layout.app')
@section('content')
    <div class="row gy-5 g-xl-8">
        <div class="col-xl-12">
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1"></span>
                        <span class="text-muted mt-1 fw-bold fs-7"></span>
                    </h3>
                </div>
                <div class="card-body py-3">
                    <div class="table-responsive">
                        <table id="group" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fw-bolder text-muted">
                                    <th class="w-25px">ID</th>
                                    <th class="min-w-150px">Name</th>
                                    <th class="min-w-150px">Email</th>
                                    <th class="min-w-150px">NotionalID OR Passport</th>
                                    <th class="min-w-150px">Phone</th>
                                    <th class="min-w-150px">Courses</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student->id }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->uuid }}</td>
                                        <td>{{ $student->phone }}</td>
                                        <td>
                                            @foreach ($student->enrollments as $enrollment)
                                                <span
                                                    class="badge badge-light-danger">{{ $enrollment->course->name }}
                                                </span>
                                            @endforeach
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
@push('script')
    <script>
        new DataTable('#group');
    </script>
@endpush
