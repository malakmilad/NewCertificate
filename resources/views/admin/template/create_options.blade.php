<button id="kt_explore_toggle"
    class="explore-toggle btn btn-sm bg-body btn-color-gray-700 btn-active-primary shadow-sm position-fixed px-5 fw-bolder zindex-2 top-50 mt-10 end-0 transform-90 fs-6 rounded-top-0"
    title="Options" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-trigger="hover">
    <span id="kt_explore_toggle_label">Options</span>
</button>
<div id="kt_explore" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="explore" data-kt-drawer-activate="true"
    data-kt-drawer-overlay="false" data-kt-drawer-width="{default:'350px', 'lg': '475px'}"
    data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_explore_toggle" data-kt-drawer-close="#kt_explore_close">
    <div class="card shadow-none rounded-0 w-100">
        <div class="card-header" id="kt_explore_header">
            <h3 class="card-title fw-bolder text-gray-700">Options</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_explore_close">
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>
        <div class="card-body" id="kt_explore_body">
            <div id="kt_explore_scroll" class="scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto"
                data-kt-scroll-wrappers="#kt_explore_body" data-kt-scroll-dependencies="#kt_explore_header"
                data-kt-scroll-offset="5px">
                <div class="mb-0">
                    <div class="rounded border border-dashed border-gray-300 py-4 px-6 mb-5">
                        <div>
                            <label class="required form-label">Template Name</label>
                            <input type="text" name="template_name" id="template_name"
                                placeholder="Enter Your Template Name" class="form-control">
                            @error('template_name')
                                <div
                                    class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-5 mt-5">
                                    <div class="d-flex flex-column pe-0 pe-sm-10">
                                        <span>{{ $message }}</span>
                                    </div>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="rounded border border-dashed border-gray-300 py-4 px-6 mb-5">
                        <div>
                            <label class="required form-label">Template Image</label>
                            <input type="file" name="template_image" id="template_image" class="form-control">
                            @error('template_image')
                                <div
                                    class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-5 mt-5">
                                    <div class="d-flex flex-column pe-0 pe-sm-10">
                                        <span>{{ $message }}</span>
                                    </div>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="rounded border border-dashed border-gray-300 py-4 px-6 mb-5">
                        <div>
                            <label class="required form-label">Qr Code</label>
                            <div class="btn btn-light-primary w-100" id="qrButton">Add</div>
                        </div>
                    </div>
                    <div class="rounded border border-dashed border-gray-300 py-4 px-6 mb-5">
                        <div>
                            <label class="required form-label">Text</label>
                            <div class="btn btn-light-primary w-100">Add</div>
                        </div>
                    </div>
                    <div class="rounded border border-dashed border-gray-300 py-4 px-6 mb-5">
                        <div>
                            <label class="required form-label">Signature</label>
                            <div class="btn btn-light-primary w-100">Add</div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <h3 class="fw-bolder text-center mb-6" style="color: #C70815;">
                            Student</h3>
                        <div class="row g-5">
                            <div class="col-6">
                                <label class="required form-label">Content</label>
                                <input type="text" placeholder="Enter Your Content" name="student_content"
                                    id="student_content" class="form-control">
                                @error('student_content')
                                    <div
                                        class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-5 mt-5">
                                        <div class="d-flex flex-column pe-0 pe-sm-10">
                                            <span>{{ $message }}</span>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="required form-label">Color</label>
                                <input type="color" class="form-control" name="student_color" id="student_color">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Font Size</label>
                                <input type="number" class="form-control" name="student_font_size"
                                    id="student_font_size" placeholder="Enter Your Font Size">
                                @error('student_font_size')
                                    <div
                                        class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-5 mt-5">
                                        <div class="d-flex flex-column pe-0 pe-sm-10">
                                            <span>{{ $message }}</span>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label">Font Family</label>
                                <select class="form-select form-select-solid" name="student_font_family"
                                    id="student_font_family">
                                    <option disabled selected value="">Select Font</option>
                                    @foreach ($fonts as $font)
                                        <option value="{{ $font->name }}">{{ $font->name }}</option>
                                    @endforeach
                                </select>
                                @error('student_font_family')
                                    <div
                                        class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-5 mt-5">
                                        <div class="d-flex flex-column pe-0 pe-sm-10">
                                            <span>{{ $message }}</span>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <input type="hidden" name="student_x" id="student_x">
                            <input type="hidden" name="student_y" id="student_y">
                        </div>
                    </div>
                    <div class="mb-5">
                        <h3 class="fw-bolder text-center mb-6" style="color: #C70815;">
                            Course</h3>
                        <div class="row g-5">
                            <div class="col-6">
                                <label class="required form-label">Content</label>
                                <input type="text" placeholder="Enter Your Content" name="course_content"
                                    id="course_content" class="form-control">
                                @error('course_content')
                                    <div
                                        class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-5 mt-5">
                                        <div class="d-flex flex-column pe-0 pe-sm-10">
                                            <span>{{ $message }}</span>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="required form-label">Color</label>
                                <input type="color" class="form-control" name="course_color" id="course_color">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Font Size</label>
                                <input type="number" class="form-control" name="course_font_size"
                                    id="course_font_size" placeholder="Enter Your Font Size">
                                @error('course_font_size')
                                    <div
                                        class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-5 mt-5">
                                        <div class="d-flex flex-column pe-0 pe-sm-10">
                                            <span>{{ $message }}</span>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label">Font Family</label>
                                <select class="form-select form-select-solid" name="course_font_family"
                                    id="course_font_family">
                                    <option disabled selected value="">Select Font</option>
                                    @foreach ($fonts as $font)
                                        <option value="{{ $font->name }}">{{ $font->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_font_family')
                                    <div
                                        class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-5 mt-5">
                                        <div class="d-flex flex-column pe-0 pe-sm-10">
                                            <span>{{ $message }}</span>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <input type="hidden" name="course_x" id="course_x">
                            <input type="hidden" name="course_y" id="course_y">
                        </div>
                    </div>
                    <div class="mb-5">
                        <h3 class="fw-bolder text-center mb-6" style="color: #C70815;">
                            Date</h3>
                        <div class="row g-5">
                            <div class="col-6">
                                <label class="required form-label">Content</label>
                                <input type="date" name="date_content" id="date_content" class="form-control">
                                @error('date_content')
                                    <div
                                        class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-5 mt-5">
                                        <div class="d-flex flex-column pe-0 pe-sm-10">
                                            <span>{{ $message }}</span>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="required form-label">Color</label>
                                <input type="color" class="form-control" name="date_color" id="date_color">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Font Size</label>
                                <input type="number" class="form-control" name="date_font_size" id="date_font_size"
                                    placeholder="Enter Your Font Size">
                                @error('date_font_size')
                                    <div
                                        class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-5 mt-5">
                                        <div class="d-flex flex-column pe-0 pe-sm-10">
                                            <span>{{ $message }}</span>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label">Font Family</label>
                                <select class="form-select form-select-solid" name="date_font_family"
                                    id="date_font_family">
                                    <option disabled selected value="">Select Font</option>
                                    @foreach ($fonts as $font)
                                        <option value="{{ $font->name }}">{{ $font->name }}</option>
                                    @endforeach
                                </select>
                                @error('date_font_family')
                                    <div
                                        class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-5 mt-5">
                                        <div class="d-flex flex-column pe-0 pe-sm-10">
                                            <span>{{ $message }}</span>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <input type="hidden" name="date_x" id="date_x">
                            <input type="hidden" name="date_y" id="date_y">
                            <input type="hidden" name="width" id="width">
                            <input type="hidden" name="height" id="height">
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
