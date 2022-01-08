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
                            @if (session('status'))
                                <div class="alert alert-{{ session('status') }} alert-dismissible fade show" role="alert">
                                    {{ session('message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form class="form form-vertical" action="{{ route('stocks.stocks-in.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="stockType" value="0" />
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
                                            <div class="form-group">
                                                <label for="notes">Notes</label>
                                                <textarea class="form-control" id="notes" name="notes"
                                                    rows="3"></textarea>
                                                @error('notes')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group d-flex justify-content-end mt-5">
                                                <button type="button" class="btn btn-primary" id="btnAddStockIn">
                                                    Tambah Stok Masuk
                                                </button>
                                            </div>
                                            <table class="table" style="width: 100%; text-align: center">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Stok</th>
                                                        <th>Kuantitas</th>
                                                        <th>Notes</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody">
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end mt-3">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
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
        // Denotes total number of rows
        var rowIdx = 0;

        $(function() {
            addRow();

            $('#btnAddStockIn').click(function() {
                addRow();
            });

            $('#tbody').on('click', '#btnDelete', function() {
                // Getting all the rows next to the row
                // containing the clicked button
                var child = $(this).closest('tr').nextAll();

                // Iterating across all the rows
                // obtained to change the index
                child.each(function() {
                    // Getting <tr> id.
                    var id = $(this).attr('id');

                    // Getting the <p> inside the .row-index class.
                    var idx = $(this).children('.row-index').children('p');

                    // Gets the row number from <tr> id.
                    var dig = parseInt(id.substring(1));

                    // Modifying row index.
                    idx.html(`${dig - 1}`);

                    // Modifying row id.
                    $(this).attr('id', `R${dig - 1}`);
                });

                // Removing the current row.
                $(this).closest('tr').remove();

                // Decreasing total number of rows by 1.
                rowIdx--;
            });

            $('#tbody').on('click', '#inventoryStock', function() {
                $.ajax({
                    url: "{{ route('stocks.inventory-stocks') }}",
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(response) {},
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire({
                            icon: xhr.responseJSON.status,
                            text: xhr.responseJSON.message,
                            showConfirmButton: false
                        });
                    }
                });
            });
        });

        function addRow() {
            let htmlAddStockIn = `
                <tr id="R${++rowIdx}">
                    <td class="row-index">
                        <p>${rowIdx}</p>
                    </td>
                    <td>
                        <select class="form-select" id="inventoryStock" name="inventoryStock[]">
                            <option value="">Pilih Stok</option>
                            @foreach ($inventoryStocks as $inventoryStock)
                                <option value="{{ $inventoryStock->id }}" @if (old('inventoryStock') == $inventoryStock->id) selected @endif>
                                    {{ $inventoryStock->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control maskCurrency" id="quantity" name="quantity[]" placeholder="0">
                    </td>
                    <td>
                        <input type="text" class="form-control" id="notesDetail" name="notesDetail[]" />
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" id="btnDelete">
                            <i class="far fa-trash-alt fa-lg"></i>
                        </button>
                    </td>
                </tr>`;

            // Adding a row inside the tbody.
            $('#tbody').append(htmlAddStockIn);

            maskCurrency();
        }
    </script>
@endsection
