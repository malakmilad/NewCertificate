<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layout.head')
</head>

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            @include('admin.layout.sidebar')
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                @include('admin.layout.navbar')
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <div id="kt_content_container" class="container-xxl">
                           @yield('content')
                        </div>
                    </div>
                </div>
                @include('admin.layout.footer')
            </div>
        </div>
    </div>
    @include('admin.layout.scroll_to_top')
    @include('admin.layout.scripts')
</body>

</html>
