<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bolu Ketan Cisadane</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <!-- Jquery Datatable -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
    <!-- End Jquery Datatable -->

    <!-- Sweet Alert 2 -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">
    <!-- End Sweet Alert 2 -->

    <!-- Select 2 -->
    <link href="{{ asset('assets/vendors/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendors/select2/select2-bootstrap4.min.css') }}" rel="stylesheet" />
    <!-- End Select 2 -->

    <!-- Vue -->
    <link href="{{ asset('assets/vendors/vue-datepicker/bootstrap-datetimepicker.css') }}" rel="stylesheet">
    <!-- End Vue -->

    <!-- Date picker: adapt the Bootstrap 3 based datetimepicker to the Bootstrap 5 theme -->
    <style>
        .bootstrap-datetimepicker-widget.dropdown-menu {
            z-index: 1060;
            width: 18em;
            padding: .5rem;
            border-radius: .5rem;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
        }

        .bootstrap-datetimepicker-widget table td,
        .bootstrap-datetimepicker-widget table th {
            border-radius: .375rem;
        }

        .bootstrap-datetimepicker-widget table td.active,
        .bootstrap-datetimepicker-widget table td.active:hover,
        .bootstrap-datetimepicker-widget table td span.active,
        .bootstrap-datetimepicker-widget table td span.active:hover {
            background-color: #435ebe;
            color: #fff;
        }

        .bootstrap-datetimepicker-widget table td.today:before {
            border-bottom-color: #435ebe;
        }

        .bootstrap-datetimepicker-widget .bi {
            font-size: .9rem;
        }
    </style>

    @yield('content-css')
</head>

<body>
    <div id="app">
        @include('layouts.sidebar')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                @yield('content-header')
            </div>
            <div class="page-content">
                @yield('content-body')
            </div>

            <footer>
                <div class="clearfix mb-0 footer text-muted">
                    <div class="float-start">
                        <p>2021 &copy; Bolu Ketan Cisadane</p>
                    </div>
                    <div class="float-end">
                        <p>Dibuat dengan
                            <span class="text-danger">
                                <i class="bi bi-heart"></i>
                            </span> oleh Farsha Azizi</a>
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>

    <script src="{{ asset('assets/js/mazer.js') }}"></script>

    <!-- Jquery Datatable -->
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <!-- End Jquery Datatable -->

    <!-- Jquery -->
    <script src="{{ asset('assets/vendors/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- End Jquery -->

    <!-- Sweet Alert 2 -->
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- End Sweet Alert 2 -->

    <!-- Moment -->
    <script src="{{ asset('assets/js/plugins/moment/moment.min.js') }}"></script>
    <!-- End Moment -->

    <!-- Select 2 -->
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <!-- End Select 2 -->

    <!-- Vue -->
    <script src="{{ asset('assets/vendors/vue/vue.js') }}"></script>
    <script src="{{ asset('assets/vendors/vue/axios.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/vue/custom-vue.js') }}"></script>
    <script src="{{ asset('assets/vendors/vue/vuex.js') }}"></script>
    <script src="{{ asset('assets/vendors/vue-datepicker/vue-bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/vue-datepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- End Vue -->

    <!-- Additional -->
    <script src="{{ asset('assets/js/plugins/money/formatUang.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/money/keyPressuang.js') }}"></script>
    <!-- End Additional -->

    <script type="text/javascript">
        // Indonesian labels for every DataTable; page scripts may still override single keys (e.g. emptyTable)
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                decimal: '',
                emptyTable: 'Tidak ada data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
                infoFiltered: '(disaring dari _MAX_ total data)',
                lengthMenu: 'Tampilkan _MENU_ data',
                loadingRecords: 'Memuat...',
                processing: 'Memproses...',
                search: 'Cari:',
                zeroRecords: 'Data tidak ditemukan',
                paginate: {
                    first: 'Pertama',
                    last: 'Terakhir',
                    next: 'Berikutnya',
                    previous: 'Sebelumnya'
                },
            }
        });

        $(function() {
            // Call function mask currency
            maskCurrency();

            // Runs after the page scripts (incl. Vue mount), so the pickers bind to the final DOM
            initDatePickers();
        });

        function initDatePickers() {
            moment.defineLocale('id', {
                months: 'Januari_Februari_Maret_April_Mei_Juni_Juli_Agustus_September_Oktober_November_Desember'.split('_'),
                monthsShort: 'Jan_Feb_Mar_Apr_Mei_Jun_Jul_Agt_Sep_Okt_Nov_Des'.split('_'),
                weekdays: 'Minggu_Senin_Selasa_Rabu_Kamis_Jumat_Sabtu'.split('_'),
                weekdaysShort: 'Min_Sen_Sel_Rab_Kam_Jum_Sab'.split('_'),
                weekdaysMin: 'Mg_Sn_Sl_Rb_Km_Jm_Sb'.split('_'),
                week: {
                    dow: 1,
                    doy: 4
                },
            });

            var options = {
                locale: 'id',
                useCurrent: false,
                icons: {
                    time: 'bi bi-clock',
                    date: 'bi bi-calendar',
                    up: 'bi bi-chevron-up',
                    down: 'bi bi-chevron-down',
                    previous: 'bi bi-chevron-left',
                    next: 'bi bi-chevron-right',
                    today: 'bi bi-calendar-check',
                    clear: 'bi bi-trash',
                    close: 'bi bi-x',
                },
            };

            // Inputs show DD-MM-YYYY (MM-YYYY for months) while the server and Vue keep ISO values.
            // Plain forms: the ISO value is submitted through a hidden input that takes over the name.
            // Vue forms: data-vue-model names the root data key the picker writes the ISO value to.
            $('.js-datepicker, .js-monthpicker').each(function() {
                var $input = $(this);
                var isMonth = $input.hasClass('js-monthpicker');
                var isoFormat = isMonth ? 'YYYY-MM' : 'YYYY-MM-DD';
                var vueModel = $input.data('vue-model');
                // Nearest ancestor Vue instance (layout and page may both use id="app", so don't rely on the id)
                var vm = null;
                if (vueModel) {
                    $input.parents().each(function() {
                        if (this.__vue__) {
                            vm = this.__vue__.$root;
                            return false;
                        }
                    });
                }
                var $hidden = null;

                if (!vm) {
                    $hidden = $('<input type="hidden">').attr('name', $input.attr('name')).val($input.val());
                    $input.removeAttr('name').after($hidden);
                }

                var initialValue = vm ? vm[vueModel] : $hidden.val();

                var displayFormat = isMonth ? 'MM-YYYY' : 'DD-MM-YYYY';
                $input.val('').datetimepicker($.extend({}, options, {
                    format: displayFormat,
                    viewMode: isMonth ? 'months' : 'days'
                }));
                var picker = $input.data('DateTimePicker');
                // Pass a display-format string: the plugin may not recognise moment objects from the global moment
                var setPickerDate = function(iso) {
                    picker.date(iso ? moment(iso, isoFormat).format(displayFormat) : null);
                };
                setPickerDate(initialValue);

                $input.on('dp.change', function(event) {
                    var iso = event.date ? event.date.format(isoFormat) : '';

                    if (vm) {
                        vm[vueModel] = iso;
                    } else {
                        $hidden.val(iso);
                    }
                });

                // Vue may set the date later (e.g. after loading an order)
                if (vm) {
                    vm.$watch(vueModel, function(iso) {
                        var current = picker.date();
                        if ((current ? current.format(isoFormat) : '') !== (iso || '')) {
                            setPickerDate(iso);
                        }
                    });
                }
            });

            // Clicking the calendar icon opens the picker too
            $('.js-datepicker, .js-monthpicker').siblings('.input-group-text').css('cursor', 'pointer').on('click', function() {
                $(this).siblings('input').data('DateTimePicker').show();
            });
        }

        // "2026-09-28" -> "28-09-2026", "2026-09" -> "09-2026"; used by Vue templates for read-only dates
        function formatDisplayDate(value) {
            if (!value) return '';
            var parts = String(value).slice(0, 10).split('-');
            return parts.reverse().join('-');
        }

        if (window.Vue) {
            Vue.filter('displayDate', formatDisplayDate);
        }

        function maskCurrency() {
            // Jquery inputmask
            $('.maskCurrency').inputmask({
                alias: 'decimal',
                allowMinus: true,
                digits: 0,
                digitsOptional: false,
                groupSeparator: ',',
                removeMaskOnSubmit: true,
                rightAlign: true,
            });
        }
    </script>

    @yield('content-js')
</body>

</html>
