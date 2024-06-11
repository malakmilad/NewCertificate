<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layout.head')
    <style>
    </style>
</head>

<body id="kt_body" class="bg-white position-relative">
    <div class="d-flex flex-column flex-root">
        <div class="mb-n10 mb-lg-n20 z-index-2">
            <div class="container">
                <div class="text-center mb-17">
                    <h3 class="fs-2hx text-dark mb-5" id="how-it-works">Welcome malak</h3>
                </div>
                <div class="tns tns-default">
                    <div>
                        <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10">
                            <div id="canvas" class="card-rounded shadow mw-100">
                                <div id="student">malak</div>
                                <div id="course">web</div>
                                <div id="date">20/20/2020</div>
                                <img id="qrImg" src="https://quickchart.io/qr?text=heelo"></img>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layout.scripts')
</body>

</html>
