/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import 'bootstrap';
import 'startbootstrap-sb-admin/src/scss/styles.scss'
import './styles/admin.scss';
import 'dropzone/dist/dropzone.css';
import '@fortawesome/fontawesome-free/css/all.min.css'

require('@fortawesome/fontawesome-free/css/all.min.css');

var $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/ADMIN.js');

$('.custom-file-input').on('change', function(event) {
    var inputFile = event.currentTarget;
    $(inputFile).parent()
        .find('.custom-file-label')
        .html(inputFile.files[0].name);
});