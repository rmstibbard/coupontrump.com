<?php

if ( (isset($_GET['trending']) && ($_GET['trending'] == "yes")) ) {
    $trending="yes";
} else {
    $trending="no";
}

//if ( (isset($_GET['recently_updated']) && ($_GET['recently_updated'] == "yes")) ) {
//    $recently_updated = "yes";
//} else {
//    $recently_updated = "no";
//}

if ( (isset($_GET['cat']) && (stripos($_GET['cat'], '<')===FALSE)) ) {
    $cat = $_GET['cat'];
} else {
    $cat = "";
}

if ( (isset($_GET['subcat']) && (stripos($_GET['subcat'], '<')===FALSE)) ) {
    $subcat = $_GET['subcat'];
} else {
    $subcat = "";
}


if ( (isset($_GET['keywords']) && (stripos($_GET['keywords'], '<')===FALSE)) ) {
    $keywords = $_GET['keywords'];
} else {
    $keywords = "";
}

if ( (isset($_GET['author']) && (stripos($_GET['author'], '<')===FALSE)) ) {
    $author = $_GET['author'];
} else {
    $author = "";
}

if (isset($_GET['course'])) {
    $slug = $_GET['course'];
} else {
    $slug = "";
} 

if ( (isset($_GET['order']) && (stripos($_GET['order'], '<')===FALSE)) ) {
    $order = $_GET['order'];
} else {
    $order = "new";
}


if (isset($_GET['minprice']) && (is_numeric($_GET['minprice'])) && ($_GET['minprice']>=0) ) {
    $minprice = $_GET['minprice'];
} else {
    $minprice = "";
}


if (isset($_GET['maxprice']) && (is_numeric($_GET['maxprice'])) && ($_GET['maxprice']>=0)  ) {
    $maxprice = $_GET['maxprice'];
} else {
    $maxprice = "";
}

if ( (isset($_GET['free']) && ($_GET['free'] == "yes")) ) {
    $free="yes";
    $maxprice = "0";
} else {
    $free="no";
}


if ( (isset($_GET['sort']) && (stripos($_GET['sort'], '<')===FALSE)) ) {
    $sort = $_GET['sort'];
} else {
    $sort = "";
}

if ( (isset($_POST['id']) && (stripos($_POST['id'], '<')===FALSE)) ) {
    $id = intval($_POST['id']);
} else {
    $id = "";
}

if ( (isset($_GET['id']) && (stripos($_GET['id'], '<')===FALSE)) ) {
    $id = intval($_GET['id']);
} else {
    $id = "";
}


$filename = basename($_SERVER['SCRIPT_FILENAME']);

?>