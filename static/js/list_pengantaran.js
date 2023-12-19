const mark_done_url = document.querySelector("input[name='mark-done-url']").value;
console.log(mark_done_url);


async function ambilPengiriman(id_pengiriman){
  const data = {
    "id_pengantaran": id_pengiriman
  };

  let response = await fetch_api2("pengantaran", "ambil_pengantaran", data);
  console.log(response);
  if(response["ok"] == "true")
    location.reload();
  else
    alertUserError(response["error"]);
}


async function changeStatus(id_pengiriman, new_status){
  console.log("change status");
  if(new_status == "sampai"){
    window.location.href = `${mark_done_url}?id=${id_pengiriman}`;
    return;
  }

  const data = {
    "id_pengantaran": id_pengiriman,
    "status": new_status
  };

  let response = await fetch_api2("pengantaran", "set_status", data);
  console.log(response);
  if(response["ok"] == "true")
    location.reload();
  else
    alertUserError(response["error"]);
}