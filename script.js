let newButton = document.getElementById("newButton");
let closeButton = document.getElementById("closeButton");
let form = document.getElementById("userForm");
let formPresentation = document.getElementById("presentationFormSection");
let body = document.getElementById("body");
newButton.addEventListener("click", function () {
  if (form) {
    form.classList.add("form_section_display");
  }
  if (formPresentation) {
    formPresentation.classList.toggle("presentationFormSection_display");
  }
});

closeButton.addEventListener("click", function () {
  if (form) {
    form.classList.remove("form_section_display");
  }
  if (formPresentation) {
    formPresentation.classList.toggle("presentationFormSection_display");
  }
});







