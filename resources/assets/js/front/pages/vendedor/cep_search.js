let callApi = (url) => {
  return new Promise((resolve, reject) => {
    let xhr;
    xhr = new XMLHttpRequest();
    xhr.onload = () => {
      if (xhr.status >= 200 && xhr.status <= 300){
        resolve(xhr.responseText);
      } else {
        reject(xhr.status, xhr.statusText)
      }
    }
    xhr.onerror = () => {
      reject(xhr.status, xhr.statusText)
    }
    xhr.open("GET", url, true);
    xhr.send();
  })
}

let cep = document.getElementById('cep_field');
console.log();
cep.addEventListener('change', () => {
  if (cep.value.length !== 8) {
    return;
  }
  let url = 'https://viacep.com.br/ws/' + cep.value + '/json/';
  callApi(url)
    .then((res) => {
      res = JSON.parse(res);
      let address = document.getElementById('address_field');
      let neighborhood = document.getElementById('neighborhood_field');
      let city = document.getElementById('city_field');
      let state = document.getElementById('state_field');

      address.value = res.logradouro;
      neighborhood.value = res.bairro;
      city.value = res.localidade;
      state.value = res.uf;
    })
    .catch((status) => {
      console.log('erro ' + status);
    });
});