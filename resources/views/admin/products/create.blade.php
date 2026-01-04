@extends('layouts.app')
@section('title','Tambah Produk')
@section('content')
<button class="btn"><a href="{{ route('admin.dashboard') }}">back</a></button>
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

<button>Simpan</button>
</form>

@endsection