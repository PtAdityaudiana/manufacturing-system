@extends('layouts.app')
@section('title','Operator Dashboard')

@section('content')
<h1>Operator Dashboard</h1>

<div class="grid">
    <div class="card">
        Produksi Hari Ini<br>
        <b>{{ $todayProduction }}</b>
    </div>
</div>

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
