import './styles/admin-datatables.css';
// import 'datatables.net-dt/js/dataTables.dataTables.js';

import 'datatables.net-dt/js/dataTables.dataTables.js';

$(document).ready(function() {
    console.log('Applying DT');
    $('#dataTable').DataTable();
});