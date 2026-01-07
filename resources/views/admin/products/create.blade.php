@extends('layouts.app')
@section('title','Tambah Produk')
@section('content')
<a class="btn"href="{{ route('admin.dashboard') }}">back</a>
<h2>Tambah Produk</h2>
<form method="POST" action="{{ route('admin.products.store') }}">
@csrf

<input name="name" placeholder="Nama Produk">
<input name="price" placeholder="Harga">

<h4>BOM</h4>
@foreach($materials as $material)
    <div>
        {{ $material->name }} ({{ $material->unit }})
        <input type="number" name="materials[{{ $material->id }}]" min="0">
    </div>
@endforeach

<button class="btn">Simpan</button>
</form>

<h3>Produk yang tersedia saat ini</h3>
<table class="table">
    <tr>
        <th>Produk</th>
        <th>Harga</th>
    </tr>
    @foreach($products as $product)
    <tr>
        <td>{{ $product->name }}</td>
        <td>Rp.{{ $product->price }}</td>
    </tr>
    @endforeach
</table>

@endsection