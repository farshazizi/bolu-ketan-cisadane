@extends('layouts.index')

@section('content-header')
    <h3>Stok Masuk/Keluar</h3>
@endsection

@section('content-body')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header ms-auto">
                        <div class="btn-group mb-1">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Stok
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('stocks.stocks_in.create') }}">Stok Masuk</a>
                                    <a class="dropdown-item" href="{{ route('stocks.stocks_out.create') }}">Stok
                                        Keluar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Tipe Stok</th>
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
        var dataUrl = "{{ route('stocks.data') }}";
        var destroyUrl = "{{ route('stocks.destroy', ':id') }}";
    </script>
    <script src="{{ asset(mix('js/contents/masters/stocks/stock.js')) }}"></script>
@endsection
