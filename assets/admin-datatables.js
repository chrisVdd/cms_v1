// Personal database style
import './styles/admin-datatables.scss';

import 'datatables.net-dt/js/dataTables.dataTables.js';

$(document).ready(function() {

    // Is my file loaded ?
    console.log('Applying Datatable here');

    $('#dataTable').DataTable();
});