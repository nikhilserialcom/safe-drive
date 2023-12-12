var url = window.location.href;
var urlParams = new URLSearchParams(window.location.search);
var token = urlParams.get('token');

const otp_input = document.querySelectorAll('.otp');
const inputField = document.querySelector('.otp_input');
const continue_btn = document.querySelector('.continue_btn');
const email_box = document.querySelector('.email');
const alert_box = document.querySelector('.alert_box');

email_box.textContent = `for ${localStorage.getItem('email')}`;

const verifyotpUrl = 'api/verify_otp.php';

let inputCount = 0,
    finalCount = "";

const updateInputConfig = (element, disabledStatus) => {
    element.disabled = disabledStatus;
    if(!disabledStatus) {
        element.focus();
    } else {
        element.blur();
    }
}

otp_input.forEach((element) => {
    element.addEventListener("keyup", (e) => {
        e.target.value = e.target.value.replace(/[^0-9]/g, "");
        let { value } = e.target;

        if(value.length == 1) {
            updateInputConfig(e.target, true);
            if (inputCount <= 3 && e.key != "Backspace") {
                finalCount += value;
                if(inputCount < 3) {
                    updateInputConfig(e.target.nextElementSibling, false);
                }
            }
            inputCount += 1;
        } else if (value.length == 0 && e.key == "Backspace") {
            finalInput = finalInput.substring(0, finalInput.length - 1);
            if (inputCount == 0) {
                updateInputConfig(e.target, false);
                return false;
            }
            updateInputConfig(e.target, true);
            e.target.previousElementSibling.value = "";
            updateInputConfig(e.target.previousElementSibling, false);
            inputCount -= 1;
        } else if (value.length > 1) {
            e.target.value = value.split("")[0];
        }
        continue_btn.classList.add("hide");
    });

});

window.addEventListener("keyup", (e) => {
    if (inputCount > 3) {
        continue_btn.classList.remove("hide");
        continue_btn.classList.add("show");
        if (e.key == "Backspace") {
            finalInput = finalInput.substring(0, finalInput.length - 1);
            updateInputConfig(inputField.lastElementChild, false);
            inputField.lastElementChild.value = "";
            inputCount -= 1;
        }
    }
});

const validateOTP = (input) => {
    let inputElement = input; 
    let userInput = "";

    inputElement.forEach((input) => {
        userInput += input.value;
    });

    return userInput;
    // console.log(userInput);
};

const startInput = () => {
    inputCount = 0;
    finalInput = "";
    otp_input.forEach((element) => {
        element.value = "";
    });
    updateInputConfig(inputField.firstElementChild, false);
};

window.onload = startInput();

// timer

const TIME_LIMIT = 30;

let timeLeft = TIME_LIMIT;
let timerInterval;

timerInterval = setInterval(() => {

    const seconds = timeLeft % 60;

    let formattedTime = `${Math.floor(timeLeft / 60)
        .toString()
        .padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

    let timer = document.getElementById("timer");
    timer.innerHTML = `${formattedTime}`;

    //document.getElementsByClassName("otp_resend").addEventListener("click", otp_resend);

    // let resend = document.getElementById("resend_link");

    timeLeft--;

    if (timeLeft < 0) {
        timer.innerHTML = `00:00`;
    }
}, 1000);

const verify_otp = (verify_code,email) => {
    fetch(verifyotpUrl, {
        method: 'POST',
        body: JSON.stringify({
            otp: verify_code,
            user_email: email,
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            const message = json.message == "true" ? "otp is valid" : "invalid otp";
            if(json.status_code == "200")
            {
                alert_box.style.display = 'block';
                alert_box.classList.remove('alert-danger');
                alert_box.classList.add('alert-success');
                alert_box.innerHTML = `
                    <span>${message}</span>
                `;
                window.location.href = 'resetpassword.php';
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

continue_btn.addEventListener('click', () => {
    const otp = validateOTP(otp_input);
    const user_email = localStorage.getItem('email');
   verify_otp(otp,user_email);
})
