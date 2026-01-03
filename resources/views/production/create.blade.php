@extends('layouts.app')
@section('title','Tambah Produksi')
@section('content')
<a href="{{ route('production.index') }}">back</a>
<h1>Tambah Produksi</h1>

@if($errors->any())
<div class="alert-danger">
    {{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('production.store') }}">
    @csrf

    <label>Produk</label>
    <select name="product_id" required>
        <option value="">-- Pilih Produk --</option>
        @foreach($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }}</option>
        @endforeach
    </select>

    <label>Jumlah Produksi</label>
    <input type="number" name="qty" min="1" required>

    <label>Tanggal Produksi</label>
    <input type="date" name="production_date" required>

    <button class="btn">Simpan</button>
</form>

@endsection
