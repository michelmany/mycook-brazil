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
}