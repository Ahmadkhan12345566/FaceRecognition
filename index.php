<?php
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Face Recognition</title>
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>

        #camera {
            height: 80%;
        }

        #img {
            -moz-transform: scale(-1, 1);
            -webkit-transform: scale(-1, 1);
            -o-transform: scale(-1, 1);
            transform: scale(-1, 1);
        }

    </style>
</head>
<body>
<div class="container" style="width: 100% ;height: 100%; margin: 10px">

        <div id="test" style="position: relative" class="row">
            <img class="col-sm-12 col-md-10 col-lg-12" style="height:80%;z-index: -1" id="img"
                 src="webcamImage\abc.jpg">
        </div>
        <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"></div>
            <button id="take_snapshots" style="margin-top: 3px" class="btn btn-success btn-sm col-xs-3 col-sm-3 col-md-2 col-lg-2 ">Start
            </button>
        </div>

        <div id="camera" style="visibility: hidden ;position: absolute;  left: 0px;top: 0px; z-index: -1;" class="col-md-12 col-lg-12"></div>

</div> <!-- /container -->
</body>
</html>
<script src="jquery/jquery-3.2.1.min.js"></script>
<script src="jpeg_camera/jpeg_camera_with_dependencies.min.js" type="text/javascript"></script>
<script type="text/JavaScript">
    var refreshInterval = 1500;
    var options = {
        shutter_ogg_url: "jpeg_camera/shutter.ogg",
        shutter_mp3_url: "jpeg_camera/shutter.mp3",
        swf_url: "jpeg_camera/jpeg_camera.swf",
    };
    //, options
    var camera = new JpegCamera("#camera", options);
    //var test = new JpegCamera("#test");
    $('#take_snapshots').click(function () {

        $.post('testpy.php', {},
            function (data) {
            }, "json");

        refresh();
    })
    function removedivs() {
        $(".todelete").remove();
    }
    function refresh() {
        removedivs();
        var snapshot = camera.capture();
        snapshot.show();
        snapshot.upload({api_url: "action.php"}).done(function (response) {
            $.post('runserver.php', {},
                function (data) {
                    var dt = new Date();
                    $("#img").attr("src", "test3.jpg" + '?dt=' + dt.getTime());
                    var retundata = new Array();
                    retundata = data;
                    var count = 0;
                    for (var i = 0; i < retundata.length; i++) {
                        var fromtop = retundata[i][0];
                        var fromleft = retundata[i][1];
                        var faceheight = retundata[i][2];
                        var facewidth = retundata[i][3];
                        var name = retundata[i][4];
                        //creating face dectection
                        cn = 190;
                        $('#test').append('<div id="sec" style="color: #d9edf7;  z-index:0;position:absolute; font-size: 30px;border:2px solid white;"> </div>');
                        $("#sec").attr("id", "findedfaceposition" + count);
                        $("#findedfaceposition" + count).css("left", fromleft);
                        $("#findedfaceposition" + count).css("top", fromtop);
                        $("#findedfaceposition" + count).css("height", faceheight);
                        $("#findedfaceposition" + count).css("width", facewidth);
                        $("#findedfaceposition" + count).addClass("todelete");


                        //creating name on faces face
                        $('#test').append('<div id="first" style="color: #d9edf7;  z-index:0;position:absolute; font-size: 30px;">text</div>');
                        $("#first").attr("id", "findedname" + count);
                        $("#findedname" + count).css("left", fromleft);
                        $("#findedname" + count).html(name);
                        $("#findedname" + count).css("top", fromtop-35);
                        $("#findedname" + count).addClass("todelete");
                        $("#sec").addClass("todelete");
                        count++;
                        //repeating the process again(like infinite loop)

                    }

                    setTimeout("refresh()", refreshInterval);
                }, "json");

        });
    }
    function changeimage() {
        var dt = new Date();
        $("#img").attr("src", "test3.jpg" + '?dt=' + dt.getTime());
    }
    function done() {
        $('#snapshots').html("uploaded");
    }
</script>