@extends('layouts.index')

@section('content-header')
    <h3>Stok Masuk</h3>
@endsection

@section('content-body')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header ms-auto">
                        <div class="buttons">
                            <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="date">Tanggal</label>
                                            <input type="date" class="form-control" id="date" name="date"
                                                value="{{ $stock->date }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="notes">Notes</label>
                                            <textarea class="form-control" id="notes" name="notes" rows="3"
                                                disabled>{{ $stock->notes }}</textarea>
                                        </div>
                                        <table class="table" style="width: 100%; text-align: center">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Stok</th>
                                                    <th>Kuantitas</th>
                                                    <th>Notes</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">
                                                @foreach ($stock->stockDetails as $key => $stockDetail)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $stockDetail->inventoryStock->name }}</td>
                                                        <td>{{ $stockDetail->quantity }}</td>
                                                        <td>{{ $stockDetail->notes }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
