<!-- jQuery (wajib sebelum script custom yang pakai $/jQuery) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!--   Core JS Files   -->
<script src="{{ asset('template/js/core/popper.min.js') }}"></script>
<script src="{{ asset('template/js/core/bootstrap.bundle.min.js') }}"></script>

<!-- Plugin JS files (add as needed) -->
<script src="{{ asset('template/js/plugins/perfect-scrollbar.min.js') }}"></script> {{-- Example plugin --}}
{{-- <script src="{{ asset('template/js/plugins/smooth-scrollbar.min.js') }}"></script> --}} {{-- Example plugin --}}
{{-- <script src="{{ asset('template/js/plugins/chartjs.min.js') }}"></script> --}} {{-- Example plugin --}}

<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('template/js/material-dashboard.min.js?v=3.1.0') }}"></script>

<!-- DataTables JS CDN (hanya akan aktif jika ada tabel dengan id userTable) -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    const tableIds = [
        '#userTable',
        '#cutiTable',
        '#pegawaiTable',
        '#mutasiTable',
        '#rekrutmenTable',
        '#lamaranTable',
        '#absensiTable',
        '#rewardpunishmentTable',
        '#phkTable',
        '#resignTable'
    ];
    tableIds.forEach(function(id) {
        if ($(id).length) {
            $(id).DataTable({
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ entri per halaman",
                    "zeroRecords": "Tidak ada data ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "infoFiltered": "(disaring dari _MAX_ total entri)",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": ">",
                        "previous": "<"
                    },
                },
                searching: false
            });
        }
    });
});

// Tambahkan di layout/scripts.blade.php sebelum inisialisasi DataTables
$.fn.dataTable.ext.errMode = 'none';
</script>

<style>
@media print {
    .dataTables_length,
    .dataTables_filter,
    .dataTables_info,
    .dataTables_paginate,
    .dataTables_processing,
    .dt-buttons {
        display: none !important;
    }
}
</style>

@yield('scripts') 