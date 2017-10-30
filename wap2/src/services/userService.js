import request from 'utils/request';

export async function getUserinfo() {
    return	request('user/getUserinfo', {}, 'isAuth');
}
