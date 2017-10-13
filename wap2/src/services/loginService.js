import request from 'utils/request';

export async function loginByWechat() {
  return request('login/wechat');
}
