// Import TailwindCSS
import '../css/app.css';

// Import Axios (untuk request AJAX)
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Import SweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal;

// Contoh: bisa bikin toast default kalau mau
console.log("✅ app.js sudah jalan, Swal:", window.Swal);
