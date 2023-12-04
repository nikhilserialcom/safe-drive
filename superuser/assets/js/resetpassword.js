const show_pass_btn = document.querySelectorAll('.show_pass');
const password_input = document.querySelector('.pass');

show_pass_btn.forEach(element => {
    element.addEventListener('click', () => {
        const icon_btn = element.querySelector('.bx');
        if(password_input.type == "password")
        {
            password_input.type = "text";
            icon_btn.classList.add('bxs-show');
        }
        else{
            password_input.type = "password";
            icon_btn.classList.remove('bxs-show');

        }
    })
});