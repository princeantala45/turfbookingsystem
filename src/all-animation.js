  // ----------------------product-page-animation------------------------
  let t1 = document.querySelectorAll(".t1");

  window.addEventListener("scroll", function () {
    t1.forEach(function (el) {
      let top = el.getBoundingClientRect().top;
      if (top < window.innerHeight) {
        el.style.transform = "scale(1)";
        el.style.transition = "transform 1s";
      }
    });
  });


  // ----------------------product-page-animation------------------------
  let product_box = document.querySelectorAll(".product-box");

  window.addEventListener("scroll", function () {
    product_box.forEach(function (el) {
      let top = el.getBoundingClientRect().top;
      if (top < window.innerHeight) {
        el.style.transform = "scale(1)";
        el.style.transition = "transform 1s";
      }
    });
  });


  // --------------------feauter-page-animation-----------------------------
  let boxes = document.querySelectorAll(".feauter-h3");

  window.addEventListener("scroll", () => {
    boxes.forEach((el, i) => {
      let top = el.getBoundingClientRect().top;
      if (top < window.innerHeight) {
          el.style.transform = "translateX(0)";
          el.style.opacity = "1";
          el.style.transition = "0.8s ease";
      }
    });
  });

  let feauter_img = document.querySelectorAll(".feauter-img");

  window.addEventListener("scroll", () => {
    feauter_img.forEach((el, i) => {
      let top = el.getBoundingClientRect().top;
      if (top < window.innerHeight) {
          el.style.transform = "scale(1)";
          el.style.opacity = "1";
          el.style.transition = "0.8s ease";
      }
    });
  });

  let feauter_text = document.querySelectorAll(".feauter-text");

  window.addEventListener("scroll", () => {
    feauter_text.forEach((el, i) => {
      let top = el.getBoundingClientRect().top;
      if (top < window.innerHeight) {
          el.style.transform = "translateY(0px)";
          el.style.opacity = "1";
          el.style.transition = "0.6s ease";
      }
    });
  });

  
