@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">

<body>



  <!-- jQuery (dibutuhkan oleh Select2) -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#institution_id').select2({
        placeholder: "Pilih Instansi",
        allowClear: true // menampilkan ikon 'x' untuk menghapus pilihan
      });
    });
  </script>
</body>
</html>