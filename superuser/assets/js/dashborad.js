const user_list_box = document.querySelector('.order .user_list');
const search_box = document.querySelector('.search_box');
const search_input = document.querySelector('.search_input');
const search_btn = document.querySelector('.search_btn');
const close_btn = document.querySelector('.close_btn');
const title = document.querySelector('.content main .table-data .head h3');

const total_driver = document.querySelector('.total_driver');
const reject_driver = document.querySelector('.reject_driver');
const active_driver = document.querySelector('.active_driver');
const pending_driver = document.querySelector('.pending_driver');
const box_info = document.querySelectorAll('.box-info li');

const recent_user_url = 'api/recentuser.php';
const serach_driver_url = 'api/search.php';
// console.log(user_list_box);

const recent_user = () => {
  fetch(recent_user_url, {
    method: 'GET',
    headers: {
      'Content-type': 'application/json; charset=UTF-8',
    },
  })
    .then(response => response.json())
    .then(json => {
      console.log(json);
      let userData = json.userList;
      if (json.status_code == 200) {
        user_list_box.innerHTML = userData.map(val => {
          const { firstname, created_at, active_status, photo } = val;
          const parseDate = new Date(created_at);
          const formattedDate = new Intl.DateTimeFormat('en-US', {
            year: 'numeric',
            month: 'numeric',
            day: 'numeric'
          }).format(parseDate);
          const profile = photo ? `<img src="../${photo}" alt="" />` : '<img src="assets/img/user.png" alt="" />';
          let status = (active_status == "active") ? "active" : "pending";
          let status_class = (active_status == "active") ? "bg-label-success" : "bg-label-warning";
          return `
            <tr>
                <td>
                    <div class="plus_icon">
                        <i class='bx bxs-plus-circle'></i>
                    </div>
                </td>
                <td>
                   ${profile}
                    <p>${firstname}</p>
                </td>
                <td>${formattedDate}</td>
                <td><span class="status ${status_class}">${status}</span></td>
            </tr>`;
        }).join('');

      }
      else {
        console.log(json.message);
      }

      total_driver.innerHTML = json.totaldriver;
      pending_driver.innerHTML = json.pending;
      active_driver.innerHTML = json.active;
      reject_driver.innerHTML = json.reject;

    })
}

recent_user();

const driver_search = (driver_name) => {
  fetch(serach_driver_url, {
    method: 'POST',
    body: JSON.stringify({
      drivername: driver_name,
    }),
    headers: {
      'Content-type': 'application/json; charset=UTF-8',
    },
  })
    .then(response => response.json())
    .then(json => {
      console.log(json);
      if (json.status_code == 200) {
        const driver_data = json.userData;
        user_list_box.innerHTML = driver_data.map(val => {
          const { firstname, created_at, active_status, photo } = val;
          const parseDate = new Date(created_at);
          const formattedDate = new Intl.DateTimeFormat('en-US', {
            year: 'numeric',
            month: 'numeric',
            day: 'numeric'
          }).format(parseDate);
          const profile = photo ? `<img src="../${photo}" alt="" />` : '<img src="assets/img/user.png" alt="" />';
          let status = (active_status == "active") ? "active" : "pending";
          let status_class = (active_status == "active") ? "bg-label-success" : "bg-label-warning";

          return `
            <tr>
                <td>
                    <div class="plus_icon">
                        <i class='bx bxs-plus-circle'></i>
                    </div>
                </td>
                <td>
                  ${profile}
                    <p>${firstname}</p>
                </td>
                <td>${formattedDate}</td>
                <td><span class="status ${status_class}">${status}</span></td>
            </tr>`;
        }).join('');
      }
      else {
        console.log(json.message);
      }

    })
}


search_btn.addEventListener('click', () => {
  if (search_box.classList.contains('active')) {
    driver_search(search_input.value);
  }
  else {
    title.classList.add('active');
    search_box.classList.add('active');
    search_input.focus();
  }
})

search_input.addEventListener('input', () => {
  driver_search(search_input.value);
})

close_btn.addEventListener('click', () => {
  search_box.classList.remove('active');
  title.classList.remove('active');
  search_input.value = '';
})

box_info.forEach(element => {
  // console.log(element);
  element.addEventListener('click', () => {
    const info_type = element.querySelector('p').textContent;
    console.log(info_type);
    window.location.href = "categorizedriver.php" + `?info_type=${info_type}`;
  })
})
