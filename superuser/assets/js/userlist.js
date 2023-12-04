const user_list_box = document.querySelector('.user_list ');
const user_modal = document.querySelector('.user_modal');
const user_title = document.querySelector('.user_modal .user_btn h3');
const user_data_show = document.querySelector('.user_modal .user_data');
// const view_mode = document.querySelector('.view_mode');



const recent_user_url = 'api/recentuser.php';

const  user_dataUrl = 'api/driverdata.php'
// console.log(user_list_box);

const user_data = (user_id) => {
    fetch(user_dataUrl, {
        method: 'POST',
        body:JSON.stringify({
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
            if(json.status_code == 200){
                // console.log(user_data_show);
                user_title.textContent = `detials for ${driverData.firstname} ${driverData.lastname}`;
                const profile = driverData.photo ? `<img src="../${driverData.photo}" alt="" />` : '<img src="assets/img/user.png" alt="" />';
                user_data_show.innerHTML = 
                     `
                    <div class="user_pic">
                        ${profile}
                    </div>
                    <div class="user_name d_flex flex_direction">
                        <span>${driverData.firstname} ${driverData.lastname}</span>
                        <span>${driverData.email}</span>
                    </div>
                    `;
            }
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
            // console.log(json);
            let userData = json.userList;
            if (json.status_code == 200) {
                user_list_box.innerHTML = userData.map(val => {
                    const { id,firstname, created_at, photo } = val;
                    const parseDate = new Date(created_at);
                    const formattedDate = new Intl.DateTimeFormat('en-US', {
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric'
                    }).format(parseDate);
                    const profile = photo ? `<img src="../${photo}" alt="" />` : '<img src="assets/img/user.png" alt="" />';
                    // let status = (user_status == "1") ? "driver" : "user";
                    // let status_class = (user_status == "1") ? "complete" : "pending";
                    return `
                        <tr>
                            <td>
                                <div class="plus_icon" id="${id}">
                                    <i class='bx bxs-plus-circle'></i>
                                </div>
                            </td>
                            <td>
                                ${profile}
                                <p>${firstname}</p>
                            </td>
                            <td>${formattedDate}</td>
                            <td><span class="status pending">driver</span></td>
                            <td>
                                <button class="bg-label-success"><i class='bx bxs-edit'></i></button>
                                <button class="bg-label-danger "><i class='bx bxs-trash-alt'></i></button>
                                <button class="view_btn"><i class='bx bxs-show'></i></button>
                            </td>
                        </tr>`;
                }).join('');

            }

            const view_btn = document.querySelectorAll('.view_btn');

            view_btn.forEach(element => {
                element.addEventListener('click', () => {
                    window.location.href = 'showuser.php';
                })
            })

            const plus_icon = document.querySelectorAll('.plus_icon');
           

            plus_icon.forEach(element => {
                element.addEventListener('click', () => {
                    user_modal.style.display = 'block';
                    // console.log(element.id);
                    user_data(element.id);
                })
            })

            const close_btn = document.querySelector('.close');

            close_btn.addEventListener('click', () => {
                user_modal.style.display = 'none';
            })

        })
}

recent_user();

const plus_icon = document.querySelectorAll('.plus_icon');

window.addEventListener('click', (event) => {
    // console.log(event.target);
    if(event.target == user_modal)
    {
       user_modal.style.display = "none";
    }
  });