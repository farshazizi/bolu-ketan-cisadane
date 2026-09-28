@extends('layouts.index')

@section('content-header')
    <h3>Laporan</h3>
@endsection

@section('content-body')
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Harian</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{ route('reports.daily_report') }}">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="dailyReportDate">Tanggal</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control @error('dailyReportDate') is-invalid @enderror js-datepicker"
                                                    id="dailyReportDate" name="dailyReportDate" value="{{ old('dailyReportDate') }}" autocomplete="off" placeholder="DD-MM-YYYY">
                                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                                </div>
                                                @error('dailyReportDate')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Pesanan</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{ route('reports.order_report') }}">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="orderReportDate">Tanggal</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control @error('orderReportDate') is-invalid @enderror js-datepicker"
                                                    id="orderReportDate" name="orderReportDate" value="{{ old('orderReportDate') }}" autocomplete="off" placeholder="DD-MM-YYYY">
                                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                                </div>
                                                @error('orderReportDate')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-select @error('status') is-invalid @enderror"
                                                    id="status" name="status">
                                                    <option value="">Pilih Status</option>
                                                    <option value="0" @if (old('status') === '0') selected @endif>
                                                        Menunggu Diproses
                                                    </option>
                                                    <option value="1" @if (old('status') === '1') selected @endif>
                                                        Berhasil
                                                    </option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Bulanan</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{ route('reports.monthly_report') }}">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="monthlyReportDate">Tanggal</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control @error('monthlyReportDate') is-invalid @enderror js-monthpicker"
                                                    id="monthlyReportDate" name="monthlyReportDate" value="{{ old('monthlyReportDate') }}" autocomplete="off" placeholder="MM-YYYY">
                                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                                </div>
                                                @error('monthlyReportDate')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
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
