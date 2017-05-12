<?php

// Content-TypeをJSONに指定する
header('Content-Type: application/json');

// $_POST['age']、$_POST['job']をエラーを出さないように文字列として安全に展開する
foreach (['age', 'job'] as $v) {
    $$v = (string)filter_input(INPUT_POST, $v);
}

// 整合性チェック
if ($age === '' || $job === '') {
    $error = '年齢と職業を両方入力してください';
} else if (!ctype_digit($age)) {
    $error = '年齢は正の整数で入力してください';
} else if (($age = (int)$age)>100) {
    $error = '生きすぎィ！';
}

if (!isset($error)) {
    // 正常時は 「200 OK」 で {"data":"24歳、学生です"} のように返す
    $data = "{$age}歳、{$job}です";
    echo json_encode(compact('data'));
} else {
    // 失敗時は 「400 Bad Request」 で {"error":"..."} のように返す
    http_response_code(400);
    echo json_encode(compact('error'));
}
?>