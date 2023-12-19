const id_jadwal = document.querySelector("input[id='data-id-jadwal']").value;
const hidden_data_elements = document.querySelectorAll("div[id='hidden-data']");

const no_barang_label_elements = document.querySelector("div[id='label-no-barang']");
const total_harga_elements = document.querySelector("label[id='label-total-harga']");

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
  let element_quantity = value.querySelector("input[id='quantity']");

  let id = `${element_id.value}`;
  let base_harga = element_harga.value;
  let quantity = element_quantity.value;

  let new_data = {
    "id": id,
    "base_harga": base_harga,
    "quantity": quantity
  };

  set_hidden_data(id, new_data);
});

console.log(hidden_data);


function getQuantityElement(id_barang){
  let element = document.querySelector(`tr[id='input-${id_barang}']`);
  return element.querySelector("input[class='barang-quantity']");
}

function setDisabledDecreased(id_barang, is_disabled){
  let parentElement = document.querySelector(`tr[id='input-${id_barang}']`);
  let decreaseButtonElement = parentElement.querySelector("button[class='barang-quantity-decrease']");
  if(is_disabled)
    decreaseButtonElement.setAttribute("disabled", "true");
  else
    decreaseButtonElement.removeAttribute("disabled");
}

function checkAllFE(){
  let do_hidden = true;
  let total_harga = 0;
  for(var key in hidden_data){
    value = hidden_data[key];
    let quantity = value['quantity'];
    let base_harga = value['base_harga'];
    total_harga += quantity * base_harga;

    do_hidden = false;
  }

  total_harga_elements.innerHTML = `Total: Rp. ${total_harga}`;
  if(do_hidden)
    no_barang_label_elements.removeAttribute('hidden');
  else
    no_barang_label_elements.setAttribute("hidden", "hidden");
}

function syncQuantityFE(id_barang){
  let this_input_data = find_hidden_data(id_barang);
  if(!this_input_data)
    return;

  let quantity = this_input_data["quantity"];
  setDisabledDecreased(id_barang, quantity <= 1);

  let quantityElement = getQuantityElement(id_barang);
  quantityElement.value = quantity;

  checkAllFE();
}

function deleteBarangFE(id_barang){
  delete_hidden_data(id_barang);
  let parentElement = document.querySelector(`tr[id='input-${id_barang}']`);
  parentElement.remove();

  checkAllFE();
}


async function quantitySetFetch(id_barang, new_quantity){
  let this_input_data = find_hidden_data(id_barang);
  if(!this_input_data)
    return;

  if(new_quantity > 0){
    const data = {
      "id_jadwal": id_jadwal,
      "id_barang": id_barang,
      "jumlah": new_quantity
    };
  
    let response = await fetch_api2("keranjang", "set_barang_quantity", data);
    console.log(response);
    if(response["ok"] == "true")
      this_input_data["quantity"] = response["new_quantity"];
    else
      alertUserError(response["error"]);
  }

  set_hidden_data(id_barang, this_input_data);
  syncQuantityFE(id_barang);
}



function quantityIncrease(id_barang){
  let this_input_data = find_hidden_data(id_barang);
  if(!this_input_data)
    return;

  quantitySetFetch(id_barang, parseInt(this_input_data["quantity"])+1);
}

function quantitySet(id_barang){
  let new_quantity = parseInt(getQuantityElement(id_barang).value);
  quantitySetFetch(id_barang, new_quantity);
}

function quantityDecrease(id_barang){
  let this_input_data = find_hidden_data(id_barang);
  if(!this_input_data)
    return;

  quantitySetFetch(id_barang, parseInt(this_input_data["quantity"])-1);
}

async function deleteBarang(id_barang){
  let this_input_data = find_hidden_data(id_barang);
  if(!this_input_data)
    return;

  const data = {
    "id_jadwal": id_jadwal,
    "id_barang": id_barang
  };

  let response = await fetch_api2("keranjang", "remove_barang", data);
  console.log(response);
  if(response["ok"] != "true"){
    alertUserError(response["error"]);
    return;
  }

  deleteBarangFE(id_barang);
}



checkAllFE();