//  const header = document.querySelector(".container");

//     // Set initial styles
//     header.style.position = "relative";
//     header.style.transition = "transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease";
//     header.style.transform = "translateY(-10px)";

//     window.addEventListener("scroll", () => {
//       if (window.scrollY > 0) {
//         header.style.position = "fixed";
//         header.style.top = "0";
//         header.style.left = "0";
//         header.style.width = "100%";
//         header.style.zIndex = "999";
//         header.style.backgroundColor = "rgba(255, 255, 255, 0.94)";
//         header.style.boxShadow = "0 4px 10px rgba(0, 0, 0, 0.1)";
//         header.style.transform = "translateY(0)";
//       } else {
//         header.style.position = "relative";
//         header.style.backgroundColor = "transparent";
//         header.style.boxShadow = "none";
//       }
//     });
// --------------------------up-errow-----------------------------------
  const upArrow = document.querySelector(".up-errow");

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

  // Hide at start
  upArrow.style.display = "none";


// ------------------menu-click-------------------------
let menu = document.querySelector(".menu");
let navlinks = document.querySelector("#navlinks");
menu.addEventListener("click", () => {
  navlinks.classList.toggle("show-menu");
});

// --------------------slider-rotation----------------------------
let slides = document.querySelectorAll(".slide");
let buttons = document.querySelectorAll(".circle-button");
let currentSlide = 0;

// Initialize first slide
slides[currentSlide].classList.add("active");

// Manual button click
buttons.forEach((button, index) => {
  button.addEventListener("click", () => {
    changeSlide(index);
  });
});

// Change slide function with animation
function changeSlide(index) {
  slides[currentSlide].classList.remove("active");
  slides[currentSlide].style.display = "none";

  slides[index].style.display = "flex";
  // Allow display to apply before animating
  setTimeout(() => {
    slides[index].classList.add("active");
  }, 20);
  currentSlide = index;
}

// Auto slide every 4 seconds
function autoSlide() {
  setTimeout(() => {
    let next = (currentSlide + 1) % slides.length;
    changeSlide(next);
    autoSlide();
  }, 6000);
}

autoSlide();

// -------------------------slider-animation=----------------------
let h1=document.querySelector(".slider-heading");
window.addEventListener("load", function() {
  h1.style.transform = "translatey(160px)";
  h1.style.transition = "transform 0.9s";
});

let p=document.querySelector(".p");
window.addEventListener("load",function(){
  p.style.transform="translate(0px)";
  p.style.transition = "transform 0.9s";
});

let image=document.querySelector(".image");
window.addEventListener("load",function(){
  image.style.transform="translate(20px)";
  image.style.transition = "transform .8s";
});
// --------------------------welcome animation for h1-------------------------------
let welcome_h1=document.querySelector("#welcome-h1");
window.addEventListener("scroll",function(){
  welcome_h1.style.transform="translateY(-35px)";
  welcome_h1.style.transition = "transform 1.8s";
});

window.addEventListener("scroll", function () {
  // Animate welcome-text1 immediately
  let welcome_texts1 = document.querySelectorAll("#welcome-text1");
  welcome_texts1.forEach(el => {
    el.style.transform = "translateX(0px)";
    el.style.transition = "transform 1.2s";
  });

  // Animate welcome-text2 after 1 second
  setTimeout(() => {
    let welcome_texts2 = document.querySelectorAll("#welcome-text2");
    welcome_texts2.forEach(el => {
      el.style.transform = "translateX(0px)";
      el.style.transition = "transform 1.2s";
    });
  }, 200);

  // Animate welcome-text3 after 2 seconds
  setTimeout(() => {
    let welcome_texts3 = document.querySelectorAll("#welcome-text3");
    welcome_texts3.forEach(el => {
      el.style.transform = "translateX(0px)";
      el.style.transition = "transform 1.2s";
    });   
  }, 350);
});

// -------------------feauter-box-----------------------------

window.addEventListener("scroll", () => {
  let triggerPoint = window.innerHeight - 20; // how close to bottom before triggering
  let infobox1 = document.getElementById("info-box1");
  let infobox2 = document.getElementById("info-box2");
  let infobox3 = document.getElementById("info-box3");
  let infobox4 = document.getElementById("info-box4");

  let boxTop = infobox1.getBoundingClientRect().top;

  if (boxTop < triggerPoint) {
    infobox1.style.transform = "translateY(0px)";
    infobox1.style.opacity = "1";

    setTimeout(() => {
      infobox2.style.transform = "translateY(0px)";
      infobox2.style.opacity = "1";
    }, 100);

    setTimeout(() => {
      infobox3.style.transform = "translateY(0px)";
      infobox3.style.opacity = "1";
    }, 200);

    setTimeout(() => {
      infobox4.style.transform = "translateY(0px)";
      infobox4.style.opacity = "1";
    }, 300);
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

let mission_and_vision_h1_1 = document.querySelector(".mission-and-vision-h1-1");
window.addEventListener("scroll", function () {
  mission_and_vision_h1_1.style.transform = "scale(1.2)";
  mission_and_vision_h1_1.style.transition = "transform 1.34s";
  mission_and_vision_h1_1.style.opacity=1;
});

let mission_and_vision_h1_2 = document.querySelector(".mission-and-vision-h1-2");
window.addEventListener("scroll", function () {
  mission_and_vision_h1_2.style.transform = "scale(1.2)";
  mission_and_vision_h1_2.style.transition = "transform 1.34s";
  mission_and_vision_h1_2.style.opacity=1;
});
let elements = document.querySelectorAll(".vision-text-1, .vision-text-2, .vision-text-3, .mission-text");
let triggerPoint = window.innerHeight - 30; // almost at bottom

window.addEventListener("scroll", () => {
  elements.forEach(el => {
    let position = el.getBoundingClientRect().top;
    if (position < triggerPoint) {
      el.style.transform = "translateX(0px)";
      el.style.transition = "transform 1s ease";
    }
  });
});