const log_btn = document.querySelector('.form .login_btn');
const user_email = document.querySelector('.input_box .email');
const user_pass = document.querySelector('.input_box .pass');
const alert_msg = document.querySelector('.alert_msg');
const show_pass = document.querySelector('.show_pass');

const loginUrl = 'api/login.php';

show_pass.addEventListener('click', () => {
    const icon_btn = show_pass.querySelector('.bx');
    const input = show_pass.previousElementSibling;
    if (input.type === "password") {
        input.type = "text";
        icon_btn.classList.add('bxs-show');
    } else {
        input.type = "password";
        icon_btn.classList.remove('bxs-show');
    }
})

const userLogin = (user_email, user_pass) => {
    fetch(loginUrl, {
        method: 'POST',
        body: JSON.stringify({
            email: user_email,
            password: user_pass,
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            if (json.status_code == 200) {
                window.location.href = 'dashborad.php';
            }
            else {
                alert_msg.classList.add('show');
                alert_msg.classList.add('alert');
                alert_msg.classList.add('alert-danger');
                alert_msg.textContent = json.message;
                setTimeout(() => {
                    alert_msg.style.display = 'none';
                    alert_msg.classList.remove('show');

                }, 3000)
            }
        })
}

log_btn.addEventListener('click', () => {
    userLogin(user_email.value, user_pass.value);
})