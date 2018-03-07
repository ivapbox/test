<?
    define("NOT_SHOW_TITLE", 1);
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
    $APPLICATION->SetPageProperty("title",
                                  "Санкт-Петербургский Дом Книги - Книжный интернет-магазин - купить книги онлайн с доставкой по России, а также сувениры, уникальные издания, изделия для творчества, аудиокниги, канцтовары и игрушки для детей");
    $APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");

    if (isset($_GET['sortprice'])) {
        CHTTP::SetStatus('404 Not found');
    }
?>

<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=vggYtcD04k3Zeltg3yItUKngHlPkblC5XFwRE4FwegMk7m/5c6H9eyYHZ/ErBMDwSiLogmQCWX38LD25c3RYOtr6oR8MJg6PAuDZ5qV9XhHRTL3Nk1/*X6Hdq6BSSZz6ebA/gUg7D/MBJYnbXnRhj48uFly79QuvW5*PW1a7ya4-';</script>

<style>
    .salesale {
        padding: 2px 0 10px 0 !important;
        width: 61px !important;
        height: 32px !important;
        border: none ! important;
    }

    .salesale:hover {
        background-color: #fff !important;
    }
</style>
<!--<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">-->
<!--<p style="text-align: center;">
    Уважаемые Покупатели! Время доставки курьером интернет-заказов может быть увеличено. Приносим свои извинения за возможные неудобства.
</p>-->

<ul class="tabs">
    <li>
        <a class="salesale" href="#sale">
            <img style="position: absolute;" src="<?=SITE_TEMPLATE_PATH;?>/images/sale.png">
        </a>
    </li>
    <li id="new_tab" class="active">
        <a href="#new">Новинки</a>
    </li>
    <!--<li>
        <a href="#excl">Эксклюзивы</a>
    </li>-->
    <li>
        <a href="#news">Новости</a>
    </li>
    <li id="dk95menu">
        <a href="#dk95">Дому Книги - 95!</a>
    </li>
    <li id="pres">
        <a href="#present">Что подарить</a>
    </li>
    <!--<li id="predzak">
        <a href="#predzakaz">Доступен предзаказ</a>
    </li>-->
    <!--<li><a href="#coupon">Купон</a></li>-->
</ul>

<script>

    (function ($) {

        $.fn.onVisible = function (callback) {
            var self = this;
            var selector = this.selector;

            if (jQuery.css(self, "display") != "none") {
                callback.call(self);
            } else {
                timer = setInterval(function () {
                    if (jQuery.css(selector, "display") != "none") {
                        callback.call($(selector));
                        clearInterval(timer);
                    }
                }, 50);
            }
        }
    }(jQuery));
    $('.addition_section').onVisible(function () {
        $('.addition_section').slick({
            infinite: true,
            dots: true,
            draggable: false,
            speed: 300,
            slidesToShow: 5,
            slidesToScroll: 5,
            lazyLoad: 'progressive'
        });
    });


</script>

<div class="pill-content">
    <div id="new" class="active">
        <?
            $APPLICATION->IncludeComponent(
                "dz:books.new_different",
                "",
                Array(
                    "CNT"        => "8",
                    "CACHE_TIME" => "3000",
                    "ADDITION"   => array()
                ),
                false
            );
            $APPLICATION->IncludeComponent("dz:events.current", "index", Array("IBLOCK_ID"  => "16",
                                                                               "PAGINATION" => 10), false);
        ?>
    </div>

    <div id="sale">
        <? $APPLICATION->IncludeComponent("dz:sale", "", Array("ACTION"         => 1058725,
                                                               "GOODS_PER_PAGE" => 25,
                                                               "PAGE"           => 1,
                                                               "NAME"           => "ВСЕ ПО 50"), false); ?>
    </div>

    <div id="dk95">
        <?
            $APPLICATION->IncludeComponent("dz:unilist", "dk95-4", Array("AJAX_MODE" => "Y",
                                                                         "IBLOCK_ID" => 33), false);
        ?>
    </div>


    <div id="news">
        <?
            $APPLICATION->IncludeComponent("dz:news", "web20", array(
                "IBLOCK_TYPE"                     => "news",
                "IBLOCK_ID"                       => "26",
                "NEWS_COUNT"                      => "20",
                "USE_SEARCH"                      => "N",
                "TAGS_CLOUD_ELEMENTS"             => "150",
                "PERIOD_NEW_TAGS"                 => "",
                "USE_RSS"                         => "N",
                "USE_RATING"                      => "N",
                "USE_CATEGORIES"                  => "N",
                "USE_FILTER"                      => "N",
                "SORT_BY1"                        => "ACTIVE_FROM",
                "SORT_ORDER1"                     => "DESC",
                "SORT_BY2"                        => "SORT",
                "SORT_ORDER2"                     => "ASC",
                "CHECK_DATES"                     => "Y",
                "SEF_MODE"                        => "Y",
                "SEF_FOLDER"                      => "/news/",
                "AJAX_MODE"                       => "Y",
                "AJAX_OPTION_JUMP"                => "Y",
                "AJAX_OPTION_STYLE"               => "Y",
                "AJAX_OPTION_HISTORY"             => "N",
                "CACHE_TYPE"                      => "A",
                "CACHE_TIME"                      => "36000000",
                "CACHE_FILTER"                    => "N",
                "CACHE_GROUPS"                    => "Y",
                "SET_TITLE"                       => "Y",
                "SET_STATUS_404"                  => "N",
                "INCLUDE_IBLOCK_INTO_CHAIN"       => "Y",
                "ADD_SECTIONS_CHAIN"              => "Y",
                "USE_PERMISSIONS"                 => "N",
                "PREVIEW_TRUNCATE_LEN"            => "",
                "LIST_ACTIVE_DATE_FORMAT"         => "d.m.Y",
                "LIST_FIELD_CODE"                 => array(
                    0 => "",
                    1 => "",
                ),
                "LIST_PROPERTY_CODE"              => array(
                    0 => "",
                    1 => "",
                ),
                "HIDE_LINK_WHEN_NO_DETAIL"        => "Y",
                "DISPLAY_NAME"                    => "Y",
                "META_KEYWORDS"                   => "-",
                "META_DESCRIPTION"                => "-",
                "BROWSER_TITLE"                   => "NAME",
                "DETAIL_ACTIVE_DATE_FORMAT"       => "d.m.Y",
                "DETAIL_FIELD_CODE"               => array(
                    0 => "",
                    1 => "",
                ),
                "DETAIL_PROPERTY_CODE"            => array(
                    0 => "",
                    1 => "",
                ),
                "DETAIL_DISPLAY_TOP_PAGER"        => "N",
                "DETAIL_DISPLAY_BOTTOM_PAGER"     => "Y",
                "DETAIL_PAGER_TITLE"              => "Страница",
                "DETAIL_PAGER_TEMPLATE"           => "",
                "DETAIL_PAGER_SHOW_ALL"           => "Y",
                "DISPLAY_TOP_PAGER"               => "N",
                "DISPLAY_BOTTOM_PAGER"            => "Y",
                "PAGER_TITLE"                     => "Новости",
                "PAGER_SHOW_ALWAYS"               => "Y",
                "PAGER_TEMPLATE"                  => "",
                "PAGER_DESC_NUMBERING"            => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL"                  => "Y",
                "DISPLAY_DATE"                    => "Y",
                "DISPLAY_PICTURE"                 => "Y",
                "DISPLAY_PREVIEW_TEXT"            => "Y",
                "DISPLAY_AS_RATING"               => "vote_avg",
                "FONT_MAX"                        => "50",
                "FONT_MIN"                        => "10",
                "COLOR_NEW"                       => "3E74E6",
                "COLOR_OLD"                       => "C0C0C0",
                "TAGS_CLOUD_WIDTH"                => "100%",
                "USE_SHARE"                       => "N",
                "AJAX_OPTION_ADDITIONAL"          => "",
                "SEF_URL_TEMPLATES"               => array(
                    "news"    => "",
                    "section" => "",
                    "detail"  => "#ELEMENT_ID#/",
                )
            ), false
            );
        ?>
    </div>


    <div id="present" style="width: 720px;">
        <?
            $APPLICATION->IncludeComponent("dz:what_present", "", array(), false);

        ?>
    </div>

    <!--<div id="excl">
        <?/*
            $APPLICATION->IncludeComponent(
                "dz:section", "index", Array("ROOT"       => 'fiction',
                                             "SECTION"    => 25611,
                                             "PAGE"       => 1,
                                             "PAGINATION" => 8,
                                             "CNT"        => "16",
                                             "SORTBY"     => "rand"), false
            );
        */?>
        <div class="spbdk-red-devider"></div>
        <br class="cc"/>

        <div>
            <?/* $APPLICATION->IncludeComponent("dz:element", "main", array("ID" => 975579), false); */?>
        </div>
    </div>-->

    <div id="coupon">
        <?
            $APPLICATION->IncludeComponent("dz:coupons", "", array("IBLOCK_ID" => "24",
                                                                   "ORDER"     => array("ACTIVE_FROM" => "DESC"),
                                                                   "FILTER"    => array("ACTIVE"      => "Y",
                                                                                        "ACTIVE_DATE" => "Y"),), false);
        ?>
    </div>
    <div id="predzakaz">
        <div class="row">
            <div class="span8" style="width: 100%!important;">
                <div class="row">
                    <div class="span8">
                        <h4>
                            <strong>
                                <a href="#">Мата Хари шпионка</a>
                            </strong>
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="span2" style="width: 250px!important;">
                        <a href="#popup1" class="thumbnail">
                            <img style="width: 190px; padding-left: 30px" src="http://www.spbdk.ru/upload/medialibrary/072/MataHari.jpg" alt="MataHari">
                        </a><br/>
                        <div id="price_presale" style="clear: both; padding: 20px;">
                            <p class="eshop-price" style="color: #AE1414;!important; font-size: 30px;!important; text-align: center;">556 руб</p>
                        </div>
                    </div>
                    <div class="span6" style="width: 56%!important;">
                        <h4><strong><a href="#">Автор:Паоло Коэльо</a></strong></h4>
                        <p>
                            От детства в маленьком голландском городке и брака с алкоголиком на Яве — к покорению Парижа,
                            куда Мата Хари приехала без денег и где вскоре приобрела славу одной из самых элегантных женщин эпохи,
                            — всю жизнь Мата Хари следовала своей правде, всегда была честна с собой и свободна от предрассудков
                            и шаблонных истин. Она дорого за это заплатила. Пауло Коэлъо с блистательным мастерством
                            погружается в жизнь этой удивительной женщины и воскрешает ее для современных читателей как
                            живой пример того, что даже самые высокие деревья берут начало в маленьком зернышке.
                        </p>
                        <div class="box">
                            <a class="button" href="#popup1" id="potter">Оформить предзаказ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <!--<div class="row">
            <div class="span8" style="width: 100%!important;">
                <div class="row">
                    <div class="span8">
                        <h4><strong><a href="#">Лампа Мафусаила, или Крайняя битва чекистов с масонами</a></strong></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="span2" style="width: 250px!important;">
                        <a href="popup3" class="thumbnail">
                            <img style="width: 210px; padding-left: 30px" src="http://www.spbdk.ru/upload/medialibrary/d0d/pelevin_.jpg" alt="">
                        </a><br/>
                        <div id="price_presale" style="clear: both; padding: 20px;">
                            <p class="eshop-price" style="color: #AE1414;!important; font-size: 30px;!important; text-align: center;">649 руб</p>
                        </div>
                    </div>
                    <div class="span6" style="width: 56%!important;">
                        <h4><strong><a href="popup3">Автор : Виктор Пелевин</a></strong></h4>
                        <p>
                            Как известно, сложное международное положение нашей страны объясняется острым
                            конфликтом российского руководства с мировым масонством. Но мало кому понятны
                            корни этого противостояния, его финансовая подоплека и оккультный смысл.
                            Гибридный роман В. Пелевина срывает покровы молчания с этой тайны, попутно
                            разъясняя в простой и доступной форме главные вопросы мировой политики,
                            экономики, культуры и антропогенеза. В центре повествования - три поколения дворянской
                            семьи Можайских, служащие Отчизне в 19, 20 и 21 веках.
                        </p>
                        <div class="box">
                            <a class="button" href="#popup3">Оформить предзаказ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>-->

        <!--<div class="row">
            <div class="span8" style="width: 100%!important;">
                <div class="row">
                    <div class="span8">
                        <h4><strong><a href="#">Две встречи в париже.</a></strong></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="span2" style="width: 250px!important;">
                        <a id="paris_img" href="#popup2" class="thumbnail">
                            <img style="width: 210px; padding-left: 30px" src="http://www.spbdk.ru/upload/medialibrary/986/978-5-389-11260-5__3D.JPG" alt="">
                        </a><br/>
                        <div id="price_presale" style="clear: both; padding: 20px;">
                            <p class="eshop-price" style="color: #AE1414;!important; font-size: 30px;!important; text-align: center;">456 руб.</p>
                        </div>
                    </div>
                    <div class="span6" style="width: 56%!important;">
                        <h4><strong><a href="#">Автор : Джоджо Мойес</a></strong></h4>
                        <p>
                            В книгу входят две повести.
                            «Медовый месяц в Париже» – это предыстория событий, которые разворачиваются в романе
                            Мойес «Девушка, которую ты покинул». Лив и Софи разделяют почти сто лет, но они обе стоят
                            на пороге семейной жизни, обе надеются на счастливый медовый месяц с любимым мужчиной...
                            «Одна в Париже» – это рассказ о Нелл, скромной и любящей все просчитывать заранее.
                            Однако она мечтает провести романтический уик-энд со своим другом в Париже, а потому
                            по собственной инициативе организует такую поездку. Но ее друг не является на вокзал,
                            и Нелл едет в Париж одна. Она решает доказать себе, что способна на авантюры.
                            Во французской столице Нелл знакомится с загадочным мотоциклистом Фабианом и его бесшабашными друзьями…
                            Впервые на русском языке!
                        </p>
                        <div class="box">
                            <a class="button" href="#popup2" id="paris_button">Оформить предзаказ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <!--<hr>-->
    </div>
    <script type="text/javascript">

    </script>
    <br class="cc"/>
    <br class="cc"/>
</div>
<br class="cc"/>

<?
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>

