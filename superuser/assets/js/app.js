var Scheme = window.location.protocol;
var hostname = window.location.hostname;
var SchemeAndHttpHost = Scheme + '//' + hostname;

// + ":" + window.location.port

const icon_menu = document.querySelector('.icon-menu');
const profileImg = icon_menu.querySelector('img');
const profile_menu = document.querySelector('.profile-menu');
const logout_btn = document.querySelector('.log_out');

const user_data_url ='api/user_data.php';
const logout_url = 'api/log_out.php';

const active_list = document.querySelector('.head-title .active');
const active_list_element = document.querySelector('.side-menu .active');
const active_list_text = document.querySelectorAll('.side-menu .nav-link .text');
active_list_text.forEach(element => {
      if(element.textContent == active_list.textContent)
      {
         const parentElement = element.parentElement.parentElement;
         active_list_element.classList.remove('active');
         parentElement.classList.add("active");
      }   
})

const toggleProfileMenu = () => {
  if (profile_menu.style.display === 'block') {
      profile_menu.style.display = 'none';
      profile_menu.classList.remove('animate__animated', 'animate__backInDown');
  }
  else {
      profile_menu.style.display = 'block';
      profile_menu.classList.add('animate__animated', 'animate__backInDown');
      profile_menu.style.setProperty('--animate-duration', '1s');
  }
}

icon_menu.addEventListener('click', toggleProfileMenu);

window.addEventListener('click', (event) => {
  if (!icon_menu.contains(event.target)) {
      profile_menu.style.display = 'none';
  }
});

/* Created by Tivotal */

let sideMenu = document.querySelectorAll(".nav-link");
sideMenu.forEach((item) => {
  let li = item.parentElement;

  item.addEventListener("click", () => {
    sideMenu.forEach((link) => {
      link.parentElement.classList.remove("active");
    });
    li.classList.add("active");
  });
});

let menuBar = document.querySelector(".menu-btn");
let sideBar = document.querySelector(".sidebar");
// console.log(sideBar);
menuBar.addEventListener("click", () => {
  sideBar.classList.toggle("hide");
});

// let switchMode = document.getElementById("switch-mode");
// switchMode.addEventListener("change", (e) => {
//   if (e.target.checked) {
//     localStorage.setItem('theme','dark');
//     document.body.classList.add("dark");
//   } else {
//     localStorage.setItem('theme','light');
//     document.body.classList.remove("dark");
//   }
// });

// if(localStorage.getItem('theme') == "dark")
// {
//   document.body.classList.add("dark");
// }
// else
// {
//   document.body.classList.remove("dark");
// }

const body = document.querySelector('body');
const sun = document.querySelector('.sun');
const moon = document.querySelector('.moon');

let dark_mode = () => {
  localStorage.setItem('theme','dark');
  body.classList.add('dark');
  sun.classList.remove('clicked');
  moon.classList.add('clicked');
}

let light_mode = () => {
  localStorage.setItem('theme','light');
  body.classList.remove('dark');
  sun.classList.add('clicked');
  moon.classList.remove('clicked');
}

if(localStorage.getItem('theme') == "dark")
{
  body.classList.add('dark');
  sun.classList.remove('clicked');
  moon.classList.add('clicked');
}
else
{
  body.classList.remove('dark');
  sun.classList.add('clicked');
  moon.classList.remove('clicked');
}


sun.addEventListener('click',light_mode);
moon.addEventListener('click',dark_mode);

let searchFrom = document.querySelector(".content nav form");
let searchBtn = document.querySelector(".search-btn");
let searchIcon = document.querySelector(".search-icon");
searchBtn.addEventListener("click", (e) => {
  if (window.innerWidth < 576) {
    e.preventDefault();
    searchFrom.classList.toggle("show");
    if (searchFrom.classList.contains("show")) {
      searchIcon.classList.replace("fa-search", "fa-times");
    } else {
      searchIcon.classList.replace("fa-times", "fa-search");
    }
  }
});

window.addEventListener("resize", () => {
  if (window.innerWidth > 576) {
    searchIcon.classList.replace("fa-times", "fa-search");
    searchFrom.classList.remove("show");
  }
  if (window.innerWidth < 768) {
    sideBar.classList.add("hide");
  }
});

if (window.innerWidth < 768) {
  sideBar.classList.add("hide");
}



const profile_img_data = () => {
  fetch(user_data_url, {
    method:'GET', 
    headers: {
      'Content-type': 'application/json; charset=UTF-8',
    },
  })
    .then(response => response.json())
    .then(json => {
        // console.log(json);
        let user = json.userData;
        if(json.status_code == 200)
        {
          if(!user.profile_img)
          {
            profileImg.src = SchemeAndHttpHost + 'safe-drive/superuser/' + 'assets/img/user.png';
          }
          else{
            profileImg.src = `${SchemeAndHttpHost}/safe-drive/superuser/assets/` + user.profile_img;
          }
        }
        else{
          window.location.href = 'index.php';
        }
    })
}

profile_img_data();




const logout = () => {
    fetch(logout_url, {
        method: 'POST',
        headers: {
          'Content-type': 'application/json; charset=UTF-8',
        },
      })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            if(json.status_code == 200)
            {
                // console.log(json.message);
                window.location.href = 'index.php';
            }
        })
}

logout_btn.addEventListener('click', () => {
    logout();
})



