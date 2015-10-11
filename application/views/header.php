<!DOCTYPE html>
<html>
    <head>
        <title><?= @$title ? $title : 'DeciMill' ?></title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script src="/application/js/jquery/jquery.js"></script>
        <script src="/application/js/jquery/ajax.js"></script>
        <script src="/application/js/controllers/ModelManager.js"></script>
        <script src="/application/js/controllers/ScenarioManager.js"></script>
        <script src="/application/js/controllers/QueryManager.js"></script>
        <script src="/application/js/codemirror/lib/codemirror.js"></script>
        <script src="/application/js/codemirror/overlay.js"></script>
        <script type="text/javascript" src="/application/js/marked/marked.js"></script>

        <link href="http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300" rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Source+Code+Pro:600' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="/application/js/codemirror/lib/codemirror.css">
        <link rel="stylesheet" href="/application/layout/main.css" />

        <link rel="stylesheet" href="/application/fonts/font-awesome/css/font-awesome.min.css">

    </head>
    <body>
        
        <div id="container">

        <? include_view('heading'); ?>

        <div id="body">