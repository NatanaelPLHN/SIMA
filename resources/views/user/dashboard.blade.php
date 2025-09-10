@extends('layouts.dashboard')

@section('title', 'User Dashboard')
@section('menu-dashboard-active', 'active')
@section('page-title', 'DASHBOARD')

@section('content')
    <div class="welcome-card">
        <div class="welcome-message">Selamat datang, {{ auth()->user()->name }}</div>
        <div class="welcome-subtext">
            Selamat Datang di Website Sistem Informasi Manajemen Aset DISKOMINFO Kota Samarinda
        </div>
    </div>

    <div class="stats-container">
        <div class="stat-card card-purple">
            <div class="stat-card-header">
                <div class="stat-title">Total Aset Bergerak</div>
            </div>
            <div class="stat-value">11</div>
        </div>
        
        <div class="stat-card card-blue">
            <div class="stat-card-header">
                <div class="stat-title">Total Aset Tetap</div>
            </div>
            <div class="stat-value">5</div>
        </div>
        
        <div class="stat-card card-teal">
            <div class="stat-card-header">
                <div class="stat-title">Total Aset Habis Pakai</div>
            </div>
            <div class="stat-value">3</div>
        </div>
    </div>
@endsection
