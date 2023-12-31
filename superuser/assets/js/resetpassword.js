const show_pass_btn = document.querySelectorAll('.show_pass');
const password_input = document.querySelector('.pass');
const c_password_input = document.querySelector('.c_pass');
const change_btn = document.querySelector('.change_btn');
const email_box = document.querySelector('.email');
email_box.textContent = `for ${localStorage.getItem('email')}`;

const resetpassword_url = 'api/resetpass.php';

const resetpassword = (reset_token,user_pass) => {
    fetch(resetpassword_url, {
        method: 'POST',
        body: JSON.stringify({
            user_email: reset_token,
            password: user_pass
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            if(json.status_code == "200")
            {
                window.location.href = "index.php";
            }
            else{
                console.log(json.message);
            }
        })
}

change_btn.addEventListener('click', () => {
    if(password_input.value == c_password_input.value)
    {
        const new_pass = password_input.value; 
        resetpassword(localStorage.getItem('email'),new_pass);
    }
    else
    {
        console.log('password not match');
    }
   
})

show_pass_btn.forEach(element => {
    element.addEventListener('click', () => {
        const icon_btn = element.querySelector('.bx');
        const input = element.previousElementSibling;
        if (input.type === "password") {
            input.type = "text";
            icon_btn.classList.add('bxs-show');
        } else {
            input.type = "password";
            icon_btn.classList.remove('bxs-show');
        }

    })
});