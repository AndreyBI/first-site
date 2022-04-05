<?php
    /*
     ** Correct caching ban in php
     */
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Expires: " . date("r"));

    require_once "language_class.php";
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    //////////////////// taking words from system.ini///////////////////////
    function getLanguage()
    {
        if (isset($_GET['lang'])) {
            $change = $_GET['lang'];
        } else {
            $change = '';
        }
        if ($change == "en") return "en";
        elseif ($change == "ru") return "ru";

        preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/', strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]), $matches); // Получаем массив $matches с соответствиями
        $langs = array_combine($matches[1], $matches[2]); // Создаём массив с ключами $matches[1] и значениями $matches[2]
        foreach ($langs as $n => $v)
            $langs[$n] = $v ? $v : 1; // Если нет q, то ставим значение 1
        arsort($langs); // Сортируем по убыванию q
        $default_lang = key($langs); // Берём 1-й ключ первого (текущего) элемента (он же максимальный по q)
        if (strpos($default_lang, "ru") !== false) return "ru";
        elseif (strpos($default_lang, "en") !== false) return "en";
        else return "en";
    }

    $language = getLanguage();
    $lang = new Language($language);    

    //////////////////// taking words from base 0f data ///////////////////////
    function getArticle($id){
        $language = getLanguage();
        $mysqli = new mysqli("127.0.0.1", "mysql", "mysql", "******");
        $mysqli->set_charset("utf8");
        $result_set = $mysqli->query("SELECT * FROM `articles_$language` WHERE `id`= '$id'");
        $article = $result_set->fetch_assoc();
        $mysqli->close();
        return $article["text"];
    }
?>
<!DOCTYPE html>
<html id="var-in-js" lang="<?=$lang->get("LANG")?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Media queries will not work without the previous line!!!-->
    <title><?=$lang->get("TITLE_MAIN")?></title>
    <link id="langstyle" rel="stylesheet" href="css/index_ru.css">
    <link id="style" rel="stylesheet" href="css/day.css">
    <link rel="stylesheet" href="css/phonecode.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/info.css">
    <link id="IE" rel="stylesheet" href="">
    <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" rel="text/javascript" src="js/index.js"></script>  
    <script type="text/javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script>
    <script type="text/javascript" src="js/counties-<?=$lang->get("LANG")?>.js"></script>
    <script type="text/javascript" src="js/phonecode.js"></script>
    <!-- for the country code -->
    <script type="text/javascript">
        $(function(){
            $('#phone').phonecode({
                preferCo: 'ru',
                lang: '<?=$lang->get("LANG")?>'
            });
        });
    </script>
    <!-- Send form to php -->
    <script type="text/javascript">
		$(document).ready(function(){
			$('#submit').click(function(){
                $('#app-text').addClass('app-form');
                $('#app-text-2').addClass('app-form');
                $('input').addClass('app-form');
                $('textarea').addClass('app-form');
                $('.field').addClass('app-form');   
                $('.formname').addClass('app-form');
                $('#mes-img').addClass('app-form');
                $('.messages>span').addClass('app-form');
                $('#wait').removeClass('app-form');
				// collecting data from the form
                var name 	 = $('#name').val();
                var code     = parseFloat(document.querySelector(".country-phone-selected").textContent);
                var phone    = $('#phone').val();
                var email 	 = $('#email').val();
                var text     = $('#text').val();
                var langs    = "<?=$lang->get("LANG")?>";
				// the information sent
				$.ajax({
					url: "action.php", // where we send it
					type: "post", // transmission method
					dataType: "json", // Type of data transfer
					data: { // what we send
                        "name":  name,
                        "code":  code,
                        "phone": phone,
						"email": email,
                        "text":  text,
                        "langs": langs
					},
					// after receiving the server response
					success: function(data){
                        $('.messages').html(data.result); // output the server response
                        $('input').removeClass('app-form');
                        $('textarea').removeClass('app-form');
                        $('.field').removeClass('app-form');   
                        $('.formname').removeClass('app-form');
                        $('#wait').addClass('app-form');
                        $('#mes-img').removeClass('app-form');
                        $('#red').removeClass('app-form');
                        if (data.result == "<img src='img/cool.png' id='mes-img'> <br> <span style='color: #00ed95;' id='green'><?=$lang->get('SUCCESS')?>!</span>") {
                            $('input').addClass('app-form');
                            $('textarea').addClass('app-form');
                            $('.field').addClass('app-form');   
                            $('.formname').addClass('app-form');
                        }
					}
                });
			});
		});
    </script>
    <link rel="icon" href="img/logo-2-2.png">
    <!-- Checking the browser -->
    <script type="text/javascript">
        $(window).on('load', function(){
            // Opera 8.0+
            var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;

            // Firefox 1.0+
            var isFirefox = typeof InstallTrigger !== 'undefined';

            // Safari 3.0+ "[object HTMLElementConstructor]" 
            var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));

            // Internet Explorer 6-11
            var isIE = /*@cc_on!@*/false || !!document.documentMode;

            // Edge 20+
            var isEdge = !isIE && !!window.StyleMedia;

            // Chrome 1 - 71
            var isChrome = !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);

            if (isIE === true) {
                $('#IE').href="css/IE.css";
                $('.btn').addClass('menu-min');
                $('.btn').removeClass('from-middle');
                $('.btn').removeClass('btn');
            };
            /*if (isSafari === true) {
                alert("<?php echo getArticle(7)?>")
            };
            if ((isOpera === false) && (isFirefox === false) && (isIE === false) && (isEdge === false) && (isChrome === false) && (isSafari === false)) {
                alert("<?php echo getArticle(8)?>")
            }*/
        });
    </script>
    <script type="text/javascript">
        $(window).on('load', function () {
            var $preloader = $('#p_prldr'),
            $svg_anm = $preloader.find('.svg_anm');
            $svg_anm.fadeOut();
            $preloader.delay(0).fadeOut('slow');
        });
    </script>
</head>
<body>
<div id="p_prldr">
        <div class="contpre">
            <div class="loader">
                <div class="box"></div>
                <div class="box"></div>
                <div class="box"></div>
                <div class="box"></div>
                <div class="wrap-text">
                <span class="svg_anm">
                </span>
                </div>
            </div>
            <div class="loader-text">
                <?=$lang->get("LOADER")?>
            </div>
        </div>
    </div>
    <div id="body">
        <div id="roof">
            <div id="change-lang" class="lang-<?=$lang->get("CHANGE_LANG")?>" onClick="img()">
            </div>
            <div id="ro-logo">
            </div>
            <div id="theme" class="theme-big" onClick="theme()">
                <?=$lang->get("THEME")?>
            </div>
            <div id="nav">
                <div class = "button menu-button open-button"></div>
                <div class = "menu-block-1"></div>
                <div class = "menu-block-2"></div>
                <nav>
                    <ul id="menu-side">
                        <li id="menu-side-point" class = "menu-link-1 open-button"><a id="menu-side-link" href = "#division-1" class = "button menu-link-1 open-button"><?=$lang->get("MENU_MIN_WHO_WE")?></a></li>
                        <li id="menu-side-point" class = "menu-link-2 open-button"><a id="menu-side-link" href = "#division-2" class = "button menu-link-2 open-button"><?=$lang->get("MENU_MIN_WHAT_DO")?></a></li>
                        <li id="menu-side-point" class = "menu-link-3 open-button"><a id="menu-side-link" href = "#division-3" class = "button menu-link-3 open-button"><?=$lang->get("MENU_MIN_HAVE_PROJECT")?></a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div id="presentation" class="">
            <div class="content-item-none">
                <div class="overlay">
                </div>
                <div class="corner-overlay-content">
                    INFO
                </div>
                <div class="overlay-content">
                </div>
            </div>
        </div>        
        <div id="division-1">
            <a id="link" href="#division-1">
                <div class="btn from-middle">
                    <?=$lang->get("MENU_BIG_WHO_WE")?>
                </div>
            </a>
            <a id="link" href="#division-2">
                <div class="btn from-middle">
                    <?=$lang->get("MENU_BIG_SERVICES")?>
                </div>
            </a>
            <a id="link" href="#division-3">
                <div class="btn from-middle">
                    <?=$lang->get("MENU_BIG_CONTACTS")?>
                </div>
            </a>
            <div id="theme-2" class="theme-min" onClick="theme()">
                <?=$lang->get("THEME")?>
            </div>
        </div>
        <div id="content">
            <div id="fir-cont">
                <div id="fir-cont-img">
                </div>
                <div style="padding: 10px;">
                    <?php echo getArticle(1)?>
                </div>
            </div>
            <div id="division-2">
            </div>
            <div id="sec-cont">
                <div id="sec-cont-img">
                </div>
                <div style="padding: 10px;">
                    <?php echo getArticle(2)?>
                </div>
            </div>
        </div>
        <div id="division-3">
        </div>
        <div id="application">
            <div id="logo-down">
                <div id="logo-down-img">
                </div>
                <hr id="hr1">
            </div>
            <div id="hide">
                <article>
                    <div class="entry-thumb">
                        <div class="part part-1"></div>
                        <div class="part part-2"></div>
                        <div class="part part-3"></div>
                        <div class="part part-4"></div>
                        <ul class="share_bar">
                            <li style="padding-bottom: 0px; padding-left: 5px;">
                                <?php echo getArticle(5)?> →→→
                            </li> 
                        </ul>
                    </div>
                </article>
            </div>
            <hr id="hr2">
            <div id="app-form">
                <div id="wait" class="app-form">
                    <div id="wait-text">
                        <?=$lang->get("WAIT")?>...
                    </div>
                </div>
                <p id="app-text">
                    <?php echo getArticle(3)?>
                    <br>
                    <p id="app-text-2">
                        <?php echo getArticle(4)?>
                    </p>                    
                </p>
                <br>
                <div class="messages"></div>
                <input id="name" type="text" name="fio" title="<?=$lang->get("APP_FIO")?>" placeholder="<?=$lang->get("APP_FIO")?>" required autocomplete="off">
                <div class="field">
                    <input type="phone" id="phone" name="phone" title="<?=$lang->get("APP_PHONE")?>" placeholder="9990000000" required autocomplete="off" pattern="^[ 0-9]+$">                  
                </div>
                <input id="email" type="text" name="email" title="<?=$lang->get("APP_EMAIL")?>" placeholder="<?=$lang->get("APP_EMAIL")?>" required autocomplete="off">
                <textarea id="text" name="area" cols=”30” rows=”20” wrap=”on” title="<?=$lang->get("APP_PROJECT")?>" placeholder="<?=$lang->get("APP_PROJECT")?>" autocomplete="off" required></textarea>
                <div class="formname">
                    <label class="cb-label">
                        <input id="checkbox" class="cb pristine" type="checkbox" name="checkbox" onchange="document.getElementById('submit').disabled = !this.checked;">
                    </label>   
                    <span for="checkbox">
                        <?php echo getArticle(9)?>
                        <div class="container" style="display: inline;">
                            <a class="but-con js-click-modal">
                                <?php echo getArticle(10)?>
                            </a>
                            <div class="modal">
                                <div class="header" >
                                    <?php echo getArticle(11)?>
                                </div>
                                <div class="body">
                                    <p>
                                        <?php echo(file_get_contents('consent-'.$lang->get("LANG").'.html')); ?>
                                    </p>
                                </div>
                                <div class="close">
                                    <a class="btnn js-close-modal">
                                        <?=$lang->get("CONSENT")?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </span>
                    <input type="submit" disabled="disabled" name="submit" id="submit" value="<?=$lang->get("APP_BUTTON")?>">
                </div>  
            </div>
        </div>
        <div id="footer">
            <p id="foo-text">
                <sup>
                    ©
                </sup>
                ****** ****
            </p>
            <hr width="90%">
            <div id="problem">
                <?php echo getArticle(12)?>
                <br>
                <?php echo getArticle(13)?>
            </div>
        </div>
        <div class="progress-top"></div>
        <div class="progress-right"></div>
        <div class="progress-bottom"></div>
        <div class="progress-left"></div>
    </div>
    <!-- consent-->
    <div id="consent" class="">
        <div id="close">
        </div>
    </div>
    <!-- © - alt + 0169 -->
    <script type="text/javascript">
        
    </script>
    <script type="text/javascript">
    ///////////////////// Size of the privacy policy window////////////////////
        setInterval(sz, 100);
        function sz() {
            var hg = $(window).innerHeight();
            var ha = $('.header').height();
            hb = hg - ha - 120;
            $('.body').css('height', hb);
            $('.modal-open').css('height', hg);
        }
        $('.js-click-modal').click(function(){
            $('.modal').addClass('modal-open');
            $('html').addClass('html');
            $('.modal-open').css('height', hg);
        });
        $('.js-close-modal').click(function(){
            $('.modal').removeClass('modal-open');
            $('html').removeClass('html');
        });   
    </script>
</body>
</html>
