@extends('layouts.app')
@section('title','Admin Dashboard')

@section('content')
<h1>Admin Dashboard</h1>

<div class="grid">
    <div class="card">Total Produk<br><b>{{ $totalProducts }}</b></div>
    <div class="card">Total Bahan Baku<br><b>{{ $totalMaterials }}</b></div>
    <div class="card">Produksi Bulan Ini<br><b>{{ $totalProductionThisMonth }}</b></div>
</div>

<h3>Produksi per Bulan ({{ date('Y') }})</h3>
<table class="table">
    <tr>
        <th>Bulan</th>
        <th>Total Produksi</th>
    </tr>
    @foreach($productionChart as $row)
    <tr>
        <td>{{ $row->month }}</td>
        <td>{{ $row->total }}</td>
    </tr>
    @endforeach
</table>

<h3>Jumlah Stock Bahan Baku</h3>
<table class="table">
    <tr>
        <th>Nama</th>
        <th>Stok</th>
        <th>Satuan</th>
        <th>harga/satuan</th>
    </tr>
    @foreach($materials as $material)
        <tr>
            <td>{{ $material->name }}</td>
            <td>{{ $material->stock }}</td>
            <td>{{ $material->unit }}</td>
            <td>Rp.{{ $material->price}}</td>
        </tr>
    @endforeach
</table>

<h3>Bahan Baku Hampir Habis</h3>
<table class="table">
    <tr>
        <th>Nama</th>
        <th>Stok</th>
    </tr>
    @forelse($lowStockMaterials as $material)
        @php
            $in = $material->stockMovements()->in()->sum('qty');
            $out = $material->stockMovements()->out()->sum('qty');
        @endphp
        <tr>
            <td>{{ $material->name }}</td>
            <td>{{ $in - $out }}</td>
        </tr>
    @empty
        <tr><td colspan="2">Aman</td></tr>
    @endforelse
</table>

<h3>Produk Paling Sering Diproduksi</h3>
<table class="table">
    <tr>
        <th>Produk</th>
        <th>Total</th>
    </tr>
    @foreach($topProducts as $row)
    <tr>
        <td>{{ $row->product->name }}</td>
        <td>{{ $row->total }}</td>
    </tr>
    @endforeach
</table>
@endsection
