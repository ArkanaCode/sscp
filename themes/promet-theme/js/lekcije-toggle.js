document.addEventListener('DOMContentLoaded', function () {
  // Get all toggle buttons
  const toggleButtons = document.querySelectorAll('.category-btn');

  toggleButtons.forEach((button) => {
    button.addEventListener('click', function () {
      const content = this.nextElementSibling; // The .category-content div

      // Toggle the visibility of the content
      if (content.style.display === 'none' || content.style.display === '') {
        content.style.display = 'block';
      } else {
        content.style.display = 'none';
      }
    });
  });
});
