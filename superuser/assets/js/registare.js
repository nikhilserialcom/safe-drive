const link_btn = document.querySelector('.container .link');
const signup_form = document.querySelector('.forms .signup-form');
const login_form = document.querySelector('.forms .login-form');

const signup_username = document.querySelector('.username');
const signup_fullname = document.querySelector('.full_name');
const signup_email = document.querySelector('.email');
const signup_password = document.querySelector('.pass');
const singup_btn = document.querySelector('.singup_btn');
const alert_msg = document.querySelector('.alert_msg');
const registerUrl = 'api/register.php';


const userRegister = (user_name, full_name, user_email, user_pass) => {
  fetch(registerUrl, {
    method: 'POST',
    body: JSON.stringify({
      username: user_name,
      fullName: full_name,
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
        window.location.href = 'index.php';
        alert_msg.classList.add('show');
        alert_msg.classList.add('alert');
        alert_msg.classList.add('alert-success');
        alert_msg.textContent = json.message;

        setTimeout(() => {
          alert_msg.style.display = 'none';
          alert_msg.classList.remove('show');
        },3000)
      }
      else {
        // console.log(json.message);
        alert_msg.classList.add('show');
        alert_msg.classList.add('alert');
        alert_msg.classList.add('alert-danger');
        alert_msg.textContent = json.message;
        setTimeout(() => {
          alert_msg.style.display = 'none';
          alert_msg.classList.remove('show');

        },3000)
      }
    })
}

const setError = (element, message) => {
  const inputControl = element.parentElement;
  const errorDisplay = inputControl.querySelector('.error');

  errorDisplay.style.display = 'block';
  errorDisplay.innerText = message;
  inputControl.classList.remove('success');
  inputControl.classList.add('error');
}

const setSuccess = (element) => {
  const inputControl = element.parentElement;
  const errorDisplay = inputControl.querySelector('.error');

  errorDisplay.style.display = 'none';
  errorDisplay.innerText = '';
  inputControl.classList.remove('error');
  inputControl.classList.add('success');
}

const isValidEmail = email => {
  const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

const validateInputs = () => {
  const usernameInput = signup_username.value.trim();
  const fullNameInput = signup_fullname.value.trim();
  const emailInput = signup_email.value.trim();
  const passInput = signup_password.value.trim();

  var final_status = false;
  var username_status;
  if (usernameInput === '') {
    setError(signup_username, 'Username is required');
    username_status = false;
  }
  else {
    setSuccess(signup_username);
    username_status = true;
  }

  var fullname_status;
  if (fullNameInput === '') {
    setError(signup_fullname, 'full name is required');
    fullname_status = false;
  }
  else {
    setSuccess(signup_fullname);
    fullname_status = true;
  }

  var email_status;
  if (emailInput === '') {
    setError(signup_email, 'email is required');
    email_status = false;
  }
  else if(!isValidEmail(emailInput)){
    setError(signup_email, 'Provide a valid email address');
    email_status = false;
  }
  else {
    setSuccess(signup_email);
    email_status = true;
  }

  var pass_status;
  if (passInput === '') {
    setError(signup_password, 'password is required');
    pass_status = false;
  }
  else if (passInput.length < 6) {
    setError(signup_password, 'Password must be at least 6 character');
    pass_status = false;
  }
  else {
    setSuccess(signup_password);
    pass_status = true;
  }

  if (username_status == true && fullname_status == true && email_status == true && pass_status == true) {
    final_status = true;
  }
  else {
    final_status = false;
  }

  return final_status;
}

singup_btn.addEventListener('click', (e) => {
  e.preventDefault();
  const validate = validateInputs();
  if (validate == true) {
    userRegister(signup_username.value, signup_fullname.value, signup_email.value, signup_password.value);
  }
})
