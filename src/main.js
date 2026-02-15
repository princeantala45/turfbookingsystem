document.addEventListener("DOMContentLoaded", function () {

  // --------------------------up-errow-----------------------------------
  const upArrow = document.querySelector(".up-errow");

  if (upArrow) {
    upArrow.style.display = "none";

    window.addEventListener("scroll", () => {
      if (window.scrollY > 555) {
        upArrow.style.display = "flex";
      } else {
        upArrow.style.display = "none";
      }
    });

    upArrow.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

// ==================================================================
let menu = document.querySelector(".menu");
let navlinks = document.querySelector("#navlinks");
menu.addEventListener("click", () => {
  navlinks.classList.toggle("show-menu");
});

// --------------------slider-rotation----------------------------
  const slides = document.querySelectorAll(".slide");
  const buttons = document.querySelectorAll(".circle-button");

  if (slides.length > 0) {

    let currentSlide = 0;

    slides[currentSlide].classList.add("active");

    buttons.forEach((button, index) => {
      button.addEventListener("click", () => {
        changeSlide(index);
      });
    });

    function changeSlide(index) {
      slides[currentSlide].classList.remove("active");
      slides[currentSlide].style.display = "none";

      slides[index].style.display = "flex";

      setTimeout(() => {
        slides[index].classList.add("active");
      }, 20);

      currentSlide = index;
    }

    function autoSlide() {
      setTimeout(() => {
        let next = (currentSlide + 1) % slides.length;
        changeSlide(next);
        autoSlide();
      }, 6000);
    }

    autoSlide();
  }

  // -------------------------slider-animation----------------------
  const h1 = document.querySelector(".slider-heading");
  const p = document.querySelector(".p");
  const image = document.querySelector(".image");

  window.addEventListener("load", function () {
    if (h1) {
      h1.style.transform = "translatey(160px)";
      h1.style.transition = "transform 0.9s";
    }

    if (p) {
      p.style.transform = "translate(0px)";
      p.style.transition = "transform 0.9s";
    }

    if (image) {
      image.style.transform = "translate(20px)";
      image.style.transition = "transform .8s";
    }
  });

  // --------------------------welcome animation-------------------------------
  const welcome_h1 = document.querySelector("#welcome-h1");

  if (welcome_h1) {
    window.addEventListener("scroll", function () {
      welcome_h1.style.transform = "translateY(-35px)";
      welcome_h1.style.transition = "transform 1.8s";
    });
  }

  window.addEventListener("scroll", function () {

    document.querySelectorAll("#welcome-text1").forEach(el => {
      el.style.transform = "translateX(0px)";
      el.style.transition = "transform 1.2s";
    });

    setTimeout(() => {
      document.querySelectorAll("#welcome-text2").forEach(el => {
        el.style.transform = "translateX(0px)";
        el.style.transition = "transform 1.2s";
      });
    }, 200);

    setTimeout(() => {
      document.querySelectorAll("#welcome-text3").forEach(el => {
        el.style.transform = "translateX(0px)";
        el.style.transition = "transform 1.2s";
      });
    }, 350);
  });

  // -------------------feauter-box-----------------------------
  window.addEventListener("scroll", () => {

    const infobox1 = document.getElementById("info-box1");
    const infobox2 = document.getElementById("info-box2");
    const infobox3 = document.getElementById("info-box3");
    const infobox4 = document.getElementById("info-box4");

    if (!infobox1) return;

    let triggerPoint = window.innerHeight - 20;
    let boxTop = infobox1.getBoundingClientRect().top;

    if (boxTop < triggerPoint) {

      infobox1.style.transform = "translateY(0px)";
      infobox1.style.opacity = "1";

      if (infobox2) {
        setTimeout(() => {
          infobox2.style.transform = "translateY(0px)";
          infobox2.style.opacity = "1";
        }, 100);
      }

      if (infobox3) {
        setTimeout(() => {
          infobox3.style.transform = "translateY(0px)";
          infobox3.style.opacity = "1";
        }, 200);
      }

      if (infobox4) {
        setTimeout(() => {
          infobox4.style.transform = "translateY(0px)";
          infobox4.style.opacity = "1";
        }, 300);
      }
    }
  });

  // -------------------------------refresh-data-------------------------
  window.addEventListener("scroll", function () {

    const counters = document.querySelectorAll(".count");

    counters.forEach(counter => {

      let top = counter.getBoundingClientRect().top;

      if (top < window.innerHeight && !counter.started) {

        counter.started = true;

        let target = +counter.getAttribute("data-target");
        let current = 0;
        let increment = target / 100;

        function updateCount() {
          current += increment;

          if (current >= target) {
            counter.innerText = target.toLocaleString() + "+";
          } else {
            counter.innerText = Math.floor(current).toLocaleString() + "+";
            setTimeout(updateCount, 20);
          }
        }

        updateCount();
      }
    });
  });

  // -----------------------mission-and-vision-------------------------------
  const mission1 = document.querySelector(".mission-and-vision-h1-1");
  const mission2 = document.querySelector(".mission-and-vision-h1-2");
  const elements = document.querySelectorAll(".vision-text-1, .vision-text-2, .vision-text-3, .mission-text");

  window.addEventListener("scroll", function () {

    if (mission1) {
      mission1.style.transform = "scale(1.2)";
      mission1.style.transition = "transform 1.34s";
      mission1.style.opacity = 1;
    }

    if (mission2) {
      mission2.style.transform = "scale(1.2)";
      mission2.style.transition = "transform 1.34s";
      mission2.style.opacity = 1;
    }

    let triggerPoint = window.innerHeight - 30;

    elements.forEach(el => {
      let position = el.getBoundingClientRect().top;

      if (position < triggerPoint) {
        el.style.transform = "translateX(0px)";
        el.style.transition = "transform 1s ease";
      }
    });
  });

});
