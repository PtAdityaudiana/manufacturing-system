@extends('layouts.app')
@section('title','Tambah Bahan Baku')
@section('content')
<h2>Tambah Bahan Baku</h2>
<button class="btn"><a href="{{ route('admin.raw-materials.index') }}">back</a></button>
<form method="POST" action="{{ route('admin.raw-materials.store') }}">
@csrf
<input name="name" placeholder="Nama">
<input name="unit" placeholder="Satuan">
<input name="price" placeholder="Harga">
<button>Simpan</button>
</form>
@endsection
