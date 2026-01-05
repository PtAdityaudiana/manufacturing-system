@extends('layouts.app')
@section('title','Admin Dashboard')

@section('content')
<h1>Admin Dashboard</h1>

{{-- SUMMARY CARDS --}}
<div class="grid">
    <a href="{{ route('admin.products.create') }}" class="card-link">
        <div class="card">
            Total Produk<br>
            <b>{{ $totalProducts }}</b>
        </div>
    </a>

    <a href="{{ route('admin.raw-materials.index') }}" class="card-link">
        <div class="card">
            Total Bahan Baku<br>
            <b>{{ $totalMaterials }}</b>
        </div>
    </a>

    <a href="{{ route('admin.dashboard') }}" class="card-link">
        <div class="card">
            Produksi Bulan Ini<br>
            <b>{{ $totalProductionThisMonth }}</b>
        </div>
    </a>
</div>

<hr>

{{-- PRODUKSI PER BULAN --}}
<h3>Produksi per Bulan ({{ date('Y') }})</h3>

<table class="table">
    <tr>
        <th>Bulan</th>
        <th>Total Produksi</th>
    </tr>
    @foreach($productionChart as $row)
    <tr>
        <td>Bulan {{ $row->month }}</td>
        <td>{{ $row->total }}</td>
    </tr>
    @endforeach
</table>

<canvas id="productionPerMonthChart" height="100"></canvas>

<hr>

{{-- PRODUK TERBANYAK --}}
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

<canvas id="topProductChart" height="100"></canvas>

<hr>

{{-- PRODUKSI TERAKHIR --}}
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

{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const productionMonthCtx = document.getElementById('productionPerMonthChart');

new Chart(productionMonthCtx, {
    type: 'bar',
    data: {
        labels: [
            @foreach($productionChart as $row)
                'Bulan {{ $row->month }}',
            @endforeach
        ],
        datasets: [{
            label: 'Total Produksi',
            data: [
                @foreach($productionChart as $row)
                    {{ $row->total }},
                @endforeach
            ]
        }]
    }
});

const topProductCtx = document.getElementById('topProductChart');

new Chart(topProductCtx, {
    type: 'bar',
    data: {
        labels: [
            @foreach($topProducts as $row)
                '{{ $row->product->name }}',
            @endforeach
        ],
        datasets: [{
            label: 'Total Produksi',
            data: [
                @foreach($topProducts as $row)
                    {{ $row->total }},
                @endforeach
            ]
        }]
    }
});
</script>
@endsection
