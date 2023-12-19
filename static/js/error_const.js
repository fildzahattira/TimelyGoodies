// general error
const ERROR_OK = 0x0;
const SERVER_ERROR = 0x1;
<<<<<<< HEAD
const INTERNAL_ERROR = 0x2;
const PARAMETER_ERROR = 0x3;
=======
const INTERVAL_ERROR = 0x2;
>>>>>>> 287d50661872511a97899037362e2b035ce9316b

// user error
const USER_ERROR_ALREADY_EXIST = 0x101;
const USER_ERROR_USER_NOT_FOUND = 0x102;
const USER_ERROR_PASSWORD_WRONG = 0x103;
const USER_ERROR_ALREADY_LOGGED_IN = 0x104;
const USER_ERROR_NOT_LOGGED_IN = 0x105;

// page error
const PAGE_ERROR_NOT_FOUND = 0x201;
const PAGE_ERROR_NO_ITEM = 0x202;

// barang error
const BARANG_ERROR_NOT_FOUND = 0x301;
const BARANG_ERROR_IMAGES_NOT_FOUND = 0x302;
<<<<<<< HEAD
const BARANG_ERROR_PAGE_NOT_FOUND = 0x303;

// jadwal error
const DATA_JADWAL_ERROR_NOT_FOUND = 0x401;
const DATA_JADWAL_ERROR_INVALID_OWNER = 0x402;
const DATA_JADWAL_ERROR_PARAMETER_WRONG = 0x403;
const DATA_JADWAL_ERROR_INVALID_INTERVAL = 0x404;

// keranjang error
const KERANJANG_JADWAL_ERROR_BARANG_NOT_FOUND = 0x501;

// pengantaran error
const PENGANTARAN_ERROR_NO_ACTIVE_PENGANTARAN = 0x601;
const PENGANTARAN_ERROR_INVALID_OWNER = 0x602;
const PENGANTARAN_ERROR_NOT_FOUND = 0x603;
const PENGANTARAN_ERROR_ALREADY_TAKEN = 0x604;
const PENGANTARAN_ERROR_INVALID_KURIR = 0x605;
const PENGANTARAN_ERROR_ALREADY_DONE = 0x606;

// kategori error
const KATEGORI_ERROR_NOT_FOUND = 0x701;

// kurir error
const KURIR_ERROR_NOT_LOGGED_IN = 0x801;



const message_error_array = {
  ERROR_OK: "Sukses",
  SERVER_ERROR: "Terdapat kesalahan pada server.",
  INTERNAL_ERROR: "Terdapat kesalahan pada server.",
  PARAMETER_ERROR: "Input ada yang salah.",

  USER_ERROR_ALREADY_EXIST: "User sudah ada.",
  USER_ERROR_USER_NOT_FOUND: "User tidak ditemukan.",
  USER_ERROR_PASSWORD_WRONG: "Password salah.",
  USER_ERROR_ALREADY_LOGGED_IN: "Pengguna sudah masuk.",

  PAGE_ERROR_NOT_FOUND: "Item tidak ditemukan.",
  PAGE_ERROR_NO_ITEM: "Tidak ada barang pada item.",

  BARANG_ERROR_NOT_FOUND: "Barang tidak ditemukan.",
  BARANG_ERROR_IMAGES_NOT_FOUND: "Barang tidak ada gambar.",
  BARANG_ERROR_PAGE_NOT_FOUND: "Item tidak ditemukan",

  DATA_JADWAL_ERROR_NOT_FOUND: "Jadwal tidak ditemukan.",
  DATA_JADWAL_ERROR_INVALID_OWNER: "User tidak punya akses untuk jadwal tersebut.",
  DATA_JADWAL_ERROR_PARAMETER_WRONG: "Settingan pada jadwal tidak benar.",
  DATA_JADWAL_ERROR_INVALID_INTERVAL: "Setting interval waktu salah.",

  KERANJANG_JADWAL_ERROR_BARANG_NOT_FOUND: "Barang tidak ditemukan di jadwal tersebut.",

  PENGANTARAN_ERROR_NO_ACTIVE_PENGANTARAN: "Tidak ada pengantaran yang aktif.",
  PENGANTARAN_ERROR_INVALID_OWNER: "User tidak punya akses untuk pengantaran tersebut.",
  PENGANTARAN_ERROR_NOT_FOUND: "Pengantaran tidak ditemukan.",
  PENGANTARAN_ERROR_ALREADY_TAKEN: "Pengantaran sudah diambil.",
  PENGANTARAN_ERROR_INVALID_KURIR: "Kurir tidak punya akses untuk pengantaran tersebut.",
  PENGANTARAN_ERROR_ALREADY_DONE: "Pengantaran sudah selesai.",

  KATEGORI_ERROR_NOT_FOUND: "Kategori tidak ditemukan."
};


function parseErrorToMessage(error_code){
  if(error_code in message_error_array)
    return message_error_array[error_code];

  return "Error";
}

function alertUserError(error_code){
  let str = parseErrorToMessage(error_code);
  alert(str);
}
=======
const BARANG_ERROR_PAGE_NOT_FOUND = 0x303;
>>>>>>> 287d50661872511a97899037362e2b035ce9316b
