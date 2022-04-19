const { Dropzone } = require("dropzone");
Dropzone.autoDiscover = false;

$(document).ready(function () {
    const taskController = new TaskControls();
});

class TaskControls {
    constructor() {
        this._initSingleImageUpload();
        this._initGalleries();
    }

    // Single Image Upload initialization
    _initSingleImageUpload() {
        this._singleImageUploadExample = document.getElementById('taskImgCover');
        const singleImageUpload = new SingleImageUpload(
            this._singleImageUploadExample);
    }

    _initGalleries() {
        new Dropzone('#taskGallery', {
            autoProcessQueue: false,
            dictDefaultMessage: "Drop your files here!",
            url: 'https://httpbin.org/pos',
            init: function () {
                let myDropzone = this;
                document.querySelector("button[type=submit]").addEventListener("click", function(e) {
                    // Make sure that the form isn't actually being sent.
                   /* e.preventDefault();
                    e.stopPropagation();*/

                    //document.querySelector('input[name="gallery"]').files = myDropzone.getQueuedFiles();

                   /* let pendingFiles = myDropzone.getQueuedFiles();
                    pendingFiles.forEach($file => {
                        const reader  = new FileReader();
                        reader.readAsDataURL($('input[name="gallery"]').prop("files"));
                       console.log($file);
                    });*/

                    //console.log(myDropzone.getQueuedFiles());
                    //console.log(myDropzone.getAcceptedFiles());
                    //myDropzone.processQueue();
                });
                /*this.on('success', function (file, responseText) {
                    console.log(responseText);
                });*/
            },
            acceptedFiles: 'image/*',
            thumbnailWidth: 160,
            previewTemplate: DropzoneTemplates.previewTemplate,
        });
    }
}
