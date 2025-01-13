document
  .getElementById('submit-exam')
  .addEventListener('click', function (event) {
    event.preventDefault(); // Prevent the form from submitting immediately

    // Loop through all the questions and find the 'answer_text' fields
    const questions = document.querySelectorAll('.exam-questions .question');
    questions.forEach(function (question) {
      const questionId = question.getAttribute('data-type');
      const textAnswerField = document.getElementById(
        'answer_' + questionId + '_text'
      );

      // Check if the text field exists
      if (textAnswerField) {
        console.log(
          'Answer for Question ID ' + questionId + ':',
          textAnswerField.value
        );
      }
    });
  });
