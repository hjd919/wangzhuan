import * as CryptoJS from 'crypto-js';

const salt = 'a12qed13sd'

/*AES加密*/
export function Encrypt(data) {
    let dataStr = JSON.stringify(data);
    let encrypted = CryptoJS.AES.encrypt(dataStr, salt);
    return encrypted.toString();
}

/*AES解密*/
export function Decrypt(data) {
    let data2 = data.replace(/\n/gm, "");
    let decrypted = CryptoJS.AES.decrypt(data2, salt);
    return JSON.parse(decrypted.toString(CryptoJS.enc.Utf8));
}