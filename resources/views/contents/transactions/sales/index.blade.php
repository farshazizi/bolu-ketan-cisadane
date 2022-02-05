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
                        <div class="buttons">
                            <a href="{{ route('sales.create') }}" class="btn btn-primary">Tambah Penjualan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
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
@endsection

@section('content-js')
    <script type="text/javascript">
        var dataRoute = "{{ route('sales.data') }}";
        var destroyRoute = "{{ route('sales.destroy', ':id') }}";
    </script>
    <script src="{{ asset(mix('js/contents/transactions/sales/sale.js')) }}"></script>
@endsection
