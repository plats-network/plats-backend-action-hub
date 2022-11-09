const { Dropzone } = require("dropzone");
Dropzone.autoDiscover = false;
require('jquery-repeater-form');

$(document).ready(function () {
  const taskController = new TaskControls();
});

class TaskControls {
  constructor() {
    this._initSingleImageUpload();
    this._initGalleries();
    this._initLocation();
    this._checkType();
  }

  /**
   *
   * @private
   */
  _initLocation() {
    let _this = this;
    $('.js-repeater').repeater({
      isFirstItemUndeletable: true,
      show: function () {
        let $this = $(this);
        $this.attr('data-repeater-item', '');
        let btnDelete = $this.find('.js-location-delete');
        if (btnDelete.length) {
          btnDelete.attr('data-repeater-delete', '');
          btnDelete.attr('data-location-id', '');
          btnDelete.removeClass('js-location-delete');//always set bottom of condition
        }
        $this.slideDown();
      },
    });

    $('.js-location-delete').on('click', function () {
      _this._deleteLocationItem($(this));
    });
  }

  /**
   *
   * @param $this jquery element
   * @private
   */
  _deleteLocationItem($this) {
    let locationId = $this.attr('data-location-id');
    let eFrom = $this.closest('form');
    console.log(eFrom.length);
    $this.closest('div[data-repeater-item=' + locationId + ']').remove();
    eFrom.append('<input type="hidden" name="location_delete[]" value="'+ locationId +'">');
    return true;
  }

  // Single Image Upload initialization
  _initSingleImageUpload() {
    this._singleImageUploadExample = document.getElementById('taskImgCover');
    const singleImageUpload = new SingleImageUpload(this._singleImageUploadExample);
  }

  _initGalleries() {
    new Dropzone('#taskGallery', {
      autoProcessQueue: false,
      maxFilesize: 2,
      dictDefaultMessage: "Drop your files here!",
      url: 'https://httpbin.org/pos', // api post file
      removedfile: function(file) {
        console.log(file.upload.filename);
      },
      init: function () {
        let myDropzone = this;
        document.querySelector("button[type=submit]").addEventListener("click", function(e) {
          // e.preventDefault();
          // e.stopPropagation();

          // document.querySelector('input[name="gallery"]').files = myDropzone.getQueuedFiles();
          // let pendingFiles = myDropzone.getQueuedFiles();
          // pendingFiles.forEach($file => {
          //   const reader  = new FileReader();
          //   reader.readAsDataURL($('input[name="gallery"]').prop("files"));
          //   console.log($file);
          // });

          //console.log(myDropzone.getQueuedFiles());
          //console.log(myDropzone.getAcceptedFiles());
          //myDropzone.processQueue();
        });
        this.on('success', function (file, responseText) {
          console.log(responseText);
        });
      },
      acceptedFiles: 'image/*',
      thumbnailWidth: 160,
      previewTemplate: DropzoneTemplates.previewTemplate,
    });
  }

  _checkType() {
   $('.select2-hidden-accessible').on('change', function() {
      alert(3);
      // alert( $(this).find(":selected").val() );
    });
  }
}
