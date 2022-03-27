@extends('layouts.index')

@section('content-header')
    <h3>Pesanan</h3>
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
                        <div class="buttons">
                            <a href="{{ route('orders.create') }}" class="btn btn-primary">Tambah Pesanan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No. Telepon</th>
                                    <th>Status</th>
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
@endsection

@section('content-js')
    <script type="text/javascript">
        var dataRoute = "{{ route('orders.data') }}";
        var destroyRoute = "{{ route('orders.destroy', ':id') }}";
    </script>
    <script src="{{ asset(mix('js/contents/transactions/orders/order.js')) }}"></script>
@endsection
