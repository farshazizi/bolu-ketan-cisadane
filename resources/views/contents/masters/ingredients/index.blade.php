@extends('layouts.index')

@section('content-header')
    <h3>Bahan</h3>
@endsection

@section('content-body')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header ms-auto">
                        <div class="buttons">
                            <a href="{{ route('ingredients.create') }}" class="btn btn-primary">Tambah Bahan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bahan</th>
                                    <th>Nama Satuan</th>
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
        var dataUrl = "{{ route('ingredients.data') }}";
        var destroyUrl = "{{ route('ingredients.destroy', ':id') }}";
    </script>
    <script src="{{ asset(mix('js/contents/masters/ingredients/ingredient.js')) }}"></script>
@endsection
