@extends('layouts.index')

@section('content-header')
    <h3>Penjualan</h3>
@endsection

@section('content-body')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header ms-auto">
                        <div class="buttons">
                            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                    <div class="card-content" id="app">
                        <div class="card-body">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="errors.length"
                                id="error-form">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                    v-on:click="closeValidation($event)"></button>
                                <strong>Data tidak lengkap!</strong> mohon isi data-data berikut.
                                <br>
                                <ul style="margin: 0" id="error-form-li">
                                    <li v-for="error in errors">{> error <} </li>
                                </ul>
                            </div>
                            <form class="form form-vertical" method="POST" v-on:submit="submitForm">
                                @csrf
                                <input type="hidden" name="stockType" value="0" />
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="date">Tanggal</label>
                                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                                    id="date" name="date" v-model="date" disabled>
                                                @error('date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="notes">Notes</label>
                                                <textarea class="form-control" id="notes" name="notes" v-model="notes"
                                                    rows="3"></textarea>
                                                @error('notes')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group d-flex justify-content-end mt-5">
                                                <button type="button" class="btn btn-primary" id="addSale"
                                                    v-on:click="addSale">
                                                    Tambah Penjualan
                                                </button>
                                            </div>
                                            <table class="table" style="width: 100%; text-align: center"
                                                id="tableSaleDetail">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Stok</th>
                                                        <th>Kuantitas</th>
                                                        <th>Harga</th>
                                                        <th>Diskon</th>
                                                        <th>Total</th>
                                                        <th>Notes</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody">
                                                    <tr v-cloak v-for="(data, index) in detail" class="bg-grey">
                                                        <td>{> index + 1 <} </td>
                                                        <td>
                                                            <select class="form-select" style="width: 150px"
                                                                id="inventoryStock" name="inventoryStock"
                                                                v-model="data.inventoryStock" v-on:change="getPrice(index)">
                                                                <option value="">Pilih Stok</option>
                                                                @foreach ($inventoryStocks as $inventoryStock)
                                                                    <option value="{{ $inventoryStock->id }}">
                                                                        {{ $inventoryStock->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input-currency type="text" class="form-control" id="quantity"
                                                                name="quantity" :index="index" v-model="data.quantity">
                                                            </input-currency>
                                                        </td>
                                                        <td>
                                                            <input-currency type="text" class="form-control"
                                                                v-model="data.price" disabled></input-currency>
                                                        </td>
                                                        <td>
                                                            <input-currency type="text" class="form-control" id="discount"
                                                                name="discount" :index="index" v-model="data.discount">
                                                            </input-currency>
                                                        </td>
                                                        <td>
                                                            <input-currency type="text" class="form-control"
                                                                v-model="data.total" disabled></input-currency>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" v-model="data.notes">
                                                        </td>
                                                        <td class="text-center">
                                                            <button v-on:click="deleteSale(index)"
                                                                class="btn btn-danger btn-sm" type="button">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end mt-3">
                                            <table>
                                                <tr>
                                                    <td style="width: 150px"><b>Grand Total</b></td>
                                                    <td style="width: 50px"><b>:</b></td>
                                                    <td style="width: 150px; text-align: right" id="grandTotal"
                                                        name="grandTotal">Rp. {> calculateGrandTotal | numberFormat <} </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end mt-3">
                                            <button class="btn btn-primary me-1 mb-1">Simpan</button>
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
        let getPriceRoute = "{{ route('sales.price', ':id') }}";
        let storeRoute = "{{ route('sales.store') }}";
    </script>
    <script type="text/javascript" src="{{ asset('js/contents/transactions/sales/sale-create-vue.js') }}"></script>
@endsection
