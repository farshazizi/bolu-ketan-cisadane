@extends('layouts.index')

@section('content-header')
    <h3>Pesanan</h3>
@endsection

@section('content-body')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header ms-auto">
                        <div class="buttons">
                            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
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
                                                value="{{ $order->date }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Nama</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $order->name }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Alamat</label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                value="{{ $order->address }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">No. Telepon</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                value="{{ $order->phone }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="notes">Notes</label>
                                            <textarea class="form-control" id="notes" name="notes" rows="3"
                                                disabled>{{ $order->notes }}</textarea>
                                        </div>
                                        <table class="table" style="width: 100%; text-align: center">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Stok</th>
                                                    <th>Kuantitas</th>
                                                    <th style="text-align: right">Harga</th>
                                                    <th style="text-align: right">Total</th>
                                                    <th style="text-align: right">Total Tambahan</th>
                                                    <th>Notes</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">
                                                @foreach ($order->orderDetails as $key => $orderDetail)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $orderDetail->inventoryStock->name }}</td>
                                                        <td>{{ $orderDetail->quantity }}</td>
                                                        <td style="text-align: right">{{ $orderDetail->price }}</td>
                                                        <td style="text-align: right">{{ $orderDetail->total }}</td>
                                                        <td style="text-align: right">
                                                            {{ $orderDetail->total_additional }}
                                                        </td>
                                                        <td>{{ $orderDetail->notes }}</td>
                                                        <td>
                                                            <button class="btn btn-success btn-sm" type="button"
                                                                data-bs-toggle="modal" data-bs-target="#additionalModal"
                                                                data-order-detail-id="{{ $orderDetail->id }}">
                                                                <i class="fa fa-solid fa-list" aria-hidden="true"></i>
                                                            </button>
                                                        </td>
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
                                                    Rp. {{ $order->grand_total }}
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
                    <div id="additionalList"></div>
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
        var getOrderAdditionalDetailRoute = "{{ route('orders_additional_details.data', ':orderDetailId') }}";
    </script>
    <script type="text/javascript" src="{{ asset('js/contents/transactions/orders/order-show.js') }}"></script>
@endsection
