<!DOCTYPE html>
<html>
    <head>
        <title>Temporary Status</title>
        <link rel="shortcut icon" type="image/png" href="{{asset('favicon.png')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('res/semantic.min.css')}}">
        <style type="text/css">
            body{
                padding-top: 200px;
                background-image: url(image/bg.jpg);
                background-repeat: no-repeat;
                background-size: 80%;
            }
            h1,h2{text-shadow:0 0 5px #fff}
        </style>
    </head>
    <body>
        <div class="ui fixed borderless menu">
            <div class="ui container">
                <a href="/" class="header item">
                    <img src="{{asset('logo.png')}}" style="margin-right:10px">
                    Temporary Status
                </a>
            </div>
        </div>
        <div class="ui center aligned container">
            <h1 class="ui header" style="font-size:60px">Temporary Status</h1>
            <h2>Post your social media status with Auto DELETE</h2>
        </div>
        <br><br>
        <div class="ui center aligned container">
            <a href="{{URL::to('facebook/auth')}}" class="ui facebook huge button">
                <i class="facebook square icon"></i>
                Facebook
            </a>
            <a href="{{URL::to('twitter/auth')}}" class="ui twitter huge button">
                <i class="twitter square icon"></i>
                Twitter
            </a>
        </div>
        <div class="ui bottom fixed blue inverted borderless menu">
            <div class="ui container">
                <div class="right menu">
                    <a href="/privacypolicy" class="header item">
                        Privacy &amp; Policy
                    </a>
                    <a href="/terms" class="header item">
                        Terms of Service
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>