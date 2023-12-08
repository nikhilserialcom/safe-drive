const user_list_box = document.querySelector('.user_list ');
const user_modal = document.querySelector('.user_modal');
const user_title = document.querySelector('.user_modal .user_btn h3');
const user_data_show = document.querySelector('.user_modal .user_data');
const search_box = document.querySelector('.search_box');
const search_input = document.querySelector('.search_input');
const search_btn = document.querySelector('.search_btn');
const close_btn = document.querySelector('.close_btn');
// const view_mode = document.querySelector('.view_mode');

const info_document_div = document.querySelectorAll('.info_document');
const total_driver = document.querySelector('.total_driver');

var totalDriver;

const recent_user_url = 'api/recentuser.php';
const alldriverdata_url = 'api/alldriverdata.php';
const user_dataUrl = 'api/driverdata.php';
const serach_driver_url = 'api/search.php';
// console.log(user_list_box);




const user_data = (user_id) => {
    fetch(user_dataUrl, {
        method: 'POST',
        body: JSON.stringify({
            userId: user_id
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            let driverData = json.driverData;

            if (json.status_code == 200) {
                // console.log(user_data_show);
                user_title.textContent = `detials for ${driverData.firstname} ${driverData.lastname}`;
                const profile = driverData.photo ? `<img src="../${driverData.photo}" alt="" />` : '<img src="assets/img/user.png" alt="" />';
                user_data_show.innerHTML =
                    `
                    <div class="user_pic">
                        ${profile}
                    </div>
                    <input type="text" class="userId" value="${driverData.driverId}" hidden>
                    <div class="user_name d_flex flex_direction">
                        <span>${driverData.firstname} ${driverData.lastname}</span>
                        <span>${driverData.email}</span>
                    </div>
                    <div class="modal_btn d_flex">
                        <button class="bg-label-success"><i class='bx bxs-edit'></i></button>
                        <button class="bg-label-danger "><i class='bx bxs-trash-alt'></i></button>
                        <button class="view_btn"><i class='bx bxs-show'></i></button>
                    </div>
                    `;
            }
            const view_btn = document.querySelectorAll('.view_btn');
            const driver_id = document.querySelector('.userId');

            view_btn.forEach(element => {
                element.addEventListener('click', () => {
                    window.location.href = 'showuser.php' + `?id=${driver_id.value}`;
                })
            })
        })
}
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
            totalDriver = json.totaldriver;
            if (json.status_code == 200) {
                user_list_box.innerHTML = userData.map(val => {
                    const { driverId, firstname, created_at, driverstatus, photo } = val;
                    const parseDate = new Date(created_at);
                    const formattedDate = new Intl.DateTimeFormat('en-US', {
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric'
                    }).format(parseDate);
                    const profile = photo ? `<img src="../${photo}" alt="" />` : '<img src="assets/img/user.png" alt="" />';
                    let status = (driverstatus == "online") ? "active" : "pending";
                    let status_class = (driverstatus == "online") ? "bg-label-success" : "bg-label-warning";
                    return `
                        <tr>
                            <td>
                                <div class="plus_icon" id="${driverId}">
                                    <i class='bx bxs-plus-circle'></i>
                                </div>
                            </td>
                            <td>
                                ${profile}
                                <p>${firstname}</p>
                            </td>
                            <td>${formattedDate}</td>
                            <td><span class="status ${status_class}">${status}</span></td>
                            <td>
                                <button class="bg-label-success"><i class='bx bxs-edit'></i></button>
                                <button class="bg-label-danger "><i class='bx bxs-trash-alt'></i></button>
                                <button class="view_btn" id="${driverId}"><i class='bx bxs-show'></i></button>
                            </td>
                        </tr>`;
                }).join('');

            }

            const view_btn = document.querySelectorAll('.view_btn');
            const plus_icon = document.querySelectorAll('.plus_icon');
            plus_icon.forEach(element => {
                element.addEventListener('click', () => {
                    user_modal.style.display = 'block';
                    // console.log(element.id);
                    user_data(element.id);
                })
            })

            view_btn.forEach(element => {
                element.addEventListener('click', () => {
                    window.location.href = 'showuser.php' + `?id=${element.id}`;
                    // console.log(element.id);
                })
            })
            const close_btn = document.querySelector('.close');

            close_btn.addEventListener('click', () => {
                user_modal.style.display = 'none';
            })

            total_driver.innerHTML = totalDriver;

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
                    const { driverId,firstname, created_at, driverstatus, photo } = val;
                    const parseDate = new Date(created_at);
                    const formattedDate = new Intl.DateTimeFormat('en-US', {
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric'
                    }).format(parseDate);
                    const profile = photo ? `<img src="../${photo}" alt="" />` : '<img src="assets/img/profile.png" alt="" />';
                    let status = (driverstatus == "online") ? "active" : "pending";
                    let status_class = (driverstatus == "online") ? "bg-label-success" : "bg-label-warning";

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
                    <td>
                        <button class="bg-label-success"><i class='bx bxs-edit'></i></button>
                        <button class="bg-label-danger "><i class='bx bxs-trash-alt'></i></button>
                        <button class="view_btn" id="${driverId}"><i class='bx bxs-show'></i></button>
                    </td>
                </tr>`;
                }).join('');
            }
            else {
                console.log(json.message);
            }

            const view_btn = document.querySelectorAll('.view_btn');
            const plus_icon = document.querySelectorAll('.plus_icon');
            plus_icon.forEach(element => {
                element.addEventListener('click', () => {
                    user_modal.style.display = 'block';
                    // console.log(element.id);
                    user_data(element.id);
                })
            })

            view_btn.forEach(element => {
                element.addEventListener('click', () => {
                    window.location.href = 'showuser.php' + `?id=${element.id}`;
                    // console.log(element.id);
                })
            })
            const close_btn = document.querySelector('.close');

            close_btn.addEventListener('click', () => {
                user_modal.style.display = 'none';
            })

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

const plus_icon = document.querySelectorAll('.plus_icon');

window.addEventListener('click', (event) => {
    // console.log(event.target);
    if (event.target == user_modal) {
        user_modal.style.display = "none";
    }
});