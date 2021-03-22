import Dropzone from 'dropzone';
import Sortable from 'sortablejs';

Dropzone.autoDiscover = false;

$(document).ready(function() {

    var referenceList = new ReferenceList($('.js-reference-list'));

    initializeDropzone(referenceList);
});

class ReferenceList
{
    constructor($element) {

        this.$element = $element;
        this.sortable = Sortable.create(this.$element[0], {
            handle: '.drag-handle',
            animation: 150,
            onEnd: () => {
                $.ajax({
                    url: this.$element.data('url')+'/reorder',
                    method: 'POST',
                    data: JSON.stringify(this.sortable.toArray())
                })
            }
        });
        this.references = [];

        this.render();

        this.$element.on('click', '.js-reference-delete', (event) => {
            this.handleReferenceDelete(event);
        });

        this.$element.on('blur', '.js-edit-filename', (event) => {
            this.handleReferenceEditFilename(event);
        });

        $.ajax({
            url: this.$element.data('url')
        }).then(data => {
            this.references = data;
            this.render();
        })
    }

    addReference(reference) {
        this.references.push(reference);
        this.render();
    }

    handleReferenceDelete(event) {
        const $li = $(event.currentTarget).closest('.list-group-item');
        const id = $li.data('id');
        $li.addClass('disabled');
        $.ajax({
            url: '/admin/post/reference/'+id,
            method: 'DELETE'
        }).then(() => {
            this.references = this.references.filter(reference => {
                return reference.id !== id;
            });
            this.render();
        });
    }

    handleReferenceEditFilename(event) {
        const $li = $(event.currentTarget).closest('.list-group-item');
        const id = $li.data('id');
        const reference = this.references.find(reference => {
            return reference.id === id;
        });
        reference.originalFilename = $(event.currentTarget).val();

        $.ajax({
            url: '/admin/post/references/'+id,
            method: 'PUT',
            data: JSON.stringify(reference)
        });
    }

    render() {
        const itemsHtml = this.references.map(reference => {
            return `
                <div class="d-flex my-2" id="sortable-item">
                    <div class="p-2 flex-left">
                        <span class="drag-handle">
                            <i class="fas fa-arrows-alt"></i>
                        </span>
                    </div>
                
                    <div class="p-2 flex-fill">
                        <input type="text" value="${reference.originalFilename}" 
                               class="form-control js-edit-filename" />
                    </div>
                
                    <div class="p-2 flex-right">
                        <a href="/admin/post/references/${reference.id}/download" class="btn btn-primary">
                            <span class="fa fa-download" style="vertical-align: middle"></span>
                        </a>
                        <button class="js-reference-delete btn btn-danger">
                            <span class="fa fa-trash"></span>
                        </button>
                    </div>
                </div>
            `});
        this.$element.html(itemsHtml.join(''));
    }
}

/**
 * @param {ReferenceList} referenceList
 */
function initializeDropzone(referenceList) {

    var formElement = document.querySelector('.js-reference-dropzone');

    if (!formElement) {
        return;
    }

    var dropzone = new Dropzone(formElement, {
        paramName: 'reference',
        init: function () {

            this.on('success', function (file, data) {
                referenceList.addReference(data);
            })

            this.on('error', function (file, data) {
                if (data.detail) {
                    this.emit('error', file, data.detail);
                }
            })
        }
    });
}

// <li class="list-group-item" data-id="${reference.id}">
//     <span class="drag-handle col">
//     <i class="fas fa-arrows-alt"></i>
//     </span>
//
//     <input type="text" value="${reference.originalFilename}"
// class="form-control js-edit-filename">
//
//     <span class="col">
//     <a href="/admin/post/references/${reference.id}/download" class="btn btn-link btn-primary">
//     <span class="fa fa-download" style="vertical-align: middle"></span>
//     </a>
//     <button class="js-reference-delete btn btn-link btn-primary">
//     <span class="fa fa-trash"></span>
//     </button>
//     </span>
//     </li>