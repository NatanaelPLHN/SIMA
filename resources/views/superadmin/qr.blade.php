@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Main Content -->
<div class="flex-1 flex flex-col">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center">
            <button class="text-gray-600 hover:text-gray-800 mr-4">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <h1 class="text-lg font-semibold text-gray-800">Label Barcode</h1>
        </div>
        <div class="flex items-center space-x-3">
            <div class="flex items-center">
                <i class="fas fa-user text-indigo-600 mr-2"></i>
                <span class="font-medium text-gray-800">John Doe</span>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 p-6 overflow-auto">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- QR Code Card 1 -->
                    <div class="border border-gray-300 rounded-lg p-4 text-center">
                        <div class="mb-4">
                            <img src="https://placehold.co/200x200?text=QR+Code" alt="QR Code"
                                class="w-48 h-48 object-contain mx-auto">
                        </div>
                        <div class="font-medium text-gray-900">
                            Meja Bundar
                        </div>
                        <div class="text-sm text-gray-700 font-mono">
                            2998-92
                        </div>
                    </div>

                    <!-- QR Code Card 2 -->
                    <div class="border border-gray-300 rounded-lg p-4 text-center">
                        <div class="mb-4">
                            <img src="https://placehold.co/200x200?text=QR+Code" alt="QR Code"
                                class="w-48 h-48 object-contain mx-auto">
                        </div>
                        <div class="font-medium text-gray-900">
                            Meja Bundar
                        </div>
                        <div class="text-sm text-gray-700 font-mono">
                            2998-92
                        </div>
                    </div>

                    <!-- QR Code Card 3 -->
                    <div class="border border-gray-300 rounded-lg p-4 text-center">
                        <div class="mb-4">
                            <img src="https://placehold.co/200x200?text=QR+Code" alt="QR Code"
                                class="w-48 h-48 object-contain mx-auto">
                        </div>
                        <div class="font-medium text-gray-900">
                            Meja Bundar
                        </div>
                        <div class="text-sm text-gray-700 font-mono">
                            2998-92
                        </div>
                    </div>

                    <!-- QR Code Card 4 -->
                    <div class="border border-gray-300 rounded-lg p-4 text-center">
                        <div class="mb-4">
                            <img src="https://placehold.co/200x200?text=QR+Code" alt="QR Code"
                                class="w-48 h-48 object-contain mx-auto">
                        </div>
                        <div class="font-medium text-gray-900">
                            Meja Bundar
                        </div>
                        <div class="text-sm text-gray-700 font-mono">
                            2998-92
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 px-6 py-3 text-center text-sm text-gray-500">
        <p>2025 Dinas Komunikasi dan Informatika, Allright Reserved</p>
    </footer>
</div>

@endsection
