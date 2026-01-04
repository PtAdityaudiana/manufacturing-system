@extends('layouts.app')
@section('title','RawMaterial Management')

@section('content')
<button class="btn"><a href="{{ route('admin.dashboard') }}">back</a></button>


<h2>Jumlah Stock Bahan Baku</h2>
<a href="{{ route('admin.raw-materials.create') }}">+ Tambah Bahan Baku Baru</a>
<table class="table">
<tr>
    <th>Nama</th>
    <th>Stok</th>
    <th>Harga/Satuan</th>
    <th>Aksi</th>
</tr>
@foreach($materials as $m)
<tr>
    <td>{{ $m->name }}</td>
    <td>{{ $m->stock }} {{ $m->unit }}</td>
    <td>Rp.{{ $m->price}}</td>
    <td>
        <form method="POST" action="{{ route('admin.raw-materials.stock', $m->id) }}">
            @csrf
            <input type="hidden" name="type" value="in">
            <input type="number" name="qty" placeholder="Qty">
            <button>Tambah Stok</button>
        </form>

        <form method="POST" action="{{ route('admin.raw-materials.stock', $m->id) }}">
            @csrf
            <input type="hidden" name="type" value="out">
            <input type="number" name="qty" placeholder="Qty">
            <button>Kurangi Stok</button>
        </form>
    </td>
    
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
@endsection