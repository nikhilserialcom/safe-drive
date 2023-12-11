const reset_link_btn = document.querySelector('.reset_link');
const email_input = document.querySelector('.email');
const alert_box = document.querySelector('.alert_box');

const forgotpassword_url = 'api/sendmail.php';

const forgotpassword = (email) => {
    fetch(forgotpassword_url, {
        method: 'POST',
        body:JSON.stringify({
            user_email: email
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            const message = json.message == "true" ? "Message has been sent" : "email is not exist";
            if(json.status_code == 200)
            {
                alert_box.style.display = 'block';
                alert_box.classList.remove('alert-danger');
                alert_box.classList.add('alert-success');
                alert_box.innerHTML = `
                    <span>${message}</span>
                `;
            }
            else{
                alert_box.style.display = 'block';
                alert_box.classList.remove('alert-success');
                alert_box.classList.add('alert-danger');
                alert_box.innerHTML = `
                    <span>${message}</span>
                `;
            }
        })
}

reset_link_btn.addEventListener('click', () => {
   forgotpassword(email_input.value);
})