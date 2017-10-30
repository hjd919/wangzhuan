import {requestAuth} from 'utils/request';

export async function getTaskApps() {
    return	requestAuth('task/getTaskApps');
}
