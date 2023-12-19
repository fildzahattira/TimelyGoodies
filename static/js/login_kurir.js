const input_username = document.querySelector("input[name='username_input']")
const input_password = document.querySelector("input[name='password_input']")

const error_msg = document.querySelector("label[name='error_message']")

const submit_button = document.querySelector("button[name='submit_button']")
submit_button.addEventListener("click", async () => {
  const data = {
    "username": input_username.value,
    "password": input_password.value
  };

  let response = await fetch_api2("kurir", "login", data);
  if(response["ok"] == "true"){
    window.location.href = base_url;
  }
  else{
    switch(response["error"]){
      case USER_ERROR_ALREADY_LOGGED_IN:{
        error_msg.innerHTML = "User sudah login.";
      } break;

      case USER_ERROR_USER_NOT_FOUND:{
        error_msg.innerHTML = "User tidak ditemukan.";
      } break;

      case USER_ERROR_PASSWORD_WRONG:{
        error_msg.innerHTML = "Password salah.";
      } break;

      case SERVER_ERROR:{
        error_msg.innerHTML = "Kesalahan pada server.";
        console.log("Server error: ", response["error_message"]);
      } break;
    }
  }
});