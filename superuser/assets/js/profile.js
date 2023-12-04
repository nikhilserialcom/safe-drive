const username_input = document.querySelector('.username');
const full_name_input = document.querySelector('.full_name');
const upload_btn = document.querySelector('.upload_btn');
const profile_image = document.querySelector('.profile_image_content');
const profile_image_input = document.querySelector('.profile_btn .profileImage');
const change_btn = document.querySelector('.change_btn');

profile_image_input.addEventListener('input', () => {
    let profile_file = profile_image_input.files[0];
    let formData = new FormData();

    formData.append('profileImage',profile_file);
    window.uploaededFormData =  formData;
})

upload_btn.addEventListener('click', () => {
    profile_image_input.click();
})

const user_dataUrl = 'api/user_data.php';

const updateProfile_url = 'api/updateprofile.php';

const profile_data = () => {
    fetch(user_dataUrl, {
        method: 'GET',
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            let user = json.userData;
            if (json.status_code == 200) {
                username_input.value = user.username;
                full_name_input.value = user.full_name;
                profile_image.innerHTML = `<img src="assets/${user.profile_img}" alt="">`
            }
        })
}

profile_data();

const updateProfile = (image_data) => {
    fetch(updateProfile_url, {
        method: 'POST',
        body:image_data
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            if(json.status_code == 200)
            {
                profile_data();
            }
        })
}

change_btn.addEventListener('click', () => {
    const profileImg = window.uploaededFormData;

    updateProfile(profileImg)
})