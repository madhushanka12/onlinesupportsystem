AOS.init();

var swiper = new Swiper(".mySwiper3", {
    slidesPerView: 5,
    spaceBetween: 20,
    autoplay: true,
    autoplay: {
        delay: 2000,
    },
    navigation: {
        nextEl: ".sp3",
        prevEl: ".sn3",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        1440: {
            slidesPerView: 5,
            spaceBetween: 20,
        },
    },
    keyboard: true,
    loop: true,
});

var swiper = new Swiper(".mySwiper2", {
    slidesPerView: 5,
    autoplay: true,
    autoplay: {
        delay: 3000,
    },
    spaceBetween: 20,
    navigation: {
        nextEl: ".sp2",
        prevEl: ".sn2",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        1440: {
            slidesPerView: 5,
            spaceBetween: 20,
        },
    },
    keyboard: true,
    loop: true,
});

var swiper = new Swiper(".mySwiper4", {
    slidesPerView: 2,
    spaceBetween: 20,
    a11y: false,
    navigation: {
        nextEl: ".sp4",
        prevEl: ".sn4",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        1440: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
    },
    keyboard: true,
    loop: true,
});

var swiper = new Swiper(".mySwiper1", {
    slidesPerView: 2,
    spaceBetween: 30,
    navigation: {
        nextEl: ".next",
        prevEl: ".prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        1440: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
    },
    keyboard: true,
    loop: true,
});

var swiper = new Swiper(".mySwiper", {
    slidesPerView: 3,
    spaceBetween: 30,
    zoom: true,
    navigation: {
        nextEl: ".sp1",
        prevEl: ".sn1",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        1440: {
            slidesPerView: 3,
            spaceBetween: 50,
        },
    },
    keyboard: true,
    loop: true,
});

let swiper5 = new Swiper(".mySwiper5", {
    slidesPerView: 4,
    spaceBetween: 40,
    navigation: {
        nextEl: ".sp5",
        prevEl: ".sn5",
    },
    a11y: false,
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        1440: {
            slidesPerView: 4,
            spaceBetween: 40,
        },
    },
    keyboard: false,
    loop: true,
});

var swiper = new Swiper(".mySwiper6", {
    slidesPerView: 3,
    spaceBetween: 20,
    autoplay: true,
    navigation: {
        nextEl: ".sp6",
        prevEl: ".sn6",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        600: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 50,
        },
        1440: {
            slidesPerView: 3,
            spaceBetween: 80,
        },
    },
    keyboard: true,
    loop: true,
});

var swiper = new Swiper(".mySwiper7", {
    slidesPerView: 3,
    spaceBetween: 20,
    autoplay: true,

    navigation: {
        nextEl: ".sp7",
        prevEl: ".sn7",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 20,
        },

        600: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 50,
        },
        1440: {
            slidesPerView: 3,
            spaceBetween: 80,
        },
    },
    keyboard: true,
    loop: true,
});

const videos = document.querySelectorAll(".movies");

videos.forEach((video) => {
    video.addEventListener("mouseover", () => {
        video.play();
    });

    video.addEventListener("mouseleave", () => {
        video.pause();
        video.currentTime = 0;
    });

    // Prevent Swiper controls from being triggered when clicking on video controls
    video.addEventListener("click", (event) => {
        event.stopPropagation(); // Stop event propagation
    });
});

document.addEventListener("DOMContentLoaded", function () {
    var targetElement = document.querySelector(".navbar-brand"); // Replace '.your-target-element' with your actual target element selector
    var scrollThreshold = 2; // Scroll threshold in pixels

    function handleScroll() {
        if (window.scrollY >= scrollThreshold) {
            targetElement.classList.add("hide-on-scroll");
        } else {
            targetElement.classList.remove("hide-on-scroll");
        }
    }

    window.addEventListener("scroll", handleScroll);
});

document.addEventListener("DOMContentLoaded", function () {
    var headerWrapper = document.querySelector(".header-wrapper");

    window.addEventListener("scroll", function () {
        if (window.scrollY > 0) {
            headerWrapper.classList.add("sticky");
        } else {
            headerWrapper.classList.remove("sticky");
        }
    });
});

//nav bar color change
window.addEventListener("scroll", function () {
    var bgBlack = document.querySelector(".bg-blac");
    var scrollThreshold = 2; // Scroll threshold in pixels
    // var scrollPosition = window.scrollY;
    var windowHeight = window.innerHeight;

    // Change the color based on the scroll position
    if (window.scrollY > scrollThreshold) {
        // For example, change color halfway down the window
        bgBlack.style.backgroundColor = "#000000"; // Change the color when scrolling
    } else {
        bgBlack.style.background =
            "linear-gradient(0deg, rgba(87, 87, 87, 0.00) 0%, rgba(0, 0, 0, 0.70) 100%)";
        // Revert back to the original linear gradient
    }
});

//dropdown color change
// Check if the window width is greater than 990px before adding the scroll event listener
if (window.innerWidth > 990) {
    window.addEventListener("scroll", function () {
        var bgBlack = document.querySelector(".dropdown-content");
        var scrollThreshold = 2; // Scroll threshold in pixels

        // Change the color based on the scroll position
        if (window.scrollY > scrollThreshold) {
            // For example, change color halfway down the window
            bgBlack.style.backgroundColor = "#000000"; // Change the color when scrolling
        } else {
            bgBlack.style.backgroundColor = "#d5a373";
            // Revert back to the original color
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    var navigationSection = document.querySelector(".navbar");
    var navigationSectionOffset = navigationSection.offsetTop;

    window.addEventListener("scroll", function () {
        if (window.scrollY > navigationSectionOffset) {
            navigationSection.classList.add("fixed");
        } else {
            navigationSection.classList.remove("fixed");
        }
    });
});

const lightboxEnabled = document.querySelectorAll(".lightbox-enabled");
const lightboxArray = Array.from(lightboxEnabled);
const lastImage = lightboxArray.length - 1;
const lightboxContainer = document.querySelector(".lightbox-container");
const lightboxImage = document.querySelector(".lightbox-image");
const lightboxBtns = document.querySelectorAll(".lightbox-btn");
const lightboxBtnRight = document.querySelector("#right");
const lightboxBtnLeft = document.querySelector("#left");
const close = document.querySelector("#close");
let activeImage;

const showLightBox = () => {
    lightboxContainer.classList.add("active");
};

const hideLightBox = () => {
    lightboxContainer.classList.remove("active");
};

const setActiveImage = (image) => {
    lightboxImage.src = image.dataset.imgsrc;
    activeImage = lightboxArray.indexOf(image);
};

const transitionSlidesLeft = () => {
    lightboxBtnLeft.focus();
    $(".lightbox-image").addClass("slideright");
    setTimeout(function () {
        activeImage === 0
            ? setActiveImage(lightboxArray[lastImage])
            : setActiveImage(lightboxArray[activeImage - 1]);
    }, 250);

    setTimeout(function () {
        $(".lightbox-image").removeClass("slideright");
    }, 500);
};

const transitionSlidesRight = () => {
    lightboxBtnRight.focus();
    $(".lightbox-image").addClass("slideleft");
    setTimeout(function () {
        activeImage === lastImage
            ? setActiveImage(lightboxArray[0])
            : setActiveImage(lightboxArray[activeImage + 1]);
    }, 250);
    setTimeout(function () {
        $(".lightbox-image").removeClass("slideleft");
    }, 500);
};

const transitionSlideHandler = (moveItem) => {
    moveItem.includes("left")
        ? transitionSlidesLeft()
        : transitionSlidesRight();
};

// Event Listeners
lightboxEnabled.forEach((image) => {
    image.addEventListener("click", (e) => {
        showLightBox();
        setActiveImage(image);
    });
});
lightboxContainer.addEventListener("click", () => {
    hideLightBox();
});
close.addEventListener("click", () => {
    hideLightBox();
});
lightboxBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        e.stopPropagation();
        transitionSlideHandler(e.currentTarget.id);
    });
});

lightboxImage.addEventListener("click", (e) => {
    e.stopPropagation();
});
