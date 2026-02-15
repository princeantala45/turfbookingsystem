document.addEventListener("DOMContentLoaded", function () {

  const t1 = document.querySelectorAll(".t1");
  const product_box = document.querySelectorAll(".product-box");
  const boxes = document.querySelectorAll(".feauter-h3");
  const feauter_img = document.querySelectorAll(".feauter-img");
  const feauter_text = document.querySelectorAll(".feauter-text");

  window.addEventListener("scroll", function () {

    t1.forEach(function (el) {
      if (el.getBoundingClientRect().top < window.innerHeight) {
        el.style.transform = "scale(1)";
        el.style.transition = "transform 1s";
      }
    });

    product_box.forEach(function (el) {
      if (el.getBoundingClientRect().top < window.innerHeight) {
        el.style.transform = "scale(1)";
        el.style.transition = "transform 1s";
      }
    });

    boxes.forEach(function (el) {
      if (el.getBoundingClientRect().top < window.innerHeight) {
        el.style.transform = "translateX(0)";
        el.style.opacity = "1";
        el.style.transition = "0.8s ease";
      }
    });

    feauter_img.forEach(function (el) {
      if (el.getBoundingClientRect().top < window.innerHeight) {
        el.style.transform = "scale(1)";
        el.style.opacity = "1";
        el.style.transition = "0.8s ease";
      }
    });

    feauter_text.forEach(function (el) {
      if (el.getBoundingClientRect().top < window.innerHeight) {
        el.style.transform = "translateY(0px)";
        el.style.opacity = "1";
        el.style.transition = "0.6s ease";
      }
    });

  });

});
