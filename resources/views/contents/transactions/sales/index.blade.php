@extends('layouts.index')

@section('content-header')
    <h3>Penjualan</h3>
    <style>
        .text-right {
            text-align: right;
        }

    </style>
@endsection

@section('content-body')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header ms-auto">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tambah Penjualan
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('sales.create') }}">Penjualan Baru</a>
                                <a class="dropdown-item" href="" data-bs-toggle="modal"
                                    data-bs-target="#orderModal">Penjualan Pesanan</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No. Invoice</th>
                                    <th>Penjualan</th>
                                    <th style="text-align: right">Grand Total</th>
                                    <th>Notes</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade text-left" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel18">Daftar Pesanan</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="orderIdChoosed" name="orderIdChoosed"/>
                    <table class="table" id="datatableOrder" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pesanan</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No.Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary" id="btnChooseOrder" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Pilih</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content-js')
    <script type="text/javascript">
        var dataRoute = "{{ route('sales.data') }}";
        var destroyRoute = "{{ route('sales.destroy', ':id') }}";
        var dataSaleOrdersRoute = "{{ route('sales.data_orders') }}";
        var createSaleOrderRoute = "{{ route('sales.create') }}";
    </script>
    <script src="{{ asset(mix('js/contents/transactions/sales/sale.js')) }}"></script>
@endsection
