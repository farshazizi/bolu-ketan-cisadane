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
                            <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Kembali</a>
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
                            <form class="form form-vertical" action="{{ route('ingredients.store') }}" method="POST">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                    id="name" name="name" placeholder="Nama">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="uom">Uom</label>
                                                <fieldset class="form-group">
                                                    <select class="form-select @error('uom') is-invalid @enderror" id="uom"
                                                        name="uom">
                                                        <option value="">Pilih Uom</option>
                                                        @foreach ($uoms as $uom)
                                                            <option value="{{ $uom->id }}" @if (old('uom') == $uom->id) selected @endif>{{ $uom->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                                @error('uom')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
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
