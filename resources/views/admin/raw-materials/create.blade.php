@extends('layouts.app')
@section('title','Tambah Bahan Baku')
@section('content')
<h2>Tambah Bahan Baku</h2>
<a class="btn"href="{{ route('admin.raw-materials.index') }}">back</a>
<form method="POST" action="{{ route('admin.raw-materials.store') }}">
@csrf
<input name="name" placeholder="Nama">
<input name="unit" placeholder="Satuan">
<input name="price" placeholder="Harga">
<button class="btn">Simpan</button>
</form>
@endsection
