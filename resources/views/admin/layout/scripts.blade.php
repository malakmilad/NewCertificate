<script>
    var hostUrl = "assets/";
</script>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('assets/js/custom/modals/create-app.js') }}"></script>
<script src="{{ asset('assets/js/custom/modals/upgrade-plan.js') }}"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
@include('sweetalert::alert')
@stack('script')
