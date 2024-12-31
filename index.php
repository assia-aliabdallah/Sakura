<?php
$isUser = false;
$isAdmin = false;
$pfp = null;
require_once __DIR__ . '/models/model_user.php';    

include __DIR__ . '/views/view_header.php';
include __DIR__ . '/views/view_authentification.php';
include __DIR__ . '/controllers/control_post.php';
include __DIR__ . '/views/view_footer.php';
?>