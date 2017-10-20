<?php
/** 二进制流生成文件
 * $_POST 无法解释二进制流，需要用到 $GLOBALS['HTTP_RAW_POST_DATA'] 或 php://input
 * $GLOBALS['HTTP_RAW_POST_DATA'] 和 php://input 都不能用于 enctype=multipart/form-data
 * @param    String  $file   要生成的文件路径
 * @return   boolean
 */
function binary_to_file($file)
{
    $content = empty($GLOBALS['HTTP_RAW_POST_DATA']) ? file_get_contents('php://input') : $GLOBALS['HTTP_RAW_POST_DATA']; // 需要php.ini设置
    if (empty($content)) {
        return false;
    }
    $ret = file_put_contents($file, $content, true);
    return $ret;
}

function die_json($message, $code = 0, $default_data = ['a' => ''])
{
    if (is_array($message) || is_object($message)) {
        $data = array(
            'data'    => $message,
            'code'    => 0,
            'message' => 'ok',
        );
    } else {
        $data = array(
            'data'    => $default_data,
            'code'    => $code,
            'message' => $message,
        );
    }

    header("Content-type: application/json; charset:utf-8");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
    header("Access-Control-Max-Age: 20");
    $json_str = json_encode($data, JSON_UNESCAPED_UNICODE);
    if (isset($_REQUEST['callback'])) {
        $cb = $_REQUEST['callback'];
        die($cb . "(" . $json_str . ")");
    }

    die($json_str);
}

function getIp()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip); // just to be safe
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
}
