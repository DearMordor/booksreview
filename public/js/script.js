function checkRegistration() {
    return verifyName() && verifyEmail() && verifyPassword();
}

function checkReviewForm() {
    return verifyName() && checkReviewCharLen();
}

function checkLoginForm() {
    return verifyEmail() && verifyLoginPassword();
}

function verifyPassword() {

    let pw = document.getElementById("password").value;
    let conf_pw = document.getElementById("confirm-password").value;
    let ret = false;

    if(pw.length < 8) {
        document.getElementById("pass-control").innerHTML = "Password length must be atleast 8 characters";
        document.getElementById("pass-control").focus();
        return ret;
    }

    if(pw.length > 15) {
        document.getElementById("pass-control").innerHTML = "Password length must not exceed 15 characters";
        document.getElementById("pass-control").focus();
        return ret;
    } 
    clearErrorMessage("pass-control");
    if(conf_pw == pw) {
        ret = true;
        document.getElementById("pass-confirm-control").focus();
    } else {
        document.getElementById("pass-confirm-control").innerHTML = "Passwords are not equal!";
        return ret;
    }

    clearErrorMessage("pass-confirm-control");
    return ret;
}

function verifyEmail() {
    
    const regexp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    let email = document.getElementById("email").value;
    let ret = false;
    if (!email.match(regexp)) {
    // on error, we get into the condition
        document.getElementById("pass-email-control").innerHTML = "You have entered an invalid email address!";
        document.getElementById("pass-email-control").focus();
    } else {
        ret = true;
        clearErrorMessage("pass-email-control");
    }

    return ret;

}

function verifyName() {
    const hasNumber = /\d/;
    const specialChars = /^\s*([A-Za-z]{1,}([\.,] |[-']| ))+[A-Za-z]+\.?\s*$/;

    let name = document.getElementById("name").value;
    let ret = false;

    if (name === "") {
        document.getElementById("pass-name-control").innerHTML = "Name should not be empty!"; 
        document.getElementById("pass-name-control").focus();
    } else if (hasNumber.test(name)) {
        document.getElementById("pass-name-control").innerHTML = "Name should not containe numbers!"; 
        document.getElementById("pass-name-control").focus();
    } else if (!specialChars.test(name)) {
        document.getElementById("pass-name-control").innerHTML = "Name should be in `Name Surname` format"; 
        document.getElementById("pass-name-control").focus();
    } else {
        ret = true;
        clearErrorMessage("pass-name-control");
    }

    return ret;
}

function verifyLoginPassword() {

    let pw = document.getElementById("password").value;
    let ret = false;

    if(pw.length < 8) {
        document.getElementById("pass-control").innerHTML = "Password length must be atleast 8 characters";
        document.getElementById("pass-control").focus();
        return ret;
    }

    if(pw.length > 15) {
        document.getElementById("pass-control").innerHTML = "Password length must not exceed 15 characters";
        document.getElementById("pass-control").focus();
        return ret;
    }
    ret = true;
    clearErrorMessage("pass-control");

    return ret;

}


function clearErrorMessage(id) {
    document.getElementById(id).innerHTML = "";
}


function checkReviewCharLen() {
    let textarea = document.querySelector("textarea");
    let maxlength = textarea.getAttribute("maxlength");
    let currentLength = textarea.value.length;
    let ret = true;

    if( currentLength >= maxlength ){
        console.log("You have reached the maximum number of characters.");
        document.getElementById("pass-review-control").innerHTML = "Review should be less than 700 chars";
        document.getElementById("pass-review-control").focus();
        ret = false;
    }

    return ret;
}
