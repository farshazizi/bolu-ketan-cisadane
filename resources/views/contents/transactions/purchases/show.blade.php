@extends('layouts.index')

@section('content-header')
    <h3>Pembelian</h3>
@endsection

@section('content-body')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header ms-auto">
                        <div class="buttons">
                            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Kembali</a>
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
                                                value="{{ $purchase->date }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="notes">Notes</label>
                                            <textarea class="form-control" id="notes" name="notes" rows="3"
                                                disabled>{{ $purchase->notes }}</textarea>
                                        </div>
                                        <table class="table" style="width: 100%; text-align: center">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Stok</th>
                                                    <th>Kuantitas</th>
                                                    <th style="text-align: right">Harga</th>
                                                    <th style="text-align: right">Total</th>
                                                    <th>Notes</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">
                                                @foreach ($purchase->purchaseDetails as $key => $purchaseDetail)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $purchaseDetail->ingredient->name }}</td>
                                                        <td>{{ $purchaseDetail->quantity }}</td>
                                                        <td style="text-align: right">{{ $purchaseDetail->price }}</td>
                                                        <td style="text-align: right">{{ $purchaseDetail->total }}</td>
                                                        <td>{{ $purchaseDetail->notes }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end mt-3">
                                        <table>
                                            <tr>
                                                <td style="width: 150px"><b>Grand Total</b></td>
                                                <td style="width: 50px"><b>:</b></td>
                                                <td style="width: 150px; text-align: right">
                                                    Rp. {{ $purchase->grand_total }}
                                                </td>
                                            </tr>
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
