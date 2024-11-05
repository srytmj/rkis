@php
    $users = Auth::user();
@endphp

@include('partials.head')

@include('partials.sidebar')

@include('partials.header')

<!-- Include DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<!-- Required Js -->
<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/ripple.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
<script src="{{ asset('assets/js/menu-setting.min.js') }}"></script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.2/js/dataTables.fixedColumns.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.2/js/fixedColumns.dataTables.js"></script>
<script src="https://cdn.datatables.net/select/2.1.0/js/dataTables.select.js"></script>
<script src="https://cdn.datatables.net/select/2.1.0/js/select.dataTables.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.2/css/fixedColumns.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/2.1.0/css/select.dataTables.css">
@yield('content')


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

{{-- @include('partials.footer') --}}

<script>
    $(document).ready(function() {
        $('#userAccessMenuTable').DataTable();
    });
</script>
