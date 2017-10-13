import request from 'utils/request';

export async function getIndexPage() {
  return request('index/get');
}
