import { Toast } from 'antd-mobile';
import fetch from 'dva/fetch';

import config from 'configs/config';
import querystring from 'querystring';

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
export default function request(url, options={}, isAuth=false) {
  if (isAuth == 'isAuth') {
    // 带api_token
    const api_token = localStorage.api_token
    if (!api_token) {
      return false
    }
    if(!options.query){
      options.query = {}
    }
    options.query['api_token'] = api_token
  }

  // 设置全路径
  url = setFullUrl(url)

  const fetchOptions = {
    method: options.method || 'GET',
  };

  url = options.query ? `${url}?${querystring.stringify(options.query)}` : url;

  if (fetchOptions.method !== 'GET') {
    fetchOptions.headers = {
      Accept: 'application/json',
      'Content-Type': 'application/json',
    };
    try {
      fetchOptions.body = JSON.stringify(options.data);
    } catch (e) {
      global.document && Toast.fail('未知错误,请重试！');
      console.error(`${fetchOptions.method}: ${url} Error.`, e);
      return null;
    }

    // formData
    if (options.formData) {
      const formData = new FormData();
      Object.keys((options.formData || {})).forEach((key) => {
        if (options.formData[key] !== undefined) { formData.append(key, options.formData[key]); }
      });
      fetchOptions.body = formData;
      fetchOptions.headers = {
        Accept: 'application/json',
        // 'Content-Type': 'multipart/form-data'
      };
    }
  }

  fetchOptions.headers = fetchOptions.headers || {};

  return fetch(url, fetchOptions)
      .then(checkStatus)
      .then(parseJSON)
      .then(data => data)
      .catch(err => {

        if(err.response.status == 401){
          // 未授权登录
          Toast.fail('请先登录再访问', 1, ()=>{
            location.href="/login"
          });
        }

        return false
      });
}
