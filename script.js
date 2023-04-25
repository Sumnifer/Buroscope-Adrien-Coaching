let newButton = document.getElementById("newButton");
let closeButton = document.getElementById("closeButton");
let form = document.getElementById("userForm");
let formPresentation = document.getElementById("presentationFormSection");
let body = document.getElementById("body");
if(newButton) {
  newButton.addEventListener("click", function () {
    if (form) {
      form.classList.add("form_section_display");
    }
    if (formPresentation) {
      formPresentation.classList.toggle("presentationFormSection_display");
    }
  });
}

if(closeButton) {
  closeButton.addEventListener("click", function () {
    if (form) {
      form.classList.remove("form_section_display");
    }
    if (formPresentation) {
      formPresentation.classList.toggle("presentationFormSection_display");
    }
  });
}


const sliderImages = document.querySelectorAll(".slider-image");
const prevBtn = document.getElementById("slider-prev");
const nextBtn = document.getElementById("slider-next");
let index = 0;

function showImage(index) {
  sliderImages.forEach((image) => {
    image.style.display = "none";
  });
    sliderImages[index].style.display = "block";
}

function prevImage() {
  index--;
  if (index < 0) {
    index = sliderImages.length - 1;
  }
  showImage(index);
}

function nextImage() {
  console.log("click")
  index++;
  if (index >= sliderImages.length) {
    index = 0;
  }
  showImage(index);
}
if(prevBtn) {
  prevBtn.addEventListener("click", prevImage);
}
if (nextBtn) {
  nextBtn.addEventListener("click", nextImage);
}

showImage(index);








