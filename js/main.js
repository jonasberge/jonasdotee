const serializeQuery = function (query, isInitial) {
  const str = [];
  for (const property in query)
    if (Object.prototype.hasOwnProperty.call(query, property)) {
      const key = encodeURIComponent(property);
      const value = encodeURIComponent(query[property]);
      str.push(key + '=' + value);
    }

  if (str.length === 0)
    return '';

  if (typeof isInitial === 'undefined')
    isInitial = true;

  const prefix = isInitial ? '?' : '&';
  return prefix + str.join('&');
};

const form = document.querySelector('#offer-form');
form.onsubmit = function () {
  const data = new FormData(form);
  const parameters = {};

  const url = form.action + serializeQuery(parameters);
  console.log('Delivering submission to:', url);

  const xhr = new XMLHttpRequest();
  xhr.open(form.method, url);
  xhr.send(data);

  xhr.onreadystatechange = function () {
    if (xhr.readyState !== XMLHttpRequest.DONE)
      return;

    document.getElementById('log-result').innerText = xhr.responseText;
    alert(xhr.responseText)

    if (xhr.status === 200) {
      console.log(xhr.responseText);
      return;
    }

    console.log(xhr.responseText);
    switch (xhr.status) {
    case 400:
      break;
    default:
      break;
    }
  };

  return false;
};

window.onerror = function(error) {
  // do something clever here
  alert(error);

  const element = document.getElementById('log-result');
  element.innerText = element.innerText + '\n' + error;
};

// alert('1');
