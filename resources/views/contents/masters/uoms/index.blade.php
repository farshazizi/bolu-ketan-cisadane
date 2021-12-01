@extends('layouts.index')

@section('content-header')
    <h3>Uom</h3>
@endsection

@section('content-body')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header ms-auto">
                        <div class="buttons">
                            <a href="{{ route('uoms.create') }}" class="btn btn-primary">Tambah Uom</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Actions</th>
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
        var dataUrl = "{{ route('uoms.data') }}";
        var destroyUrl = "{{ route('uoms.destroy', ':id') }}";
    </script>
    <script src="{{ asset(mix('js/contents/masters/uoms/uom.js')) }}"></script>
@endsection
