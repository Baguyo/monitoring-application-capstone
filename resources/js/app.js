import './bootstrap';
import 'admin-lte';
import '../css/app.css';

import Swal from 'sweetalert2';

import {Html5QrcodeScanner} from "html5-qrcode"

window.Html5QrcodeScanner = Html5QrcodeScanner;

// import DataTableSelect from '../../node_modules/datatables.net-select/js/dataTables.select';

window.Swal = Swal;

// https://www.codegrepper.com/code-examples/whatever/laravel+sweetalert2





// $('.delete').submit(function (e) { 
//     e.preventDefault();
//     Swal.fire({
//         title: 'Are you sure you want to delele this record ?',
//         text: " All data associated to this record will also be deleted ! ",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Yes, delete it!'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             this.submit();
//         }
//     })
// });

// $('.restore').submit(function (e) { 
//     e.preventDefault();
//     Swal.fire({
//         title: 'Are you sure you want to restore this record ?',
//         text: " All data associated to this record will also be restored ",
//         icon: 'question',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Yes, restore it!'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             this.submit();
//         }
//     })
// });

// $('.f-delete').submit(function (e) { 
//     e.preventDefault();
//     Swal.fire({
//         title: 'Are you sure you want to permanently delete this record ?',
//         text: " All data associated to this record will also be deleted permanently ",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Yes, delete it!'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             this.submit();
//         }
//     })
// });




    