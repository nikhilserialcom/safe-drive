const username_input = document.querySelector('.username');
const full_name_input = document.querySelector('.full_name');
const email_input = document.querySelector('.email');
const password_input = document.querySelector('.pass');
const c_password_input = document.querySelector('.c_pass');
const upload_btn = document.querySelector('.upload_btn');
const profile_image = document.querySelector('.profile_image_content');
const profile_image_input = document.querySelector('.profile_btn .profileImage');
const change_btn = document.querySelector('.change_btn');
const delete_btn = document.querySelector('.delete_btn');
const delete_modal = document.querySelector('.delete_modal');

const cancel_btn = document.querySelector('.cancel_btn');
const done_btn = document.querySelector('.done_btn');
const user_id = document.querySelector('.user_id');
const message_box = document.querySelector('.message_box');

var formData = new FormData();

profile_image_input.addEventListener('input', () => {
    let profile_file = profile_image_input.files.length > 0 ? profile_image_input.files[0] : '';
    formData.append('profileImage',profile_file);
})

upload_btn.addEventListener('click', () => {
    profile_image_input.click();
})

const user_dataUrl = 'api/user_data.php';

const updateProfile_url = 'api/updateprofile.php';

const delete_account_url = 'api/deleteaccount.php';

const profile_data = () => {
    fetch(user_dataUrl, {
        method: 'GET',
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            let user = json.userData;
            if (json.status_code == 200) {
                username_input.value = user.username;
                full_name_input.value = user.full_name;
                email_input.value = user.s_email;
                profile_image.innerHTML = `<img src="assets/${user.profile_img}" alt="">`
                user_id.id = user.id;
            }
            else{
                window.location.href = 'index.php';
            }
        })
}

profile_data();

const updateProfile = (image_data) => {
    console.log(image_data);
    fetch(updateProfile_url, {
        method: 'POST',
        body:image_data
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            if(json.status_code == 200)
            {
                profile_data();
                password_input.value = '';
                c_password_input.value = '';
                message_box.style.display = 'block';
                setTimeout(() => {
                    if (message_box) {
                        message_box.style.display = 'none';
                    }
                }, 3000);
            }
            else{
                window.location.href = 'index.php';
            }
        })
}

change_btn.addEventListener('click', () => {
    const newpassword = (password_input.value == c_password_input.value) ? password_input.value : 'password is not match';
    formData.append('username', username_input.value);
    formData.append('fullName',full_name_input.value);
    formData.append('email',email_input.value);
    formData.append('newpassword',newpassword);
    updateProfile(formData);
})

delete_btn.addEventListener('click', () => {
    delete_modal.style.display = "block";
})

cancel_btn.addEventListener('click', () => {
    delete_modal.style.display = "none";
})

const delete_account = (user_id) => {
    fetch(delete_account_url, {
        method: 'POST',
        body:JSON.stringify({
            user_id : user_id,
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            if(json.status_code == 200)
            {
                delete_modal.style.display = "none";
                window.location.href = 'index.php';
            }
            else{
                console.log(json.message);
            }
        })
}

done_btn.addEventListener('click', () => {
   delete_account(user_id.id);
})

window.addEventListener('click', (event) => {
    // console.log(event.target);
    if (event.target == delete_modal) {
        delete_modal.style.display = "none";
    }
});