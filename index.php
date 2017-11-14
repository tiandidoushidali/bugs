<?php
$privteKey = '-----BEGIN PRIVATE KEY-----
MIGEAgEAMBAGByqGSM49AgEGBSuBBAAKBG0wawIBAQQgQWjeV6nHJcZ0jshNNMII
wOX/W0NuVyqLFfdym7l3TdahRANCAAQ/fHWBNT3tqiTqLJXX8kVyUpR3ckXimcVE
b+uRAmFgGC2gZ3ynVswNI5o+pbi0OOjPsiKChU3CUGdO5OrGbxcf
-----END PRIVATE KEY-----';

var_dump(openssl_pkey_get_private($privteKey));


$publicKey = '-----BEGIN PUBLIC KEY-----
MFYwEAYHKoZIzj0CAQYFK4EEAAoDQgAEP3x1gTU97aok6iyV1/JFclKUd3JF4pnF
RG/rkQJhYBgtoGd8p1bMDSOaPqW4tDjoz7IigoVNwlBnTuTqxm8XHw==
-----END PUBLIC KEY-----';
var_dump(openssl_pkey_get_public($publicKey));

var_dump(password_hash(123456, PASSWORD_BCRYPT));