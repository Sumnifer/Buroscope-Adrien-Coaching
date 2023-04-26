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



document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('checkbox').addEventListener('change', function () {
    setInterval(function () {
      moveRight();
    }, 3000);
  });

  let slideCount = document.querySelectorAll('#slider ul li').length;
  let slideWidth = document.querySelector('#slider ul li').offsetWidth;
  let slideHeight = document.querySelector('#slider ul li').offsetHeight;
  let sliderUlWidth = slideCount * slideWidth;

  document.getElementById('slider').style.width = slideWidth + 'px';
  document.getElementById('slider').style.height = slideHeight + 'px';

  document.querySelector('#slider ul').style.width = sliderUlWidth + 'px';
  document.querySelector('#slider ul').style.marginLeft = -slideWidth + 'px';

  document.querySelector('#slider ul li:last-child').parentNode.prepend(
      document.querySelector('#slider ul li:last-child')
  );

  function moveLeft() {
    let sliderUl = document.querySelector('#slider ul');
    let left = parseInt(sliderUl.style.left) || 0;
    left += slideWidth;
    sliderUl.style.left = left + 'px';
    if (left >= slideWidth) {
      sliderUl.style.left = '';
      document.querySelector('#slider ul li:last-child').parentNode.prepend(
          document.querySelector('#slider ul li:last-child')
      );
    }
  }

  function moveRight() {
    let sliderUl = document.querySelector('#slider ul');
    let left = parseInt(sliderUl.style.left) || 0;
    left -= slideWidth;
    sliderUl.style.left = left + 'px';
    if (Math.abs(left) >= sliderUlWidth) {
      sliderUl.style.left = '';
      document.querySelector('#slider ul li:first-child').parentNode.appendChild(
          document.querySelector('#slider ul li:first-child')
      );
    }
  }

  document.querySelector('a.control_prev').addEventListener('click', function () {
    moveLeft();
  });

  document.querySelector('a.control_next').addEventListener('click', function () {
    moveRight();
  });
});
