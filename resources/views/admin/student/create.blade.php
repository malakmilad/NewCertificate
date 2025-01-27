<div class="modal fade" id="kt_modal_invite_friends" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                <div class="text-center mb-13">
                    <h1 class="mb-3">Add New Student To This Group</h1>
                </div>
                <div class="separator d-flex flex-center mb-8">
                    <span class="text-uppercase bg-body fs-7 fw-bold text-muted px-3"></span>
                </div>
                <form action="{{route('student.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="group_id" value={{$id}}>
                    <div class="row">
                        <div class="col-6">
                            <label class="required form-label">Name</label>
                            <input type="text" name="name" class="form-control form-control-solid mb-8" placeholder="Enter Student Name">
                            </input>
                        </div>
                        <div class="col-6">
                            <label class="required form-label">Email</label>
                            <input type="email" name="email" class="form-control form-control-solid mb-8" placeholder="Enter Student Email">
                            </input>
                        </div>
                        <div class="col-6">
                            <label class="required form-label">National ID OR Passport ID</label>
                            <input type="text" name="national_id" class="form-control form-control-solid mb-8" placeholder="Enter Student National ID">
                            </input>
                        </div>
                        <div class="col-6">
                            <label class="required form-label">Phone</label>
                            <input type="text" name="phone" class="form-control form-control-solid mb-8" placeholder="Enter Student Phone">
                            </input>
                        </div>
                        <div class="separator d-flex flex-center mb-8">
                            <span class="text-uppercase bg-body fs-7 fw-bold text-muted px-3"></span>
                        </div>
                        <div class="col-12 text-center">
                            <label class="required form-label">Course Name</label>
                            <input type="text" name="course_name" class="form-control form-control-solid mb-8" placeholder="Enter Course Name">
                            </input>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-light-primary fw-bolder w-100 mb-8">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
