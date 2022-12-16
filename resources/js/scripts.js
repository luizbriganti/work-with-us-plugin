$ = jQuery

window.save_form_options = (e, type) => {
    e.preventDefault()
    tinymce.triggerSave()
    formData = new FormData(e.currentTarget)

    $.ajax({
        type: 'post',
        url: wwup.ajaxurl,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: () => {
          $('#submit').prepend($('<i/>', {
            class: 'mdi mdi-spin mdi-loading'
          }))
        },
        success: (response) => {
          Swal.fire({
              title: 'Option updated',
              icon: 'success',
              iconHtml: '<i class="mdi mdi-check"></i>',
              confirmButtonText: 'Ok',
              showCloseButton: true,
          })
        },
        error: error => {
          Swal.fire({
              title: 'Error',
              text: error,
              icon: 'error',
              iconHtml: '<i class="mdi mdi-close-circle"></i>',
              confirmButtonText: 'Ok',
              showCloseButton: true,
          })
        },
        complete: () => {
          $(`#submit i`).remove()
        }
    })
}   

$(document).ready(function(){
    if(tinymce !== undefined){
        tinymce.init({
            selector: 'textarea#call-to-action',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
          });
    }
})