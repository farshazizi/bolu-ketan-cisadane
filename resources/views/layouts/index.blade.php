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
    <link rel="stylesheet"
        href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
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
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2021 &copy; Bolu Ketan Cisadane</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with
                            <span class="text-danger">
                                <i class="bi bi-heart"></i>
                            </span> by Farsha Azizi</a>
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>

    <!-- Jquery Datatable -->
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <!-- End Jquery Datatable -->

    <!-- Jquery -->
    <script src="{{ asset('assets/vendors/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery/jquery.inputmask.min.js') }}"></script>
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
        $(function() {
            // Call function mask currency
            maskCurrency();
        });

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
