<!-- Tambahkan input file surat kehilangan di sini -->
<div id="surat-kehilangan-section-{{ $detail->id }}" class="surat-kehilangan-section mt-2" style="display: none;">
    <label for="surat_kehilangan_{{ $detail->id }}"
        class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Upload
        Surat Kehilangan:</label>
    @if ($opname->status === 'proses')
        <input type="file" id="surat_kehilangan_{{ $detail->id }}" name="surat_kehilangan[{{ $detail->id }}]"
            accept=".pdf,.jpg,.jpeg,.png"
            class="block w-full text-xs border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:text-indigo-300 dark:file:bg-indigo-900/30 dark:hover:file:bg-indigo-800/50">
    @endif
    @if ($detail->surat_kehilangan_path)
        <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">
            File saat ini: <a href="{{ Storage::url($detail->surat_kehilangan_path) }}" target="_blank"
                class="text-indigo-600 dark:text-indigo-400 hover:underline">Lihat
                File</a>
        </small>
    @endif
</div>
