// Import TailwindCSS
import '../css/app.css';
import 'select2/dist/css/select2.min.css';
import 'flowbite';
// import 'flowbite-datepicker';
// import "@fortawesome/fontawesome-free/css/all.min.css"; 
// import "flowbite/src/themes/default";
// import "flowbite/dist/flowbite.min.css";
// import "flowbite-datepicker/dist/css/flowbite-datepicker.min.css"
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';


// import 'flowbite';
// import 'flowbite-datepicker';    


// Bootstrap & custom JS
import './bootstrap';
import './sidebar';
import './navbar';
// import './search';

// jQuery
import jquery from 'jquery';
window.$ = window.jQuery = jquery;

// Select2: attach ke jQuery global
import select2 from 'select2/dist/js/select2.full.js';
select2(window.jQuery);


// AlpineJS
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// SweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal;

// Axios
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Flowbite components
import { Tooltip } from 'flowbite';
document.addEventListener('DOMContentLoaded', () => {
    const dateInputs = document.querySelectorAll('input[data-datepicker]');
    dateInputs.forEach(input => {
        flatpickr(input, {
            dateFormat: "Y-m-d",
            maxDate: input.dataset.maxDate || "today",
            allowInput: true,
            theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        });
    });
});
// Inisialisasi Select2 saat DOM siap
// $(document).ready(function () {
//     console.log("✅ jQuery version:", $.fn.jquery);
//     console.log("✅ Select2 loaded:", typeof $.fn.select2 === 'function');

//     $('.js-select2').select2({
//         width: '100%',
//         placeholder: 'Pilih Opsi',
//         allowClear: true
//     });
// });

// $(document).ready(function() {
//     $('.js-select2').select2({
//         width: '100%',
//         placeholder: 'Pilih Opsi',
//         allowClear: true,
//         // Optional: jika ingin custom template
//         templateSelection: function(data, container) {
//             if (!data.id) return data.text;
//             return $('<span>' + data.text + '</span>');
//         }
//     });

//     console.log("✅ Select2 initialized with uniform height & width");
// });

$(document).ready(function() {
    $('.js-select2').select2({
        width: '100%',
        placeholder: 'Pilih Opsi',
        allowClear: true
    });
});

$(document).ready(function() {
    $('.js-select2').select2({
        placeholder: "-- Pilih  --", // wajib
        allowClear: true, // wajib agar tombol hapus muncul
        width: '100%'
    });
});
$('#modalEdit').on('shown.bs.modal', function () {
    $('.js-select2').select2({
        placeholder: "-- Pilih  --",
        allowClear: true,
        width: '100%'
    });
});


