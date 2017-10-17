import {requestAuth} from 'utils/request';

export async function submitFeedback(data) {
	let requestData = {}
	requestData.method = 'POST'
	requestData.formData = data
	console.log(requestData)
    return	requestAuth('feedback/submit', requestData);
}
