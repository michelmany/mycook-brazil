export class HttpService{
  constructor() {
    this.host = '/';
  }

  build(resource) {
    this.host = '/api/' + resource;
    return this;
  }

  list(options) {
    options = options || {};
    let query = options.query || '';
    if (query !== '') {
      query = '?' + query;
    }
    return axios.get(this.host + query);
  }

  get(id) {
    return axios.get(this.host + '/' + id);
  }

  create(data) {
    return axios.post(this.host, data);
  }

  update(id, data) {
    return axios.put(this.host + '/' + id, data);
  }

  remove(id) {
    return axios.delete(this.host + '/' + id);
  }

  xmlHttpRequest(url) {
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
}