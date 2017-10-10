import fetch from 'dva/fetch';
import querystring from 'querystring';
import config from 'configs/config';

function parseJSON(response) {
  return response.json();
}

function checkStatus(response) {
  if (response.status >= 200 && response.status < 300) {
    return response;
  }

  const error = new Error(response.statusText);
  error.response = response;
  throw error;
}

// 设置全路径
export function setFullUrl(url) {
  return config.apiUrl + url
}

/**
 * Requests a URL, returning a promise.
 *
 * @param  {string} url       The URL we want to request
 * @param  {object} [options] The options we want to pass to "fetch"
 * @return {object}           An object containing either "data" or "err"
 */
export default function request(url, options={}) {
  // 设置全路径
  url = setFullUrl(url)

  // 设置query参数
  url = options.query ? `${url}?${querystring.stringify(options.query)}` : url;

  return fetch(url, options)
    .then(checkStatus)
    .then(parseJSON)
    .then(data => data)
    .catch(err => ({ err }));
}
