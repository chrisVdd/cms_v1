console.log('Hello Webpack Encore! Edit me in assets/admin.js');

import './styles/admin.scss';

require('bootstrap');

var $ = require('jquery');

$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});