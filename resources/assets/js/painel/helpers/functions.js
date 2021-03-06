export function chunk_split (body, chunklen, end) { 
  // eslint-disable-line camelcase
  chunklen = parseInt(chunklen, 10) || 76
  end = end || '\r\n'
  if (chunklen < 1) {
    return false
  }
  return body.match(new RegExp('.{0,' + chunklen + '}', 'g'))
    .join(end)
};


export function number_format (number, decimals, decPoint, thousandsSep) { 
  // eslint-disable-line camelcase
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
  var n = !isFinite(+number) ? 0 : +number
  var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
  var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
  var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
  var s = ''
  var toFixedFix = function (n, prec) {
    var k = Math.pow(10, prec)
    return '' + (Math.round(n * k) / k)
      .toFixed(prec)
  }
  // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || ''
    s[1] += new Array(prec - s[1].length + 1).join('0')
  }
  return s.join(dec)
}


export function refreshAt(hours, minutes, seconds) {
    var now = new Date();
    var then = new Date();

    if(now.getHours() > hours ||
       (now.getHours() == hours && now.getMinutes() > minutes) ||
        now.getHours() == hours && now.getMinutes() == minutes && now.getSeconds() >= seconds) {
        then.setDate(now.getDate() + 1);
    }
    then.setHours(hours);
    then.setMinutes(minutes);
    then.setSeconds(seconds);

    var timeout = (then.getTime() - now.getTime());
    return setTimeout(function() { window.location.reload(true); }, timeout);
}


export function removeAccent( newStringComAcento ) {
  var string = newStringComAcento;
  var mapaAcentosHex = {
  a : /[\xE0-\xE6]/g,
  A : /[\xC0-\xC6]/g,
  e : /[\xE8-\xEB]/g,
  E : /[\xC8-\xCB]/g,
  i : /[\xEC-\xEF]/g,
  I : /[\xCC-\xCF]/g,
  o : /[\xF2-\xF6]/g,
  O : /[\xD2-\xD6]/g,
  u : /[\xF9-\xFC]/g,
  U : /[\xD9-\xDC]/g,
  c : /\xE7/g,
  C : /\xC7/g,
  n : /\xF1/g,
  N : /\xD1/g,
  };

  for ( var letra in mapaAcentosHex ) {
    var expressaoRegular = mapaAcentosHex[letra];
    string = string.replace( expressaoRegular, letra );
  }

  return string;
}