<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIM ASET - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f6f9;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 200px;
            background-color: #4a3d8c;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100%;
            transition: all 0.3s ease;
        }

        .draw {
            font-size: 1rem;
        }

        .logo {
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .logo i {
            font-size: 1.5rem;
        }

        .sidebar ul {
            list-style: none;
            padding-left: 20px;
        }

        .sidebar ul li {
            padding: 10px 0;
            cursor: pointer;
            transition: background 0.3s;
        }

        .sidebar ul li:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar ul li.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .sidebar ul li span {
            display: block;
            padding-left: 10px;
        }

        .logout {
            margin-top: auto;
            padding: 10px 20px;
            text-align: left;
            font-size: 0.9rem;
            color: #ccc;
            cursor: pointer;
        }

        .logout:hover {
            color: white;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 200px;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            color: #4a3d8c;
        }

        .user-info i {
            font-size: 1.2rem;
        }

        .dashboard-title {
            font-size: 1.2rem;
            color: #4a3d8c;
            margin-bottom: 10px;
        }

        .content-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: #4a3d8c;
            color: white;
        }

        .btn-secondary {
            background-color: #e0e0e0;
            color: #333;
        }

        .btn-active {
            background-color: #4a3d8c;
            color: white;
        }

        .search-box {
            margin-top: 10px;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-box input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 200px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: 500;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .aksi-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.8rem;
        }

        .aksi-btn:hover {
            background-color: #0056b3;
        }

        .footer {
            text-align: center;
            padding: 10px;
            color: #999;
            font-size: 0.9rem;
            margin-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-building"></i> SIM ASET
        </div>
        <span><i class="fas fa-home"></i> DASHBOARD</span>
        <!-- <span><i class="fas fa-database"></i> Master Data</span> -->
        <!-- <p class="draw">Master Data</p> -->
        <ul>
            <li><span><i class="fas fa-building"></i> Instansi</span></li>
            <li><span><i class="fas fa-users"></i> Bidang</span></li>
            <!-- <li><span><i class="fas fa-user-tie"></i> Pegawai</span></li> -->
            <li><span><i class="fas fa-university"></i> Akun</span></li>
            <li><span><i class="fas fa-list"></i> Kategori</span></li>
            <li><span><i class="fas fa-layer-group"></i> Grup Kategori</span></li>
            <li><span><i class="fas fa-cube"></i> Aset</span></li>
            <li><span><i class="fas fa-file-invoice-dollar"></i> Report</span></li>
        </ul>
        <!-- <p class="draw">Monitoring Aset</p>
        <ul>
            <li><span><i class="fas fa-file-invoice-dollar"></i> Data Peminjaman</span></li>
            <li><span><i class="fas fa-exchange-alt"></i> Mutasi Aset</span></li>
            <li><span><i class="fas fa-barcode"></i> Stock Opname</span></li>
        </ul> -->
        <!-- <p class="draw">Report</p>
        <ul> -->
            <!-- <li><span><i class="fas fa-file-invoice-dollar"></i> Data Peminjaman</span></li>
            <li><span><i class="fas fa-exchange-alt"></i> Mutasi Aset</span></li>
            <li><span><i class="fas fa-barcode"></i> Stock Opname</span></li>
            <li><span><i class="fas fa-barcode"></i> Label Barcode</span></li>
            <li><span><i class="fas fa-id-card"></i> Kartu Inventaris</span></li>
        </ul> -->
        <div class="logout">Log Out <i class="fas fa-sign-out-alt"></i></div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <div class="user-info">
                <i class="fas fa-user-circle"></i> John Doe
            </div>
        </div>

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
                    <td>1</td>
                    <td>Audrey Mckinney</td>
                    <td>Audrey Mckinney</td>
                    <td>Audrey Mckinney</td>
                    <td>Audrey Mckinney</td>
                    <td>Audrey Mckinney</td>
                    <td><button class="aksi-btn"><i class="fas fa-edit"></i></button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Savannah Howard</td>
                    <td>Savannah Howard</td>
                    <td>Savannah Howard</td>
                    <td>Savannah Howard</td>
                    <td>Savannah Howard</td>
                    <td><button class="aksi-btn"><i class="fas fa-edit"></i></button></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Morris Cooper</td>
                    <td>Morris Cooper</td>
                    <td>Morris Cooper</td>
                    <td>Morris Cooper</td>
                    <td>Morris Cooper</td>
                    <td><button class="aksi-btn"><i class="fas fa-edit"></i></button></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Victoria Lane</td>
                    <td>Victoria Lane</td>
                    <td>Victoria Lane</td>
                    <td>Victoria Lane</td>
                    <td>Victoria Lane</td>
                    <td><button class="aksi-btn"><i class="fas fa-edit"></i></button></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Stella Warren</td>
                    <td>Stella Warren</td>
                    <td>Stella Warren</td>
                    <td>Stella Warren</td>
                    <td>Stella Warren</td>
                    <td><button class="aksi-btn"><i class="fas fa-edit"></i></button></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            © 2025 Dinas Komunikasi dan Informatika. All rights reserved.
        </div>
    </div>

    <script>
        // Contoh interaktivitas sederhana
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.classList.toggle('btn-active');
                this.style.backgroundColor = '#4a3d8c';
                this.style.color = 'white';
            });
        });

        // Cari data
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

</body>

</html>