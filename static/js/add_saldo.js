const saldo_input_element = document.querySelector("input[name='input-saldo']");
const max_saldo = parseInt(document.querySelector("input[name='max_saldo']").value);

const error_msg_element = document.querySelector("label[name='error_message']");

async function doSubmit(){
  let saldo = saldo_input_element.value;
  if(saldo < max_saldo){
    error_msg_element.innerHTML = "Saldo kurang dari minimal.";
    return;
  }

  const data = {
    "saldo": saldo
  };

  let response = await fetch_api2("saldo", "add_saldo", data);
  console.log(response);
  if(response["ok"] == "true"){
    alert("Sukses!");
    window.location.href = base_url;
  }
  else
    error_msg_element.innerHTML = parseErrorToMessage(response["error"]);
}