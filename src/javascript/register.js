function validateForm(){
    console.log("entrei");
    let password = $("#password").val();
    let repeat_password = $("#repeat-password").val();

    if(password.length < 8){
        $("#register-failed").text("Password needs to be greater or equal to 8 characters");
        $("#register-failed").show();
        return false;
    }else if($('#register-failed').is(':visible'))
        $("#register-failed").hide();

    if(repeat_password != password){
        $("#register-failed").text("Passwords do not match");
        $("#register-failed").show();
        return false;
    }else if($('#register-failed').is(':visible'))
        $("#register-failed").hide();

    return true;
}