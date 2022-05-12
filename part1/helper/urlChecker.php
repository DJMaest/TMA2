<?php
function urlIsOk($url)
{
    $headers = @get_headers($url);
    if(!$headers){
        return false;
    }
    $httpStatus = intval(substr($headers[0], 9, 3));
    if ($httpStatus < 400) {
        return true;
    }
    return false;
}
