@csrf
 <!-- Role Info -->


{{-- Email --}}
<div>
    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email<span
            class="text-red-500">*</span></label>
    <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror">

    @error('email')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Password --}}
<div>
   <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password {{ isset($user) ? '(Kosongkan jika tidak ingin mengubah)' : '' }}</label>
    <input type="password" id="password" name="password"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-500 @enderror">

    @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Confirm Password --}}
<div>
    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Konfirmasi Password
    </label>
    <input type="password" name="password_confirmation" id="password_confirmation"
       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>

{{-- Role --}}
{{-- <div class="mb-4">
    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
        Role <span class="text-red-500">*</span>
    </label>
    <select name="role" id="role" required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('role') border-red-500 @enderror">
        <option value="">Pilih Role</option>
        <option value="superadmin" {{ old('role', $user->role ?? '') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
        <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="user" {{ old('role', $user->role ?? '') === 'user' ? 'selected' : '' }}>User</option>
    </select>

    @error('role')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div> --}}

{{-- nda tau ini apa --}}
<div>
    <label for="karyawan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Karyawan
    </label>
    <select
        name="karyawan_id"
        id="karyawan_id"
        class="js-select2 mt-1 block w-full border border-gray-300 dark:border-gray-600
               bg-white dark:bg-gray-800 text-gray-900 dark:text-white
               rounded-md shadow-sm py-2 px-3
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
               dark:focus:ring-indigo-600 dark:focus:border-indigo-500
               @error('karyawan_id') border-red-500 dark:border-red-500 @enderror"
    >
        <option value="">Tidak ada</option>
        @foreach($employees as $employee)
        <option value="{{ $employee->id }}" {{ old('karyawan_id', $user->karyawan_id ?? '') == $employee->id ? 'selected' : '' }}>
            @if ($login->role == 'superadmin')
            {{ $employee->nama }} ( {{ $employee->institution->nama ?? $user->employee->institution->nama }} )
            @elseif ($login->role == 'admin')
            {{ $employee->nama }} ( {{ $employee->department->nama ?? $user->employee->department->nama ?? ''}})
            @elseif ($login->role == 'subadmin')
            {{ $employee->nama }}
            @endif
        </option>
        @endforeach
    </select>

    @error('karyawan_id')
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror
</div>
