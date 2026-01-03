// Select all the question buttons
const questions = document.querySelectorAll(".faq-question");

questions.forEach((question) => {
  question.addEventListener("click", function() {
    
    // Toggle the "active" class to rotate the arrow
    this.classList.toggle("active");

    // Get the next element (the answer div)
    const answer = this.nextElementSibling;

    // Check if the answer is currently open
    if (answer.style.maxHeight) {
      // If open, close it (set height to null)
      answer.style.maxHeight = null;
    } else {
      // If closed, open it to its full scroll height
      answer.style.maxHeight = answer.scrollHeight + "px";
    }
  });
});



