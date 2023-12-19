const hidden_data_elements = document.querySelectorAll("div[id='hidden-data']");

const select_jadwal_element = document.querySelector("select[name='pilihan-jadwal']")
const preview_harga_element = document.querySelector("label[class='preview-harga']");
const barang_quantity_element = document.querySelector("input[class='barang-quantity']");

const barang_picked_elements = document.querySelectorAll("input[name='id-barang-picked']");

let current_quantity = 1;
let hidden_data = {};
function find_hidden_data(id_barang){
  if(`${id_barang}` in hidden_data)
    return hidden_data[`${id_barang}`];

  return false;
}

function set_hidden_data(id_barang, data){
  hidden_data[`${id_barang}`] = data;
}

function delete_hidden_data(id_barang){
  if(`${id_barang}` in hidden_data)
    delete hidden_data[`${id_barang}`];
}


hidden_data_elements.forEach((value, index, arr) => {
  let element_id = value.querySelector("input[id='id_barang']");
  let element_harga = value.querySelector("input[id='base_harga']");

  let id = `${element_id.value}`;
  let base_harga = element_harga.value;

  let new_data = {
    "id": id,
    "base_harga": base_harga
  };

  set_hidden_data(id, new_data);
});

console.log(hidden_data);


function setDisabledDecreased(is_disabled){
  let decreaseButtonElement = document.querySelector("button[class='barang-quantity-decrease']");
  if(is_disabled)
    decreaseButtonElement.setAttribute("disabled", "true");
  else
    decreaseButtonElement.removeAttribute("disabled");
}

function getSelectedCheckedBarang(){
  for(let i = 0; i < barang_picked_elements.length; i++){
    let element = barang_picked_elements[i];
    if(element.checked)
      return parseInt(element.value);
  }

  return false;
}

function getSelectedCheckedJadwal(){
  let chooseId = select_jadwal_element.value;
  if(chooseId == "null")
    return false;

  return chooseId;
}

function syncQuantityFE(){
  setDisabledDecreased(current_quantity <= 1);

  barang_quantity_element.value = current_quantity;
  let checkedId = getSelectedCheckedBarang();
  let previewHarga = "-";
  if(checkedId != false){
    let data = find_hidden_data(checkedId);
    if(data != false){
      previewHarga = parseInt(data["base_harga"]) * current_quantity;
    }
  }
  
  preview_harga_element.innerHTML = `Total Rp. ${previewHarga}`;
}


function quantityDecrease(){
  if(current_quantity <= 1)
    return;

  current_quantity--;
  syncQuantityFE();
}

function quantitySet(){
  let new_quantity = barang_quantity_element.value;
  if(new_quantity <= 0)
    new_quantity = 1;
    
  current_quantity = new_quantity;
  syncQuantityFE();
}

function quantityIncrease(){
  current_quantity++;
  syncQuantityFE();
}


function setChecked(){
  syncQuantityFE();
}


async function addToCartClicked(){
  let idJadwal = getSelectedCheckedJadwal();
  if(idJadwal == false){
    alert("Jadwal belum dipilih.");
    return;
  }

  let idBarang = getSelectedCheckedBarang();
  if(idBarang == false){
    alert("Barang belum dipilih");
    return;
  }

  let quantity = current_quantity;
  const data = {
    "id_jadwal": idJadwal,
    "id_barang": idBarang,
    "jumlah": quantity
  };

  console.log(data);
  let response = await fetch_api2("keranjang", "add_barang", data);
  console.log(response);
  if(response["ok"] == "true")
    alert("Barang berhasil dimasukkan!");
  else
    alertUserError(response["error"]);
}

syncQuantityFE();