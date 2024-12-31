<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sakura - Write your story</title>
    <link rel="stylesheet" href="/style.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link
        href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&amp;family=Raleway:ital,wght@0,100..900;1,100..900&amp;display=swap"
        rel="stylesheet">
</head>


<body>
    <div id="page-container">
<div id="content-wrap">
    <header>
        <nav>
            <div class="flex-item">
                <div id="clock"></div>
                <p>Write your story</p>
            </div>
            <div class="flex-item">
                <?php
                    echo "<a href='";
                    $url = $_SERVER['REQUEST_URI'];
                    if (strpos($url, 'controllers') !== false) {
                        echo "../controllers/control_user.php";
                    } else {
                        echo "./index.php";
                    }
                    echo "'>"
                ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                </a>
            </div>
        </nav>
    </header>
    <div id="progressContainer">
        <div id="progressBar"></div>
    </div>
    <main>
        <div id="sidebar-overlay"></div>
        <aside>
            <div class="tab">
                <span class="cross">&times;</span>
                <div class="gradient"></div>
            </div>

            <div id="sidebar">
                <div class="sidebar-header"></div>
                <div class="menu">
                    <div class="menu_icon">
                        <div class="menu_line menu_line_1"></div>
                        <div class="menu_line menu_line_2"></div>
                        <div class="menu_line menu_line_3"></div>
                    </div>
                </div>
            </div>