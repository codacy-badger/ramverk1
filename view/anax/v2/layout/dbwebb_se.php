<?php

namespace Anax\View;

use Anax\StyleChooser\StyleChooserController;

/**
 * A layout rendering views in defined regions.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

$htmlClass = $htmlClass ?? [];
$lang = $lang ?? "sv";
$charset = $charset ?? "utf-8";
$title = ($title ?? "No title") . ($baseTitle ?? " | Me-sida");
$bodyClass = $bodyClass ?? null;

// Set active stylesheet
$request = $di->get("request");
$session = $di->get("session");
if ($request->getGet("style")) {
    $session->set("redirect", currentUrl());
    redirect("style/update/" . rawurlencode($_GET["style"]));
}

// Get the active stylesheet, if any.
$activeStyle = $session->get(StyleChooserController::getSessionKey(), null);
if ($activeStyle) {
    $stylesheets = [];
    $stylesheets[] = $activeStyle;
}

// Get hgrid & vgrid
if ($request->hasGet("hgrid")) {
    $htmlClass[] = "hgrid";
}
if ($request->hasGet("vgrid")) {
    $htmlClass[] = "vgrid";
}

// Show regions
if ($request->hasGet("regions")) {
    $htmlClass[] = "regions";
}

// Get flash message if any and add to region flash-message
$flashMessage = $session->getOnce("flashmessage");
if ($flashMessage) {
    $di->get("view")->add(__DIR__ . "/../flashmessage/default", ["message" => $flashMessage], "flash-message");
}

// Get current route to make as body class
$route = "route-" . str_replace("/", "-", $di->get("request")->getRoute());


if (!function_exists('endsWith')) {
    include_once("func.php");
}

?><!doctype html>
<html <?= classList($htmlClass) ?> lang="<?= $lang ?>">
<head>

    <meta charset="<?= $charset ?>">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if (isset($favicon)) : ?>
    <link rel="icon" href="<?= asset($favicon) ?>">
    <?php endif; ?>

    <?php if (isset($stylesheets)) : ?>
        <?php foreach ($stylesheets as $stylesheet) : ?>
            <link rel="stylesheet" type="text/css" href="<?= asset($stylesheet) ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($style)) : ?>
    <style><?= $style ?></style>
    <?php endif; ?>

</head>



<body <?= classList($bodyClass, $route) ?>>

<!-- wrapper around all items on page -->
<div class="wrap-all">


<!-- siteheader with optional columns -->
<?php if (regionHasContent("header") || regionHasContent("header-col-1")) : ?>
<div class="outer-wrap outer-wrap-header">
    <div class="inner-wrap inner-wrap-header">
        <div class="row">
            <header class="region-header" role="banner">
                <!-- header -->
                <?php if (regionHasContent("header")) : ?>
                <div class="region-header-col-1">
                    <?php renderRegion("header") ?>
                </div>
                <?php endif; ?>

                <!-- header-col-1 -->
                <?php if (regionHasContent("header-col-1")) : ?>
                <div class="region-header-col-1">
                    <?php renderRegion("header-col-1") ?>
                </div>
                <?php endif; ?>

                <!-- header-col-2 -->
                <?php if (regionHasContent("header-col-2")) : ?>
                <div class="region-header-col-2">
                    <?php renderRegion("header-col-2") ?>
                </div>
                <?php endif; ?>

                <!-- header-col-3 -->
                <?php if (regionHasContent("header-col-3")) : ?>
                <div class="region-header-col-3">
                    <?php renderRegion("header-col-3") ?>
                </div>
                <?php endif; ?>
            </header>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- navbar -->

<?php if (regionHasContent("navbar")) : ?>
<div class="outer-wrap outer-wrap-navbar">
    <div class="inner-wrap inner-wrap-navbar">
        <div class="row">
            <nav class="region-navbar" role="navigation">
                <?php renderRegion("navbar") ?>
            </nav>
        </div>
    </div>
</div>
<?php endif; ?>


<div id="cover">

</div>
<script>
    var ele = document.getElementsByClassName("route-");
    if (ele[0].className.endsWith("route-") !== false) {
        var divs = `<div class="image-cover">
            <div class="landing-img-text">
                <p>An investment in knowledge pays the best interest.</p>
                <p>- Benjamin Franklin</p>
                </div>
            <img class="landing-img" src="img/table.jpg" alt="">
        </div>`;
        var div = document.getElementById("cover");
        div.innerHTML += divs;
    }
</script>

<!-- breadcrumb -->
<?php if (regionHasContent("breadcrumb")) : ?>
<div class="outer-wrap outer-wrap-breadcrumb">
    <div class="inner-wrap inner-wrap-breadcrumb">
        <div class="row">
            <div class="region-breadcrumb">
                <?php renderRegion("breadcrumb") ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>



<!-- flash message -->
<?php if (regionHasContent("flash-message")) : ?>
<div class="outer-wrap outer-wrap-flash-message">
    <div class="inner-wrap inner-wrap-flash-message">
        <div class="row">
            <div class="region-flash-message">
                <?php renderRegion("flash-message") ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>



<!-- columns-above -->
<?php if (regionHasContent("columns-above")) : ?>
<div class="outer-wrap outer-wrap-columns-above">
    <div class="inner-wrap inner-wrap-columns-above">
        <div class="row">
            <div class="region-columns-above">
                <?php renderRegion("columns-above") ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>



<!-- main -->
<div class="outer-wrap outer-wrap-main">
    <div class="inner-wrap inner-wrap-main">
        <div class="row">

<?php
$sidebarLeft  = regionHasContent("sidebar-left");
$sidebarRight = regionHasContent("sidebar-right");
$class = "";
$class .= $sidebarLeft  ? "has-sidebar-left "  : "";
$class .= $sidebarRight ? "has-sidebar-right " : "";
$class .= empty($class) ? "" : "has-sidebar";
?>

            <?php if ($sidebarLeft) : ?>
            <div class="wrap-sidebar region-sidebar-left <?= $class ?>" role="complementary">
                <?php renderRegion("sidebar-left") ?>
            </div>
            <?php endif; ?>

            <?php if (regionHasContent("main")) : ?>
            <main class="region-main <?= $class ?>" role="main">
                <?php renderRegion("main") ?>
            </main>
            <?php endif; ?>

            <?php if ($sidebarRight) : ?>
            <div class="wrap-sidebar region-sidebar-right <?= $class ?>" role="complementary">
                <?php renderRegion("sidebar-right") ?>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>



<!-- after-main -->
<?php if (regionHasContent("after-main")) : ?>
<div class="outer-wrap outer-wrap-after-main">
    <div class="inner-wrap inner-wrap-after-main">
        <div class="row">
            <div class="region-after-main">
                <?php renderRegion("after-main") ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>



<!-- columns-below -->
<?php if (regionHasContent("columns-below")) : ?>
<div class="outer-wrap outer-wrap-columns-below">
    <div class="inner-wrap inner-wrap-columns-below">
        <div class="row">
            <div class="region-columns-below">
                <?php renderRegion("columns-below") ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>



<!-- sitefooter -->
<?php if (regionHasContent("footer")) : ?>
<div class="outer-wrap outer-wrap-footer" role="contentinfo">
    <div class="inner-wrap inner-wrap-footer">
        <div class="row">
            <div class="region-footer">
                <?php renderRegion("footer") ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>



</div> <!-- end of wrapper -->



<!-- render javascripts -->
<?php if (isset($javascripts)) : ?>
    <?php foreach ($javascripts as $javascript) : ?>
    <script async src="<?= asset($javascript) ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>


<!-- useful for inline javascripts such as google analytics-->
<?php if (regionHasContent("body-end")) : ?>
    <?php renderRegion("body-end") ?>
<?php endif; ?>

</body>
<script>
    var x = document.getElementsByClassName("scroll");
    var y = document.getElementsByClassName("rm-button");
    if (window.location.href.endsWith('htdocs/')) {
        window.onscroll = function(ev) {
            if (window.scrollY >= 500) {
                x[0].classList.add("color");
                x[0].classList.add("black-text");
                y[0].classList.add("white-text");
            } else {
                x[0].classList.remove("color");
                y[0].classList.remove("white-text");
            }
        };
    }
    else {
        // window.onscroll = function(ev) {
            // if (window.scrollY >= 0) {
                x[0].classList.add("color");
                x[0].classList.remove("white-text");
            // } else {
            //     x[0].classList.remove("color");
            //     // x[0].classList.add("white-text");
            //     // y[0].classList.add("white-text");
            // }
        // }
    }


</script>

</html>
