<!DOCTYPE html>
<html lang="{{App()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="ECOSABAR R. L.,">
    <meta name="author" content="Super User">
    <title>404 Not Found </title>
    <link href="{{asset('icono.png')}}" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <!--script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous">
    </script-->
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600,700');
        *{
            margin : 0;
            padding : 0;
        }
        body {
            background: #f5f5f5;
            color:#000000;
            /*font-family: "Lucida Console", Monaco, monospace;*/
            font-family: 'Open Sans', sans-serif, Ebrima;
            line-height: 1.5;
        }

        a {
            color: #fff;
            cursor: pointer;
            border-bottom: solid 2px;
        }
        @media (max-width: 639px){
            body{
                min-height: 100vh;
                background: -moz-linear-gradient(left, #018647 0%, #008570 50%, #008685 100%);
                background: -webkit-linear-gradient(left, #018647 0%, #008570 50%, #008685 100%);
                background: linear-gradient(to right, #018647 0%, #008570 50%, #008685 100%);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#018647', endColorstr='#008685', GradientType=1);


            }
            .browser-bar{
                display:none;
            }
            .content{
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                -webkit-transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);

            }
            .text{
                flex: 1;
            }
        }

        @media (min-width: 640px) {
            body {
                /*background-image: url(https://images.unsplash.com/photo-1432821596592-e2c18b78144f?dpr=2&fit=crop&fm=jpg&h=960&ixlib=rb-0.3.5&q=50&w=1440);
                */
                background: #f5f5f5;
                color: #ffffff;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                min-height: 100vh;
            }

            .content {
                width: 500px;
                height: 250px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                -webkit-transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
                background: -moz-linear-gradient(left, #018647 0%, #008570 50%, #008685 100%);
                background: -webkit-linear-gradient(left, #018647 0%, #008570 50%, #008685 100%);
                background: linear-gradient(to right, #018647 0%, #008570 50%, #008685 100%);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#018647', endColorstr='#008685', GradientType=1);

                padding: 45px 20px 20px;
                box-sizing: border-box;
                box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
                border-radius: 5px 5px 0 0;
            }

            .browser-bar {
                background: #f9f9f3;
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                padding: 5px;
                overflow: hidden;
                border-radius: 5px 5px 0 0;
            }

            .button {
                display: inline-block;
                float: left;
                border-radius: 50%;
                width: 15px;
                height: 15px;
                margin-right: 5px;
            }

            .close,.min,.max{
                cursor: text;
            }
            .close {
                /*background: #fc635d;*/
                background: red;
            }

            .min {
                background: #fdbc40;

            }

            .max {
                background: #34c84a;
            }
        }
    </style>
</head>
<body>
<div class="content">
    <div class="browser-bar">
        <span class="close button"></span>
        <span class="min button"></span>
        <span class="max button"></span>
    </div>
    <div class="text">
        <strong style="color:#000">Error 404.</strong> P&aacute;gina no encontrada. <br />
        Puede que la p&aacute;gina que busca se haya eliminado, haya cambiado de nombre
        o est&eacute; temporalmente inaccesible. <br>
        <a onclick="goBack()" class="primary v-btn"><strong>&larr;</strong> Regresar</a>
    </div>

</div>
<script type="text/javascript">
    function goBack() {
        window.history.back();
    }
</script>
<!--script>
    !function(t){"use strict";var s=function(s,e){this.el=t(s),this.options=t.extend({},t.fn.typed.defaults,e),this.isInput=this.el.is("input"),this.attr=this.options.attr,this.showCursor=this.isInput?!1:this.options.showCursor,this.elContent=this.attr?this.el.attr(this.attr):this.el.text(),this.contentType=this.options.contentType,this.typeSpeed=this.options.typeSpeed,this.startDelay=this.options.startDelay,this.backSpeed=this.options.backSpeed,this.backDelay=this.options.backDelay,this.stringsElement=this.options.stringsElement,this.strings=this.options.strings,this.strPos=0,this.arrayPos=0,this.stopNum=0,this.loop=this.options.loop,this.loopCount=this.options.loopCount,this.curLoop=0,this.stop=!1,this.cursorChar=this.options.cursorChar,this.shuffle=this.options.shuffle,this.sequence=[],this.build()};s.prototype={constructor:s,init:function(){var t=this;t.timeout=setTimeout(function(){for(var s=0;s<t.strings.length;++s)t.sequence[s]=s;t.shuffle&&(t.sequence=t.shuffleArray(t.sequence)),t.typewrite(t.strings[t.sequence[t.arrayPos]],t.strPos)},t.startDelay)},build:function(){var s=this;if(this.showCursor===!0&&(this.cursor=t('<span class="typed-cursor">'+this.cursorChar+"</span>"),this.el.after(this.cursor)),this.stringsElement){s.strings=[],this.stringsElement.hide();var e=this.stringsElement.find("p");t.each(e,function(e,i){s.strings.push(t(i).html())})}this.init()},typewrite:function(t,s){if(this.stop!==!0){var e=Math.round(70*Math.random())+this.typeSpeed,i=this;i.timeout=setTimeout(function(){var e=0,r=t.substr(s);if("^"===r.charAt(0)){var o=1;/^\^\d+/.test(r)&&(r=/\d+/.exec(r)[0],o+=r.length,e=parseInt(r)),t=t.substring(0,s)+t.substring(s+o)}if("html"===i.contentType){var n=t.substr(s).charAt(0);if("<"===n||"&"===n){var a="",h="";for(h="<"===n?">":";";t.substr(s).charAt(0)!==h;)a+=t.substr(s).charAt(0),s++;s++,a+=h}}i.timeout=setTimeout(function(){if(s===t.length){if(i.options.onStringTyped(i.arrayPos),i.arrayPos===i.strings.length-1&&(i.options.callback(),i.curLoop++,i.loop===!1||i.curLoop===i.loopCount))return;i.timeout=setTimeout(function(){i.backspace(t,s)},i.backDelay)}else{0===s&&i.options.preStringTyped(i.arrayPos);var e=t.substr(0,s+1);i.attr?i.el.attr(i.attr,e):i.isInput?i.el.val(e):"html"===i.contentType?i.el.html(e):i.el.text(e),s++,i.typewrite(t,s)}},e)},e)}},backspace:function(t,s){if(this.stop!==!0){var e=Math.round(70*Math.random())+this.backSpeed,i=this;i.timeout=setTimeout(function(){if("html"===i.contentType&&">"===t.substr(s).charAt(0)){for(var e="";"<"!==t.substr(s).charAt(0);)e-=t.substr(s).charAt(0),s--;s--,e+="<"}var r=t.substr(0,s);i.attr?i.el.attr(i.attr,r):i.isInput?i.el.val(r):"html"===i.contentType?i.el.html(r):i.el.text(r),s>i.stopNum?(s--,i.backspace(t,s)):s<=i.stopNum&&(i.arrayPos++,i.arrayPos===i.strings.length?(i.arrayPos=0,i.shuffle&&(i.sequence=i.shuffleArray(i.sequence)),i.init()):i.typewrite(i.strings[i.sequence[i.arrayPos]],s))},e)}},shuffleArray:function(t){var s,e,i=t.length;if(i)for(;--i;)e=Math.floor(Math.random()*(i+1)),s=t[e],t[e]=t[i],t[i]=s;return t},reset:function(){var t=this;clearInterval(t.timeout);var s=this.el.attr("id");this.el.after('<span id="'+s+'"/>'),this.el.remove(),"undefined"!=typeof this.cursor&&this.cursor.remove(),t.options.resetCallback()}},t.fn.typed=function(e){return this.each(function(){var i=t(this),r=i.data("typed"),o="object"==typeof e&&e;r||i.data("typed",r=new s(this,o)),"string"==typeof e&&r[e]()})},t.fn.typed.defaults={strings:["These are the default values...","You know what you should do?","Use your own!","Have a great day!"],stringsElement:null,typeSpeed:0,startDelay:0,backSpeed:0,shuffle:!1,backDelay:500,loop:!1,loopCount:!1,showCursor:!0,cursorChar:"|",attr:null,contentType:"html",callback:function(){},preStringTyped:function(){},onStringTyped:function(){},resetCallback:function(){}}}(window.jQuery);

    $(function(){
        $('.text').typed({
            strings: [
                "404. P&aacute;gina no encontrada. <br /> ^1000" +
                "Puede que la p&aacute;gina que busca se haya eliminado, " +
                "haya cambiado de nombre o est&eacute; temporalmente inaccesible.<br /> ^1000" +
                "Go back <a href='/'>home</a> and start over."
            ],
            typeSpeed: 0,
            showCursor: false
        });
    });
</script-->
</body>
</html>