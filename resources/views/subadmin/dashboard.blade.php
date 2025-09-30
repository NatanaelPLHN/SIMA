@extends('layouts.app')

@section('title', 'SubAdmin Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h4>Admin Bidang Dashboard</h4>
            </div>
            <div class="card-body">
                <h1 class="display-4">Ini Dashboard Admin Bidang</h1>
                <p class="lead">Selamat datang di dashboard admin, {{ auth()->user()->name }}!</p>

                <div class="alert alert-warning">
                    <strong>Role:</strong> {{ ucfirst(auth()->user()->role) }}<br>
                    <strong>Email:</strong> {{ auth()->user()->email }}<br>
                    <strong>Admin Privileges:</strong> Aktif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
