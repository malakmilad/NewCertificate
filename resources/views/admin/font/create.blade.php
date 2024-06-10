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
                    <h1 class="mb-3">Create Font</h1>
                </div>
                <div class="separator d-flex flex-center mb-8">
                    <span class="text-uppercase bg-body fs-7 fw-bold text-muted px-3"></span>
                </div>
                <form action="{{ route('font.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="required form-label">Font File</label>
                    <input type="file" name="font_file" class="form-control form-control-solid mb-8" rows="3">
                    </input>
                    @error('font_file')
                        <div
                            class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-5 mt-5">
                            <div class="d-flex flex-column pe-0 pe-sm-10">
                                <span>{{ $message }}</span>
                            </div>
                        </div>
                    @enderror
                    <button type="submit" class="btn btn-light-primary fw-bolder w-100 mb-8">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
