import Dropzone from 'dropzone';
import Sortable from 'sortablejs';

// Disable the autodiscover for dropZone
Dropzone.autoDiscover = false;

$(document).ready(function() {

    var myDropzone = new Dropzone(".dropzone", {
        url: "%kernel.project_dir%/storage/uploads/post_reference",
        maxFiles: 10,
        addRemoveLinks: true,
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 100,
    });

    // $(".dropzone").dropzone({
    //     url: "/file/post"
    // });
});






    // var postDropzone = new Dropzone('.dropzone', {
    //
    //     url: '%kernel.project_dir%/storage/uploads/post_reference',
    //     maxFiles: 10,
    //     addRemoveLinks: true,
    //     autoProcessQueue: false,
    //     uploadMultiple: true,
    //     parallelUploads: 100,
    // });
    //
    // postDropzone.on("addedFile", function (file) {
    //     file.previewElement.addEventListener("click", function () {
    //         postDropzone.removeFile(file);
    //     });
    // });

//
//     // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
//     var
//         previewNode = document.querySelector("#template");
//         previewNode.id = "";
//
//     var
//         previewTemplate = previewNode.parentNode.innerHTML;
//         previewNode.parentNode.removeChild(previewNode);
//
//     var myDropzone = new Dropzone("#dropzone-container", { // Make the whole body a dropzone
//         url: "{{ path('admin_post_add_reference') }}", // Set the url
//         // url: "/upload", // Set the url
//         thumbnailWidth: 80,
//         thumbnailHeight: 80,
//         parallelUploads: 20,
//         previewTemplate: previewTemplate,
//         autoQueue: false, // Make sure the files aren't queued until manually added
//         previewsContainer: "#previews", // Define the container to display the previews
//         clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
//     });
//
//     myDropzone.on("addedfile", function(file) {
//         // Hookup the start button
//         file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
//     });
//
//     // Update the total progress bar
//     myDropzone.on("totaluploadprogress", function(progress) {
//         document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
//     });
//
//     myDropzone.on("sending", function(file) {
//         // Show the total progress bar when upload starts
//         document.querySelector("#total-progress").style.opacity = "1";
//         // And disable the start button
//         file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
//     });
//
// // Hide the total progress bar when nothing's uploading anymore
//     myDropzone.on("queuecomplete", function(progress) {
//         document.querySelector("#total-progress").style.opacity = "0";
//     });
//
// // Setup the buttons for all transfers
// // The "add files" button doesn't need to be setup because the config
// // `clickable` has already been specified.
//     document.querySelector("#actions .start").onclick = function() {
//         myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
//     };
//     document.querySelector("#actions .cancel").onclick = function() {
//         myDropzone.removeAllFiles(true);
// // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
// var
//     previewNode = document.querySelector("#template");
//     previewNode.id = "";
//
// var
//     previewTemplate = previewNode.parentNode.innerHTML;
//     previewNode.parentNode.removeChild(previewNode);
//
//
// var myDropzone = new Dropzone("#dropzone-container", { // Make the whole body a dropzone
//     url: "{{ path('admin_post_add_reference') }}", // Set the url
//     // url: "/upload", // Set the url
//     thumbnailWidth: 80,
//     thumbnailHeight: 80,
//     parallelUploads: 20,
//     previewTemplate: previewTemplate,
//     autoQueue: false, // Make sure the files aren't queued until manually added
//     previewsContainer: "#previews", // Define the container to display the previews
//     clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
// });
//
// myDropzone.on("addedfile", function(file) {
//     // Hookup the start button
//     file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
// });
//
// // Update the total progress bar
// myDropzone.on("totaluploadprogress", function(progress) {
//     document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
// });
//
// myDropzone.on("sending", function(file) {
//     // Show the total progress bar when upload starts
//     document.querySelector("#total-progress").style.opacity = "1";
//     // And disable the start button
//     file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
// });
//
// // Hide the total progress bar when nothing's uploading anymore
// myDropzone.on("queuecomplete", function(progress) {
//     document.querySelector("#total-progress").style.opacity = "0";
// });
//
// // Setup the buttons for all transfers
// // The "add files" button doesn't need to be setup because the config
// // `clickable` has already been specified.
// document.querySelector("#actions .start").onclick = function() {
//     myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
// };
// document.querySelector("#actions .cancel").onclick = function() {
//     myDropzone.removeAllFiles(true);
// };
// Dropzone.autoDiscover = false;
//
// $(document).ready(function() {
//
//     var referenceList = new ReferenceList($('.js-reference-list'));
//
//     initializeDropzone(referenceList);
// });
//
// class ReferenceList
// {
//     constructor($element) {
//
//         this.$element = $element;
//         this.sortable = Sortable.create(this.$element[0], {
//             handle: '.drag-handle',
//             animation: 150,
//             onEnd: () => {
//                 $.ajax({
//                     url: this.$element.data('url')+'/reorder',
//                     method: 'POST',
//                     data: JSON.stringify(this.sortable.toArray())
//                 })
//             }
//         });
//         this.references = [];
//
//         this.render();
//
//         this.$element.on('click', '.js-reference-delete', (event) => {
//             this.handleReferenceDelete(event);
//         });
//
//         this.$element.on('blur', '.js-edit-filename', (event) => {
//             this.handleReferenceEditFilename(event);
//         });
//
//         $.ajax({
//             url: this.$element.data('url')
//         }).then(data => {
//             this.references = data;
//             this.render();
//         })
//     }
//
//     addReference(reference) {
//         this.references.push(reference);
//         this.render();
//     }
//
//     handleReferenceDelete(event) {
//         const $li = $(event.currentTarget).closest('.list-group-item');
//         const id = $li.data('id');
//         $li.addClass('disabled');
//         $.ajax({
//             url: '/admin/post/reference/'+id,
//             method: 'DELETE'
//         }).then(() => {
//             this.references = this.references.filter(reference => {
//                 return reference.id !== id;
//             });
//             this.render();
//         });
//     }
//
//     handleReferenceEditFilename(event) {
//         const $li = $(event.currentTarget).closest('.list-group-item');
//         const id = $li.data('id');
//         const reference = this.references.find(reference => {
//             return reference.id === id;
//         });
//         reference.originalFilename = $(event.currentTarget).val();
//
//         $.ajax({
//             url: '/admin/post/references/'+id,
//             method: 'PUT',
//             data: JSON.stringify(reference)
//         });
//     }
//
//     render() {
//         const itemsHtml = this.references.map(reference => {
//             return `
//                 <div class="d-flex my-2" id="sortable-item">
//                     <div class="p-2 flex-left">
//                         <span class="drag-handle">
//                             <i class="fas fa-arrows-alt"></i>
//                         </span>
//                     </div>
//
//                     <div class="p-2 flex-fill">
//                         <input type="text" value="${reference.originalFilename}"
//                                class="form-control js-edit-filename" />
//                     </div>
//
//                     <div class="p-2 flex-right">
//                         <a href="/admin/post/references/${reference.id}/download" class="btn btn-primary">
//                             <span class="fa fa-download" style="vertical-align: middle"></span>
//                         </a>
//                         <button class="js-reference-delete btn btn-danger">
//                             <span class="fa fa-trash"></span>
//                         </button>
//                     </div>
//                 </div>
//             `});
//         this.$element.html(itemsHtml.join(''));
//     }
// }
//
// /**
//  * @param {ReferenceList} referenceList
//  */
// function initializeDropzone(referenceList) {
//
//     var formElement = document.querySelector('.js-reference-dropzone');
//
//     if (!formElement) {
//         return;
//     }
//
//     var dropzone = new Dropzone(formElement, {
//         paramName: 'reference',
//         init: function () {
//
//             this.on('success', function (file, data) {
//                 referenceList.addReference(data);
//             })
//
//             this.on('error', function (file, data) {
//                 if (data.detail) {
//                     this.emit('error', file, data.detail);
//                 }
//             })
//         }
//     });
// }