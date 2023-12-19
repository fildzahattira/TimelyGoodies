const baseUrl = document.querySelector("meta[name='base_url']").content;

const tipePage = document.querySelector("input[id='data-tipe-page']").value;
let idJadwal = null;
{let idJadwalElement = document.querySelector("input[id='data-id-jadwal']");
  if(idJadwalElement != null)
    idJadwal = idJadwalElement.value;
}

const errorMessageElement = document.querySelector("label[name='error_message']");

const nameElement = document.querySelector("input[name='nama_jadwal']");
const tanggalMulaiElement = document.querySelector("input[name='tanggal_mulai']");
const tipeIntervalElement = document.querySelectorAll("input[name='tipe_interval']");
const intervalHariElement = document.querySelector("input[name='interval_hari']");
const hariHariElement = document.querySelectorAll("input[name='hari_hari']");


console.log(tipePage);

async function doSubmit(){
  let name = nameElement.value;
  let tanggal = tanggalMulaiElement.value;
  let tipeInterval = "";
  for(let i = 0; i < tipeIntervalElement.length; i++){
    const el = tipeIntervalElement[i];
    if(el.checked){
      console.log("tipe ", el.value);
      tipeInterval = el.value;
      break;
    }
  }

  let intervalHari = parseInt(intervalHariElement.value);
  let hariHari = "";
  for(let i = 0; i < hariHariElement.length; i++){
    const el = hariHariElement[i];
    if(el.checked){
      if(hariHari.length > 0)
        hariHari += ",";

      hariHari += el.value;
    }
  }

  if(hariHari.length <= 0)
    hariHari = hariHariElement[0].value;

  let data = {
    "nama_jadwal": name,
    "tipe_interval": tipeInterval,
    "interval_hari": intervalHari,
    "list_hari": hariHari
  };

  if(tanggal != "")
    data["tanggal_mulai"] = tanggal;
  
  let fetchFunc = "";
  if(tipePage == "create"){
    fetchFunc = "create_jadwal"
  }
  else if(tipePage == "edit"){
    fetchFunc = "update_jadwal";
    data["id_jadwal"] = parseInt(idJadwal);
  }

  console.log(data);

  let response = await fetch_api2("keranjang", fetchFunc, data);
  console.log(response);
  if(response["ok"] == "true"){
    alert("Sukses!");
    window.location.href = baseUrl + "jadwal";
  }
  else
    errorMessageElement.innerHTML = `error: ${response["error"]}`;
}




function toggleForms() {
  var intervalHariRadio = document.getElementById('interval_hari_radio');
  var intervalForm = document.getElementById('intervalForm');
  var harianRadio = document.getElementById('harian_radio');
  var harianForm = document.getElementById('harianForm');

  if (intervalHariRadio.checked) {
      intervalForm.style.display = 'block';
      harianForm.style.display = 'none';
  } else if (harianRadio.checked) {
      harianForm.style.display = 'block';
      intervalForm.style.display = 'none';
  }
}

toggleForms();