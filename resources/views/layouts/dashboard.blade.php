@extends('layouts.index')

@section('content-header')
    <h3>Dashboard</h3>
@endsection

@section('content-body')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    @foreach ($stocks as $stock)
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="px-3 card-body py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon purple">
                                                @if ($stock['icon'])
                                                    <img src="{{ asset('storage/' . $stock['icon']) }}"
                                                        style="max-height: 32px; max-width: 32px" />
                                                @else
                                                    <i class="iconly-boldBag"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="font-semibold text-muted">Stok <b>{{ $stock['name'] }}</b></h6>
                                            <h6 class="mb-0 font-extrabold">{{ $stock['stock'] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="px-3 card-body py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon red">
                                            <i class="iconly-boldPaper"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="font-semibold text-muted">Saldo harian</h6>
                                        <h6 class="mb-0 font-extrabold">{{ $dailyBalance }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="px-3 card-body py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldPaper"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="font-semibold text-muted">Pembelian per hari</h6>
                                        <h6 class="mb-0 font-extrabold">{{ $grandTotalPurchase }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="px-3 card-body py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon green">
                                            <i class="iconly-boldPaper"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="font-semibold text-muted">Penjualan per hari</h6>
                                        <h6 class="mb-0 font-extrabold">{{ $grandTotalSale }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Reminder</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Nama</th>
                                                <th>Total Pesanan</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Modal order detail -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Detil Pesanan</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="orderDetailList"></div>
                    <input type="hidden" id="orderId" name="orderId" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal order detail -->
@endsection

@section('content-js')
    <script type="text/javascript">
        var dataRoute = "{{ route('dashboards.data') }}";
        var dataOrderDetailRoute = "{{ route('orders.details.data') }}";
    </script>
    <script src="{{ asset(mix('js/layouts/dashboard.js')) }}"></script>
@endsection
