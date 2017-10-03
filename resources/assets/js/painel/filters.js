import moment from 'moment'

export default {
  install: function (Vue) {
    Vue.filter('currency', function (value) {
      if (value === undefined) {
        return ''
      }
      return 'R$ ' + value.toFixed(2)
    })

    Vue.filter('datetime', function (date, filter) {
      return moment(date).format(filter)
    })

    Vue.filter('join', function (data, separator) {
      data = data || [];
      separator = separator || ',';
      if (typeof data === 'object') {
        data = Object.keys(data).map(function (key) { return data[key]; });
      }
      return data.join(separator);
    })
  }
}