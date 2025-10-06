// Import TailwindCSS
import '../css/app.css';
import './bootstrap';
import 'flowbite';
import $ from 'jquery';
window.$ = window.jQuery = $;
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import axios from 'axios';
import './sidebar';
import './navbar';
import { Tooltip } from 'flowbite';
import './darkmode';
import 'select2/dist/css/select2.min.css';
import 'select2';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Import SweetAlert2
window.Swal = Swal;
document.addEventListener('DOMContentLoaded', function() {
    $('#asset_id').select2({
        placeholder: "-- Pilih Aset --",
        allowClear: true,
        width: '100%',
        language: {
            noResults: function() {
                return "Tidak ada hasil ditemukan";
            },
            searching: function() {
                return "Mencari...";
            }
        }
    });
});


window.Alpine = Alpine
Alpine.start()
