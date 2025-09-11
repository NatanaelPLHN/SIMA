@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@push('styles')
{{-- <style>
    /* taruh CSS khusus halaman ini */
    .dashboard-title { font-size: 1.2rem; color: #4a3d8c; margin-bottom: 10px; }
    .btn { padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; font-size: 0.9rem; }
    .btn-primary { background-color: #4a3d8c; color: white; }
    .btn-secondary { background-color: #e0e0e0; color: #333; }
    .aksi-btn { background-color: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 5px; }
    .aksi-btn:hover { background-color: #0056b3; }
</style> --}}
@endpush

@section('content')
    <div class="content-header">
        <h2 class="dashboard-title">Aset Bergerak</h2>
        <div class="btn-group">
            <button class="btn btn-primary">Bergerak</button>
            <button class="btn btn-secondary">Tidak Bergerak</button>
            <button class="btn btn-secondary">Habis Pakai</button>
        </div>
    </div>

    <div class="search-box">
        <label>Tampilkan:</label>
        <select>
            <option>10</option>
            <option>25</option>
            <option>50</option>
            <option>100</option>
        </select>
        <label>entri</label>
        <input type="text" placeholder="Cari..." />
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Aset</th>
                <th>Seri/Number</th>
                <th>Merk/Type</th>
                <th>Tahun Produksi</th>
                <th>Kondisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td><td>Audrey Mckinney</td><td>12345</td><td>Dell</td><td>2023</td><td>Baik</td>
                <td><button class="aksi-btn"><i class="fas fa-edit"></i></button></td>
            </tr>
            <tr>
                <td>2</td><td>Savannah Howard</td><td>54321</td><td>HP</td><td>2022</td><td>Rusak</td>
                <td><button class="aksi-btn"><i class="fas fa-edit"></i></button></td>
            </tr>
        </tbody>
    </table>
@endsection

@push('scripts')
<script>
    // tombol filter
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.btn').forEach(b => b.classList.remove('btn-primary'));
            this.classList.add('btn-primary');
        });
    });

    // pencarian tabel
    const searchInput = document.querySelector('.search-box input');
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            let found = false;
            cells.forEach(cell => {
                if (cell.textContent.toLowerCase().includes(searchTerm)) {
                    found = true;
                }
            });
            row.style.display = found ? '' : 'none';
        });
    });
</script>
@endpush
