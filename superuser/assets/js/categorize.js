var url = window.location.href;
var urlParams = new URLSearchParams(window.location.search);
var info_type = urlParams.get('info_type');

var previousPageUrl = document.referrer;

const head_title = document.querySelector('.head-title h1');
const user_list_box = document.querySelector('.order .user_list');
const msg = document.querySelector('.order');
const table = document.querySelector('.order table');

const search_box = document.querySelector('.search_box');
const search_input = document.querySelector('.search_input');
const search_btn = document.querySelector('.search_btn');
const close_btn = document.querySelector('.close_btn');
const back_btn = document.querySelector('.back_btn');

head_title.innerHTML = info_type;

const category_name = (info_type == 'active drivers') ? "active" : (info_type == "reject drivers") ? "reject" : (info_type == "pending drivers") ? "pending" : '';

const categorizedriver_url = 'api/categorizedata.php';
const serach_driver_url = 'api/search.php';

const categorizedriver = (categoryname) => {
    fetch(categorizedriver_url, {
        method: "POST",
        body: JSON.stringify({
            category: categoryname,
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        }
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            let userData = json.final_data;
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
                table.innerHTML = `
                <div class="empty_msg">
                    <p>${json.message}</p>
                </div>
                `;
            }
        })
}

categorizedriver(category_name);

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
        search_box.classList.add('active');
        search_input.focus();
    }
})

search_input.addEventListener('input', () => {
    driver_search(search_input.value);
})

close_btn.addEventListener('click', () => {
    search_box.classList.remove('active');
    search_input.value = '';
})

back_btn.addEventListener('click', () => {
 window.location.href = previousPageUrl;
})