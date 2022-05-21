@extends('layouts.index')

@section('content-header')
    <h3>Laporan</h3>
    <style>
        .text-right {
            text-align: right;
        }

    </style>
@endsection

@section('content-body')
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Harian</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{ route('reports.daily_report') }}">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="date">Tanggal</label>
                                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                                    id="date" name="date" v-model="date">
                                                @error('date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Pesanan</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{ route('reports.order_report') }}">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="date">Tanggal</label>
                                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                                    id="date" name="date" value="{{ old('date') }}">
                                                @error('date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="date">Status</label>
                                                <select class="form-select @error('status') is-invalid @enderror"
                                                    id="status" name="status" value="{{ old('status') }}">
                                                    <option value="">Pilih Status</option>
                                                    <option value="0" @if (old('status') === '0') selected @endif>
                                                        Menunggu Diproses
                                                    </option>
                                                    <option value="1" @if (old('status') === '1') selected @endif>
                                                        Berhasil
                                                    </option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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
        var dataSaleOrdersRoute = "{{ route('sales.data_orders') }}";
        var createSaleOrderRoute = "{{ route('sales.create') }}";
    </script>
    <script src="{{ asset(mix('js/contents/transactions/sales/sale.js')) }}"></script>
@endsection
