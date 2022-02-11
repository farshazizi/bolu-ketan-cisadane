@extends('layouts.index')

@section('content-header')
    <h3>Tambahan</h3>
    <style>
        .text-right {
            text-align: right;
        }

    </style>
@endsection

@section('content-body')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header ms-auto">
                        <div class="buttons">
                            <a href="{{ route('additionals.create') }}" class="btn btn-primary">Tambah Tambahan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
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
        var dataRoute = "{{ route('additionals.data') }}";
        var destroyRoute = "{{ route('additionals.destroy', ':id') }}";
    </script>
    <script src="{{ asset(mix('js/contents/masters/additionals/additional.js')) }}"></script>
@endsection
