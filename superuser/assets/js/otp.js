const otp_input = document.querySelectorAll('.otp');

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

input.forEach((element) => {
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
