@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div style="width: 1280px; height: 720px; position: relative; background: white; overflow: hidden">

    <!-- Ilustrasi -->
    <img style="width: 426px; height: 426px; left: 108px; top: 147px; position: absolute"
         src="{{ asset('assets/img/login.svg') }}" alt="Login Illustration" />

    <!-- Judul -->
    <div style="width: 651px; height: 77px; left: 128px; top: 41px; position: absolute; color: #3E267C; font-size: 28px; font-weight: 700;">
        SIMA (Sistem Informasi Manajemen Aset)<br/>DISKOMINFO Kota Samarinda
    </div>

    <!-- Teks Login -->
    <div style="left: 900px; top: 203px; position: absolute; text-align: right; color: #3E267C; font-size: 32px; font-weight: 700;">
        Login
    </div>

    <!-- Logo -->
    <img style="width: 77px; height: 77px; left: 31px; top: 34px; position: absolute"
         src="{{ asset('assets/img/logo.svg') }}" alt="Logo" />

    <!-- Form Login -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Input Email -->
        <div style="width: 365px; height: 66px; left: 761px; top: 258px; position: absolute;">
            <input type="email" name="email" id="email"
                   value="{{ old('email') }}"
                   placeholder="Email"
                   required autofocus
                   class="form-control @error('email') is-invalid @enderror"
                   style="width: 100%; height: 100%; border-radius: 50px; border: none; padding: 0 20px; font-size: 18px; background: #E8E8E8;">
            @error('email')
                <div style="color: red; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Input Password -->
        <div style="width: 365px; height: 66px; left: 761px; top: 337px; position: absolute;">
            <input type="password" name="password" id="password"
                   placeholder="Password"
                   required
                   class="form-control @error('password') is-invalid @enderror"
                   style="width: 100%; height: 100%; border-radius: 50px; border: none; padding: 0 20px; font-size: 18px; background: #E5E5E5;">
            @error('password')
                <div style="color: red; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tombol Login -->
        <div style="width: 365px; height: 66px; left: 761px; top: 445px; position: absolute;">
            <button type="submit"
                    style="width: 100%; height: 100%; border: none; border-radius: 50px; background: #6FB553; color: white; font-size: 20px; font-weight: 700; cursor: pointer;">
                LOGIN
            </button>
        </div>
    </form>

    <!-- Background Circle -->
    <div style="width: 351px; height: 351px; left: 1027px; top: -96px; position: absolute; background: linear-gradient(180deg, #3E267C 0%, #09A0D5 100%); border-radius: 9999px;"></div>
    <div style="width: 351px; height: 334px; left: 805px; top: -168px; position: absolute; background: linear-gradient(180deg, #3E267C 0%, #09A0D5 100%); border-radius: 9999px;"></div>
    <div style="width: 351px; height: 334px; left: 1377.77px; top: -114.80px; position: absolute; transform: rotate(113deg); transform-origin: top left; background: linear-gradient(180deg, #3E267C 0%, #09A0D5 100%); border-radius: 9999px;"></div>

</div>
@endsection
