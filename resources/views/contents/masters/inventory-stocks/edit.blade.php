@extends('layouts.index')

@section('content-header')
    <h3>Stok</h3>
@endsection

@section('content-body')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header ms-auto">
                        <div class="buttons">
                            <a href="{{ route('inventory_stocks.index') }}" class="btn btn-secondary">Kembali</a>
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
                            <form class="form form-vertical" action="{{ route('inventory_stocks.update', $id) }}"
                                method="POST" enctype="multipart/form-data">
                                @method('PATCH')
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    name="name" placeholder="Nama"
                                                    value="{{ old('name', $inventoryStock->name) }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="minimalQuantity">Minimal Kuantitas</label>
                                                <input type="number"
                                                    class="form-control @error('minimalQuantity') is-invalid @enderror"
                                                    id="minimalQuantity" name="minimalQuantity" min="0"
                                                    value="{{ old('minimalQuantity', $inventoryStock->minimal_quantity) }}">
                                                @error('minimalQuantity')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="price">Harga</label>
                                                <input type="text"
                                                    class="form-control maskCurrency @error('price') is-invalid @enderror"
                                                    id="price" name="price"
                                                    value="{{ old('price', $inventoryStock->price) }}">
                                                @error('price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="category">Kategori</label>
                                                <select class="form-select @error('category') is-invalid @enderror"
                                                    id="category" name="category">
                                                    <option value="">Pilih Kategori</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            @if (old('category', $inventoryStock->category_id) == $category->id) selected @endif>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="icon">Icon</label>
                                                <input type="file"
                                                    class="form-control @error('icon') is-invalid @enderror" id="icon"
                                                    name="icon" accept="image/*">
                                                @error('icon')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                                @if ($inventoryStock->icon)
                                                    <div class="mt-2">
                                                        <div class="mb-2 form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="removeIcon" id="removeIcon" value="1">
                                                            <label class="form-check-label" for="removeIcon">
                                                                Hapus Icon Lama <span class="text-muted">(opsional, tidak
                                                                    perlu
                                                                    jika Anda mengunggah icon baru)</span>
                                                            </label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <img src="{{ asset('storage/' . $inventoryStock->icon) }}"
                                                                alt="Icon Lama" style="max-height: 64px; max-width: 64px">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="mb-1 btn btn-primary me-1">Simpan</button>
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
