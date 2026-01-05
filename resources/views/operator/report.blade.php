@extends('layouts.app')
@section('title','Laporan Produksi')

@section('content')
<a href="{{ route('operator.dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
<h1>Laporan Produksi</h1>

<form method="GET">
    <label>Start Date</label>
    <input type="date" name="start_date" value="{{ $start }}">

    <label>End Date</label>
    <input type="date" name="end_date" value="{{ $end }}">

    <button class="btn">Tampilkan</button>
</form>

@if($productions->count())
<div class="report-header">
    <h2>Laporan Produksi</h2>
    <p>
        Periode: 
        <strong>{{ \Carbon\Carbon::parse($start)->format('d M Y') }}</strong> 
        s/d 
        <strong>{{ \Carbon\Carbon::parse($end)->format('d M Y') }}</strong>
    </p>
    <hr>
</div>

<div class="summary">
    <div class="card">
        <p>Total Transaksi</p>
        <h4>{{ $productions->count() }}</h4>
    </div>

    <div class="card">
        <p>Total Qty Produksi</p>
        <h4>{{ $productions->sum('qty') }}</h4>
    </div>

    <div class="card">
        <p>Total Nilai Produksi</p>
        <h4>Rp {{ number_format($totalHarga, 0, ',', '.') }}</h4>
    </div>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Qty</th>
            <th>Harga / Produk</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productions as $index => $prod)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($prod->production_date)->format('d/m/Y') }}</td>
            <td>{{ $prod->product->name }}</td>
            <td>{{ $prod->qty }}</td>
            <td>Rp {{ number_format($prod->product->price, 0, ',', '.') }}</td>
            <td>
                Rp {{ number_format($prod->qty * $prod->product->price, 0, ',', '.') }}
            </td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <th colspan="5" class="text-end">TOTAL KESELURUHAN</th>
            <th>Rp {{ number_format($totalHarga, 0, ',', '.') }}</th>
        </tr>
    </tfoot>
</table>

<div class="report-note">
    <p>
        <strong>Catatan:</strong><br>
        Laporan ini menampilkan data produksi berdasarkan periode yang dipilih.
        Total nilai produksi dihitung dari akumulasi jumlah produksi dikalikan
        dengan harga masing-masing produk.
    </p>
</div>
@else
<div class="alert alert-warning">
    Tidak ada data produksi pada periode 
    {{ $start }} sampai {{ $end }}.
</div>
@endif
@endsection
