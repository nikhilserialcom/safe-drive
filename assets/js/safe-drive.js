const inner_nav = document.querySelector('nav .inner-nav ul');
const btn_box = document.querySelector('.btn_box button');


const fa_bars = document.querySelector('.fa-bars');
const fa_xmark = document.querySelector('.fa-xmark');

fa_bars.onclick = () => {
    inner_nav.classList.add('active');
}

fa_xmark.onclick = () => {
    inner_nav.classList.remove('active');
}

btn_box.addEventListener('click',() => {
    window.location.href = 'superuser/index.php';
})

// slider js

// const slider = document.querySelector('.slider');
// const movies_box = document.querySelectorAll('.slider .movie-box');
// const movies_img = document.querySelectorAll('.slider .movie-box img');
// const left = document.querySelector('.left_right_arrow .left');
// const right = document.querySelector('.left_right_arrow .right');

// let currentIndex = 0;
// const sliderInterval = 5000;

// // console.log(left);
// slideshow = (index) => {
//     if (index < 0) {
//         index = movies_box.length - 1;
//     } else if (index >= movies_box.length) {
//         index = 0;
//     }
//     currentIndex = index; // Update the currentIndex
//     updateSlider();
// }

// nextslide = () => {
//     slideshow(currentIndex + 1);
// }

// prevslide = () => {
//     slideshow(currentIndex - 1);
// }

// updateSlider = () => {
//     const translateX = -currentIndex * 100 + "%";
//     slider.style.transform = `translatex(${translateX})`;
//     movies_img.forEach((img, index) => {
//         if (index === currentIndex) {
//             img.style.animation = "fadeOut";
//         } else {
//             img.style.animation = "";
//         }
//     });
//     movies_img[currentIndex].style.animation = `fadeOut`;
// }
// updateSlider();

// setInterval(nextslide, sliderInterval);



// const toggleProfileMenu = () => {
//     if (profile_menu.style.display === 'block') {
//         profile_menu.style.display = 'none';
//         profile_menu.classList.remove('animate__animated', 'animate__backInDown');
//     }
//     else {
//         profile_menu.style.display = 'block';
//         profile_menu.classList.add('animate__animated', 'animate__backInDown');
//         profile_menu.style.setProperty('--animate-duration', '1s');
//     }
// }

// icon_menu.addEventListener('click', toggleProfileMenu);

// document.addEventListener('click', (event) => {
//     if (!icon_menu.contains(event.target)) {
//         profile_menu.style.display = 'none';
//     }
// });