jQuery(document).ready(function ($) {
  $('#finish-lesson-btn').click(function () {
    var lekcijaId = $(this).data('lekcija-id');

    $.ajax({
      url: finishLessonParams.ajaxurl,
      method: 'POST',
      data: {
        action: 'finish_lesson',
        lekcija_id: lekcijaId,
      },
      success: function (response) {
        if (response.success) {
          $('#finish-lesson-btn')
            .text('Lekcija završena')
            .css('background-color', 'green');
        } else {
          alert(response.data.message);
        }
      },
    });
  });
});
