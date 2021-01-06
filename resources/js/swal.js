// npm install sweetalert2 --save
import Swal from 'sweetalert2'

// global sweetalert2 instance
window.Swal = Swal;
 
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

// global Toast instance
window.Toast = Toast;