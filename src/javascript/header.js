$(document).ready(function() {
  if(window.location.href.indexOf('#signup') != -1) {
    $('#sign-in-modal').modal('show');
    console.log($('#sign-up'));
    $('#sign-up-tab').tab('show');
  }

  if(window.location.href.indexOf('#signin') != -1) {
    $('#sign-in-modal').modal('show');
  }
});

function validateForm(){
    let password = $("#password").val();
    let repeatPassword = $("#repeat-password").val();

    if(password.length < 8){
        $("#register-failed").text("Password needs to be greater or equal to 8 characters");
        $("#register-failed").show();
        return false;
    }

    if(repeatPassword !== password){
        $("#register-failed").text("Passwords do not match");
        $("#register-failed").show();
        return false;
    }

    return true;
}