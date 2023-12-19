// base url/domain website
const base_url = document.querySelector("meta[name='base_url']").content;


// fungsi helper untuk berkomunikasi dengan API website
async function fetch_api(fungsi_api, data){
  let result = await fetch(base_url+"Api/"+fungsi_api, {
    method: "post",
    mode: "cors",
    credentials: "include",
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },

    body: JSON.stringify(data)
  })
  .then(async (response) => {
    let res_body = await response.text();

    try{
      return await (new Response(res_body)).json();
    }
    catch(err){
      return {
        "ok": "false",
        "error": SERVER_ERROR,
        "error_message": "Server memberikan jawaban HTML, bukan JS. Jawaban server: " + res_body
      };
    }
  })
  .catch((err) => {
    return {
      "ok": "false",
      "error": SERVER_ERROR,
      "error_message": err 
    };
  });

  return result;
}


async function fetch_api2(base_api, fungsi_api, data, data_get = {}){
  let url = `${base_api}/start_api?function=${fungsi_api}`;
  for(const [key, value] of Object.entries(data_get))
    url += `&${encodeURIComponent(key)}=${encodeURIComponent(value)}`;

  return fetch_api(url, data);
}