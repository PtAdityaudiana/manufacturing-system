@extends('layouts.app')
@section('title','Tambah Produksi')
@section('content')
<button class="btn"><a href="{{ route('production.index') }}">back</a></button>
<h1>Tambah Produksi</h1>

@if($errors->any())
<div class="alert-danger">
    {{ $errors->first() }}
</div>
@endif

<form method="GET" action="{{ route('production.create') }}">
    <label>Produk</label>
    <select name="product_id" onchange="this.form.submit()" required>
        <option value="">-- Pilih Produk --</option>
        @foreach($products as $product)
            <option value="{{ $product->id }}"
                {{ request('product_id') == $product->id ? 'selected' : '' }}>
                {{ $product->name }}
            </option>
        @endforeach
    </select>
</form>


<form method="POST" action="{{ route('production.store') }}">
    @csrf

    <input type="hidden" name="product_id" value="{{ request('product_id') }}">

    <label>Jumlah Produksi</label>
    <input type="number" name="qty" min="1" required>

    <label>Tanggal Produksi</label>
    <input type="date" name="production_date" required>

    <button class="btn">Simpan</button>
</form>

@if($selectedProduct)
<h3>Resep Produksi: {{ $selectedProduct->name }}</h3>

<table class="table">
    <tr>
        <th>Bahan Baku</th>
        <th>Kebutuhan / Produk</th>
        <th>Stok Saat Ini</th>
        <th>Status</th>
    </tr>

    @foreach($selectedProduct->boms as $bom)
        @php
            $material = $bom->rawMaterial;
            $cukup = $material->stock >= $bom->qty_required;
        @endphp
        <tr>
            <td>{{ $material->name }}</td>
            <td>{{ $bom->qty_required }} {{ $material->unit }}</td>
            <td>{{ $material->stock }} {{ $material->unit }}</td>
            <td>
                @if($cukup)
                    <span style="color:green;font-weight:bold">Cukup</span>
                @else
                    <span style="color:red;font-weight:bold">Tidak Cukup</span>
                @endif
            </td>
        </tr>
    @endforeach
</table>
@endif

@endsection
