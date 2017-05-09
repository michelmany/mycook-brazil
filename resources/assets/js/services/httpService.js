export class HttpService{
  constructor() {
    this.host = '/';
  }

  build(resource) {
    this.host = '/api/' + resource;
    return this;
  }

  list() {
    return axios.get(this.host);
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