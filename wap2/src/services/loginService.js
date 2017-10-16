import request from 'utils/request';

export async function loginByPhone(options) {
  return request('login/phone', options);
}

