$ = jQuery

/**
 * La funzione per salvare il form, senza ricaricare la pagina.
 */

window.save_form_options = (e) => {
    e.preventDefault()
    formData = new FormData(e.currentTarget)

    if(formData.has('type') && formData.get('type') == 'cta'){
        tinymce.triggerSave()
    }
    
    $.ajax({
        type: 'post',
        url: wwup.ajaxurl,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: () => {
          $(`#submit${formData.get('type')}`).prepend($('<i/>', {
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
          }).then(result => {
            if(result.isConfirmed){
                if(formData.has('type') && formData.get('type') == 'options'){
                    return window.location.reload()
                }
            }
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
            $(`#submit${formData.get('type')} i`).remove()
        }
    })
}   