// any CSS you import will output into a single css file (app.scss in this case)
import './styles/admin.scss';
import 'dropzone/dist/dropzone.css';

// JS import
import 'bootstrap/dist/js/bootstrap.bundle.min';
import 'startbootstrap-sb-admin/dist/js/scripts';

var $ = require('jquery');

window.Dropzone = require('dropzone/dist/min/dropzone.min');

$('.custom-file-input').on('change', function(event) {
    var inputFile = event.currentTarget;
    $(inputFile).parent()
        .find('.custom-file-label')
        .html(inputFile.files[0].name);
});

(function(){
    $('#msbo').on('click', function(){
        $('body').toggleClass('msb-x');
    });
}());