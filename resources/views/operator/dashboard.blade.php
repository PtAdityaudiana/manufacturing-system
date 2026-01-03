@extends('layouts.app')
@section('title','Operator Dashboard')

@section('content')
<h1>Operator Dashboard</h1>
<a href="{{route('production.index')}}">production</a>

<div class="grid">
    <div class="card">
        Produksi Hari Ini<br>
        <b>{{ $todayProduction }}</b>
    </div>
</div>

<h3>Jumlah Stock Bahan Baku</h3>
<table class="table">
    <tr>
        <th>Nama</th>
        <th>Stok</th>
        <th>Satuan</th>
    </tr>
    @foreach($materials as $material)
        <tr>
            <td>{{ $material->name }}</td>
            <td>{{ $material->stock }}</td>
            <td>{{ $material->unit }}</td>
        </tr>
    @endforeach
</table>
<h3>Produksi Terakhir</h3>
<table class="table">
    <tr>
        <th>Tanggal</th>
        <th>Produk</th>
        <th>Qty</th>
    </tr>
    @foreach($recentProductions as $prod)
    <tr>
        <td>{{ $prod->production_date }}</td>
        <td>{{ $prod->product->name }}</td>
        <td>{{ $prod->qty }}</td>
    </tr>
    @endforeach
</table>


@endsection
