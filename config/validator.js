$(document).ready(function () {
  var $form = $('#searchForm')

  if ($form.length) {
    $form.validate({
      rules: {
        dtIni: {
          required: function () {
            if ($('#cd').val() == '') {
              return true
            } else {
              return false
            }
          }
        },
        dtFin: {
          required: function () {
            if ($('#cd').val() == '' && $('#dtIni').val() != '') {
              return true
            } else {
              return false
            }
          }
        }
      },
      messages: {},
      errorLabelContainer: '.errorTxt'
    })
  }
})

jQuery.extend(jQuery.validator.messages, {
  required: 'Pelo menos um campo é necessário.'
})
