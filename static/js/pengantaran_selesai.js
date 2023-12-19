const id_pengantaran = parseInt(document.querySelector("input[name='id_pengantaran']").value);

const error_msg_element = document.querySelector("label[name='error_message']"); 
const input_keterangan_element = document.querySelector("textarea[name='input-keterangan']");


async function doSubmit(){
  let keterangan = input_keterangan_element.value;

  const data = {
    "id_pengantaran": id_pengantaran,
    "keterangan": keterangan
  };

  let response = await fetch_api2("pengantaran", "selesaikan_pengantaran", data);
  console.log(response);
  if(response["ok"] == "true"){
    alert("Sukses!");
    window.location.href = base_url + "pengantaran";
  }
  else
    alertUserError(response["error"]);
}