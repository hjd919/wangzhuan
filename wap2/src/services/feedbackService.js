import {requestAuth} from 'utils/request';

export async function submitFeedback(data) {
	let requestData = {}
	requestData.method = 'POST'
	requestData.formData = data
    return	requestAuth('feedback/submit', requestData);
}
