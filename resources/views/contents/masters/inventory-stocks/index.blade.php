@extends('layouts.index')

@section('content-header')
    <h3>Stok</h3>
@endsection

@section('content-body')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header ms-auto">
                        <div class="buttons">
                            <a href="{{ route('inventory-stocks.create') }}" class="btn btn-primary">Tambah Stok</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Stok</th>
                                    <th>Nama Kategori</th>
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
        var dataUrl = "{{ route('inventory-stocks.data') }}";
        var destroyUrl = "{{ route('inventory-stocks.destroy', ':id') }}";
    </script>
    <script src="{{ asset(mix('js/contents/masters/inventoryStocks/inventoryStock.js')) }}"></script>
@endsection
