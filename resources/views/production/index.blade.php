@extends('layouts.app')
@section('title','Produksi')

@section('content')
<a class="btn" href="{{ route('operator.dashboard') }}">back</a>
<h1>Data Produksi</h1>

<a href="{{ route('production.create') }}" class="btn">+ Tambah Produksi</a>

@if(session('success'))
<div class="alert-success">{{ session('success') }}</div>
@endif

<table class="table">
    <tr>
        <th>Tanggal</th>
        <th>Produk</th>
        <th>Qty</th>
    </tr>
    @foreach($productions as $prod)
    <tr>
        <td>{{ $prod->production_date }}</td>
        <td>{{ $prod->product->name }}</td>
        <td>{{ $prod->qty }}</td>
    </tr>
    @endforeach
</table>

{{ $productions->links() }}
@endsection
