<?php
if ($f == 'update_user_cover_picture') {
    if (isset($_FILES['cover']['name'])) {
        $ai_post = 0;
        if ($wo['config']['ai_user_system'] == 1 && !empty($_POST['ai_post']) && $_POST['ai_post'] == 'on') {
            $ai_post = 1;
        }
        $upload = Wo_UploadImage($_FILES["cover"]["tmp_name"], $_FILES['cover']['name'], 'cover', $_FILES['cover']['type'], $_POST['user_id'],'',$ai_post);
        if ($upload === true) {
            $img              = Wo_UserData($_POST['user_id']);
            $_SESSION['file'] = $img['cover_org'];
            $data             = array(
                'status' => 200,
                'img' => $img['cover'],
                'cover_or' => $img['cover_org'],
                'cover_full' => Wo_GetMedia($img['cover_full']),
                'session' => $_SESSION['file']
            );
        } else {
            $data = $upload;
        }
    }
    Wo_CleanCache();
    header("Content-type: application/json");
    echo json_encode($data);
    exit();
}
