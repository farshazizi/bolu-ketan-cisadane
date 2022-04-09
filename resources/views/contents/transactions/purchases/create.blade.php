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
                                                <textarea class="form-control" id="notes" name="notes" v-model="notes" rows="3"></textarea>
                                                @error('notes')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group d-flex justify-content-end mt-5">
                                                <button type="button" class="btn btn-primary" v-on:click="addPurchase">
                                                    Tambah Pembelian
                                                </button>
                                            </div>
                                            <table class="table" style="width: 100%; text-align: center"
                                                id="tablePurchaseDetail">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Bahan</th>
                                                        <th>Satuan</th>
                                                        <th>Kuantitas</th>
                                                        <th>Harga</th>
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
                                                                id="ingredient" name="ingredient" v-model="data.ingredient"
                                                                v-on:change="getUom(index)">
                                                                <option value="">Pilih Bahan</option>
                                                                @foreach ($ingredients as $ingredient)
                                                                    <option value="{{ $ingredient->id }}">
                                                                        {{ $ingredient->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" id="uom" name="uom"
                                                                v-model="data.uom" disabled>
                                                        </td>
                                                        <td>
                                                            <input-currency type="text" class="form-control" id="quantity"
                                                                name="quantity" v-model="data.quantity" :index="index">
                                                            </input-currency>
                                                        </td>
                                                        <td>
                                                            <input-currency type="text" class="form-control" id="price"
                                                                name="price" v-model="data.price" :index="index">
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
        let getUomRoute = "{{ route('purchases.uom', ':id') }}";
        let storeRoute = "{{ route('purchases.store') }}";
    </script>
    <script type="text/javascript" src="{{ asset('js/contents/transactions/purchases/purchase-create-vue.js') }}">
    </script>
@endsection
