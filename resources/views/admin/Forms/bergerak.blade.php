<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="space-y-4">
        <div>
            <label for="kode" class="block text-sm font-medium text-gray-700 mb-1">Kode</label>
            <input type="text" id="kode" name="kode"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label for="merk" class="block text-sm font-medium text-gray-700 mb-1">Merk</label>
            <input type="text" id="merk" name="merk"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <input type="text" id="kategori" name="kategori"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="serialNumber" class="block text-sm font-medium text-gray-700 mb-1">Serial Number</label>
                <input type="text" id="serialNumber" name="serialNumber"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label for="tahunProduksi" class="block text-sm font-medium text-gray-700 mb-1">Tahun Produksi</label>
                <input type="text" id="tahunProduksi" name="tahunProduksi"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <div>
            <label for="namaAset" class="block text-sm font-medium text-gray-700 mb-1">Nama Aset</label>
            <input type="text" id="namaAset" name="namaAset"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
            <input type="text" id="type" name="type"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label for="grupKategori" class="block text-sm font-medium text-gray-700 mb-1">Grup Kategori</label>
            <input type="text" id="grupKategori" name="grupKategori"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label for="kondisi" class="block text-sm font-medium text-gray-700 mb-1">Kondisi</label>
            <input type="text" id="kondisi" name="kondisi"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label for="tanggalPembelian" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembelian</label>
            <input type="date" id="tanggalPembelian" name="tanggalPembelian"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>
</div>


<div id="table-bergerak" class="hidden" class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray==-200 bg-indigo-800">
                <thead class="bg-indigo-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Aset
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Serial
                            Number</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Merk/Type
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tahun
                            Produksi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kondisi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">10</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-yellow-600 hover:text-yellow-800">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">1</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-yellow-600 hover:text-yellow-800">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">2</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-yellow-600 hover:text-yellow-800">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">2</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-yellow-600 hover:text-yellow-800">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">9</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-yellow-600 hover:text-yellow-800">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>