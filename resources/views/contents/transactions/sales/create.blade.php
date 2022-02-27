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
                                                <button type="button" class="btn btn-primary" v-on:click="addSale">
                                                    Tambah Penjualan
                                                </button>
                                            </div>
                                            <table class="table"
                                                style="width: auto; text-align: center; overflow:auto" id="tableSaleDetail">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Stok</th>
                                                        <th>Jml Stok</th>
                                                        <th>Kuantitas</th>
                                                        <th>Harga</th>
                                                        <th>Diskon</th>
                                                        <th>Total</th>
                                                        <th>Total Tambahan</th>
                                                        <th>Notes</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody">
                                                    <tr class="bg-grey" v-cloak v-for="(data, index) in detail">
                                                        <td>{> index + 1 <} </td>
                                                        <td>
                                                            <select class="form-select" style="width: 150px"
                                                                id="inventoryStock" name="inventoryStock"
                                                                v-model="data.inventoryStock"
                                                                v-on:change="getPrice(index); getStock(index)">
                                                                <option value="">Pilih Stok</option>
                                                                @foreach ($inventoryStocks as $inventoryStock)
                                                                    <option value="{{ $inventoryStock->id }}">
                                                                        {{ $inventoryStock->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input-currency type="text" class="form-control" id="stock"
                                                                name="stock" v-model="data.stock" :index="index" disabled>
                                                            </input-currency>
                                                        </td>
                                                        <td>
                                                            <input-currency type="text" class="form-control" id="quantity"
                                                                name="quantity" v-model="data.quantity" :index="index">
                                                            </input-currency>
                                                        </td>
                                                        <td>
                                                            <input-currency type="text" class="form-control"
                                                                v-model="data.price" disabled></input-currency>
                                                        </td>
                                                        <td>
                                                            <input-currency type="text" class="form-control" id="discount"
                                                                name="discount" v-model="data.discount" :index="index">
                                                            </input-currency>
                                                        </td>
                                                        <td>
                                                            <input-currency type="text" class="form-control"
                                                                v-model="data.total" disabled></input-currency>
                                                        </td>
                                                        <td>
                                                            <input-currency type="text" class="form-control"
                                                                v-model="data.totalAdditional" disabled></input-currency>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" v-model="data.notes">
                                                        </td>
                                                        <td class="text-center">
                                                            <button class="btn btn-success btn-sm" type="button"
                                                                style="margin: 4px" data-bs-toggle="modal"
                                                                data-bs-target="#additionalModal"
                                                                v-on:click="setIndexAdditional(index)">
                                                                <i class="fa fa-solid fa-plus" aria-hidden="true"></i>
                                                            </button>
                                                            <button v-on:click="deleteSale(index)"
                                                                class="btn btn-danger btn-sm" type="button"
                                                                style="margin: 4px">
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

    <div class="modal fade text-left" id="additionalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel18">Tambahan</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-inline form-group">
                                <select class="form-control" id="additional" name="additional" required>
                                    <option value="" selected disabled>Pilih Tambahan</option>
                                    @foreach ($additionals as $additional)
                                        <option value="{{ $additional->id }}" :price="{{ $additional->price }}">
                                            {{ $additional->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group" style="float: right">
                                <button type="button" class="btn btn-primary" v-on:click="addAdditional">
                                    Simpan Tambahan
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="additionalList">
                        <table class="table" style="width: 100%; text-align: center" id="tableSaleDetail">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <tr class="bg-grey" v-cloak v-for="(data, index) in detailAdditional">
                                    <td v-if="indexDetail == data.index">{> data.additionalName <} </td>
                                    <td v-if="indexDetail == data.index">{> data.price | numberFormat <} </td>
                                    <td class="text-center" v-if="indexDetail == data.index">
                                        <button v-on:click="deleteAdditional(index)" class="btn btn-danger btn-sm"
                                            type="button">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content-js')
    <script type="text/javascript">
        let getPriceRoute = "{{ route('sales.price', ':id') }}";
        let getStockRoute = "{{ route('sales.stock', ':id') }}";
        let storeRoute = "{{ route('sales.store') }}";
    </script>
    <script type="text/javascript" src="{{ asset('js/contents/transactions/sales/sale-create-vue.js') }}"></script>
@endsection
