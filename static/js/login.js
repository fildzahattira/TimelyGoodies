const input_username = document.querySelector("input[name='username_input']")
const input_password = document.querySelector("input[name='password_input']")

const error_msg = document.querySelector("label[name='error_message']")

const submit_button = document.querySelector("button[name='submit_button']")
submit_button.addEventListener("click", async () => {
  const data = {
    "username": input_username.value,
    "password": input_password.value
  };

  let response = await fetch_api2("user", "login", data);
  if(response["ok"] == "true"){
    window.location.href = base_url;
  }
  else{
    errorMessageElement.innerHTML = parseErrorToMessage(response["error"]);
  }
});