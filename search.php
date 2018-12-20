<html>
<head>
    <title>Arama Sonucu</title>
    <link href="https://www.google.com.tr/images/branding/product/ico/googleg_lodp.ico" rel="shortcut icon">
    <style>
        p {
            padding: 0;
            margin: 0;
        }
    </style>
</head>
<body style="background: #607D8B;margin-top: 10px;">
<div style="color:white;">
    <p>Sonuçlar</p>
    <a style="float: right;" href="index.php">Ana Sayfaya Dön</a>
    <?php
    ini_set('max_execution_time', 360);
    error_reporting(E_ALL);
    header('Content-Type: text/html; charset=utf-8');
    libxml_use_internal_errors(true);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $type = $_POST['searchType'];

        switch ($type) {

            //Count Keyword
            case  '1':

                $keyword = $_POST['keyword'];
                $url = $_POST['url'];
                $keywordArray = array();
                reviewKeyword($keyword, $keywordArray);

                $file = file_get_contents($url);
                $html = new DOMDocument();
                $html->loadHTML(mb_convert_encoding($file, 'HTML-ENTITIES', "UTF-8"));
                libxml_clear_errors();

                $count = 0;

                foreach ($html->getElementsByTagName('*') as $a) {
                    $property = $a->nodeValue;
                    $count += searchInKeywords($property, $keywordArray);
                }

                echo $keyword . " the keyword includes " . $count . " times in " . $url . " page";
                break;

            //sayfa(url) sıralama
            case '2':

                $htmlText = "";

                $url = $_POST['url'];
                $url2 = $_POST['url2'];
                $url3 = $_POST['url3'];

                $keyword = $_POST['keyword'];
                $keywordArray = array();
                reviewKeyword($keyword, $keywordArray);

                $keyword2 = $_POST['keyword2'];
                $keywordArray2 = array();
                reviewKeyword($keyword2, $keywordArray2);

                $keyword3 = $_POST['keyword3'];
                $keywordArray3 = array();
                reviewKeyword($keyword3, $keywordArray3);

                $file = file_get_contents($url);
                $html = new DOMDocument();
                $html->loadHTML(mb_convert_encoding($file, 'HTML-ENTITIES', "UTF-8"));
                libxml_clear_errors();

                $score1 = 0;
                $score2 = 0;
                $score3 = 0;
                $count = 0;
                $count2 = 0;
                $count3 = 0;

                foreach ($html->getElementsByTagName('*') as $a) {
                    $property = $a->nodeValue;
                    $count += searchInKeywords($property, $keywordArray);
                    $count2 += searchInKeywords($property, $keywordArray2);
                    $count3 += searchInKeywords($property, $keywordArray3);
                }

                $total = $count + $count2 + $count3;
                $score1 = (($count + 1) / ($total + 1)) * (($count2 + 1) / ($total + 1)) * (($count3 + 1) / ($total + 1)) * 10000;

                $htmlText .= $url . ' sayfası için;<br>' . $keyword . ' anahtar kelimesi ' . $count . ' kez,'
                    . $keyword2 . ' anahtar kelimesi ' . $count2 . ' kez,' . $keyword3 . ' anahtar kelimesi ise ' . $count3
                    . ' kez geçiyor.<br>Puanı ise ' . intval($score1) . "<br><br>";


                $file = file_get_contents($url2);
                $html = new DOMDocument();
                $html->loadHTML(mb_convert_encoding($file, 'HTML-ENTITIES', "UTF-8"));
                libxml_clear_errors();
                $count = 0;
                $count2 = 0;
                $count3 = 0;

                foreach ($html->getElementsByTagName('*') as $a) {
                    $property = $a->nodeValue;
                    $count += searchInKeywords($property, $keywordArray);
                    $count2 += searchInKeywords($property, $keywordArray2);
                    $count3 += searchInKeywords($property, $keywordArray3);
                }

                $total = $count + $count2 + $count3;
                $score2 = (($count + 1) / ($total + 1)) * (($count2 + 1) / ($total + 1)) * (($count3 + 1) / ($total + 1)) * 10000;

                $htmlText .= $url2 . " sayfası için;<br>" . $keyword . " anahtar kelimesi " . $count . " kez,"
                    . $keyword2 . " anahtar kelimesi " . $count2 . " kez," . $keyword3 . " anahtar kelimesi ise " . $count3
                    . " kez geçiyor.<br>Puanı ise " . intval($score2) . "<br><br>";

                $file = file_get_contents($url3);
                $html = new DOMDocument();
                $html->loadHTML(mb_convert_encoding($file, 'HTML-ENTITIES', "UTF-8"));
                $count = 0;
                $count2 = 0;
                $count3 = 0;

                foreach ($html->getElementsByTagName('*') as $a) {
                    $property = $a->nodeValue;
                    $count += searchInKeywords($property, $keywordArray);
                    $count2 += searchInKeywords($property, $keywordArray2);
                    $count3 += searchInKeywords($property, $keywordArray3);
                }

                $total = $count + $count2 + $count3;
                $score3 = (($count + 1) / ($total + 1)) * (($count2 + 1) / ($total + 1)) * (($count3 + 1) / ($total + 1)) * 10000;

                $htmlText .= $url3 . " sayfası için;<br>" . $keyword . " anahtar kelimesi " . $count . " kez,"
                    . $keyword2 . " anahtar kelimesi " . $count2 . " kez," . $keyword3 . " anahtar kelimesi ise " . $count3
                    . " kez geçiyor.<br>Puanı ise " . intval($score3);

                $first = 0;
                $second = 0;
                $third = 0;
                if ($score1 > $score2) {
                    $first = $score1;
                    $second = $score2;
                } else {
                    $first = $score2;
                    $second = $score1;
                }

                if ($first > $score3) {
                    if ($second > $score3) {
                        $third = $score3;
                    }
                } else {
                    $third = $second;
                    $second = $third;
                    $first = $score3;
                }

                echo $htmlText;
                echo "<br>Site Sıralamaları<br>" . " " . intval($first) . " puan<br>"
                    . " " . intval($second) . " puan<br>"
                    . " " . intval($third) . " puan<br><br>";
                break;

            //site sıralama
            case '3':
                $htmlText = "";

                $url = $_POST['url'];
                $url = change_https_to_http_vol2($url);

                $url2 = $_POST['url2'];
                $useUrl2 = true;
                if ($url2 == "")
                    $useUrl2 = false;
                else
                    $url2 = change_https_to_http_vol2($url2);

                $url3 = $_POST['url3'];
                $useUrl3 = true;
                if ($url3 == "")
                    $useUrl3 = false;
                else
                    $url3 = change_https_to_http_vol2($url3);

                $keyword = $_POST['keyword'];
                $keywordArray = array();
                reviewKeyword($keyword, $keywordArray);

                $keyword2 = $_POST['keyword2'];
                $keywordArray2 = array();
                reviewKeyword($keyword2, $keywordArray2);

                $keyword3 = $_POST['keyword3'];
                $keywordArray3 = array();
                reviewKeyword($keyword3, $keywordArray3);

                $htmlTreeStructureText = "<p style='color: darkred;'>" . $url . " için ağaç yapısı;<p>";

                $file = file_get_contents($url);
                $html = new DOMDocument();
                $html->loadHTML(mb_convert_encoding($file, 'HTML-ENTITIES', "UTF-8"));
                libxml_clear_errors();
                $score1 = 0;
                $score2 = 0;
                $score3 = 0;
                $count = 0;
                $count2 = 0;
                $count3 = 0;

                //derinlik 1
                foreach ($html->getElementsByTagName('*') as $a) {
                    $property = $a->nodeValue;
                    $count += searchInKeywords($property, $keywordArray);
                    $count2 += searchInKeywords($property, $keywordArray2);
                    $count3 += searchInKeywords($property, $keywordArray3);
                }

                $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url . "</span> sayfası için;<br>" . $keyword .
                    " anahtar kelimesi " . $count . " kez," . $keyword2 . " anahtar kelimesi " . $count2 . " kez,"
                    . $keyword3 . " anahtar kelimesi ise " . $count3 . " kez geçiyor.<p>";

                //derinlik 2
                foreach ($html->getElementsByTagName('a') as $a) {

                    $property = $a->getAttribute('href');
                    $property = change_https_to_http($property);

                    if ($property != '#' && $property != '/' && str_starts_with($property, $url)) {

                        $deepUrl = $property;

                        $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url .
                            "</span> -> <span style='color: #00BCD4;'>" . $deepUrl . "</span> düğümü için<p>";

                        $file2 = file_get_contents($deepUrl);
                        $html2 = new DOMDocument();
                        $html2->loadHTML(mb_convert_encoding($file2, 'HTML-ENTITIES', "UTF-8"));
                        libxml_clear_errors();
                        $tempCount = 0;
                        $tempCount2 = 0;
                        $tempCount3 = 0;

                        foreach ($html2->getElementsByTagName('*') as $a2) {
                            $property2 = $a2->nodeValue;

                            $count += searchInKeywords($property2, $keywordArray);
                            $tempCount += searchInKeywords($property2, $keywordArray);

                            $count2 += searchInKeywords($property2, $keywordArray2);
                            $tempCount2 += searchInKeywords($property2, $keywordArray2);

                            $count3 += searchInKeywords($property2, $keywordArray3);
                            $tempCount3 += searchInKeywords($property2, $keywordArray3);
                        }

                        $htmlTreeStructureText .= $keyword . " anahtar kelimesi " . $tempCount . " kez,"
                            . $keyword2 . " anahtar kelimesi " . $tempCount2 . " kez," . $keyword3 . " anahtar kelimesi ise " .
                            $tempCount3 . " kez geçiyor.<br>";


                        foreach ($html2->getElementsByTagName('a') as $a2) {
                            $property2 = $a2->getAttribute('href');
                            $property2 = change_https_to_http($property2);

                            if ($property2 != '#' && $property2 != '/' && str_starts_with($property2, $url)) {

                                $deepUrl2 = $property2;

                                $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url .
                                    "</span> -> <span style='color: #00BCD4;'>" . $deepUrl . "</span> -> <span style='color: black;'>"
                                    . $deepUrl2 . "</span> düğümü için<p>";

                                $file3 = file_get_contents($deepUrl2);
                                $html3 = new DOMDocument();
                                $html3->loadHTML(mb_convert_encoding($file3, 'HTML-ENTITIES', "UTF-8"));
                                libxml_clear_errors();

                                $tempCount = 0;
                                $tempCount2 = 0;
                                $tempCount3 = 0;

                                //derinlik 3
                                foreach ($html3->getElementsByTagName('*') as $a3) {
                                    $property3 = $a3->nodeValue;

                                    $count += searchInKeywords($property3, $keywordArray);
                                    $tempCount += searchInKeywords($property3, $keywordArray);

                                    $count2 += searchInKeywords($property3, $keywordArray2);
                                    $tempCount2 += searchInKeywords($property3, $keywordArray2);

                                    $count3 += searchInKeywords($property3, $keywordArray3);
                                    $tempCount3 += searchInKeywords($property3, $keywordArray3);
                                }

                                $htmlTreeStructureText .= $keyword . " anahtar kelimesi " . $tempCount . " kez,"
                                    . $keyword2 . " anahtar kelimesi " . $tempCount2 . " kez," . $keyword3 . " anahtar kelimesi ise " .
                                    $tempCount3 . " kez geçiyor.<br>";
                            }
                        }
                    }
                }

                $total = $count + $count2 + $count3;
                $score1 = (($count + 1) / ($total + 1)) * (($count2 + 1) / ($total + 1)) * (($count3 + 1) / ($total + 1)) * 10000;
                $htmlText .= $url . " sayfası için toplamda;<br>" . $keyword . " anahtar kelimesi " . $count . " kez,"
                    . $keyword2 . " anahtar kelimesi " . $count2 . " kez," . $keyword3 . " anahtar kelimesi ise " . $count3
                    . " kez geçiyor.<br>Puanı ise " . intval($score1) . "<br>";


                //url 2 için
                if ($useUrl2) {
                    $htmlTreeStructureText .= "<p style='color: darkred;'>" . $url2 . " için ağaç yapısı;<p>";

                    $file = file_get_contents($url2);
                    $html = new DOMDocument();
                    $html->loadHTML(mb_convert_encoding($file, 'HTML-ENTITIES', "UTF-8"));
                    libxml_clear_errors();
                    $count = 0;
                    $count2 = 0;
                    $count3 = 0;

                    //derinlik 1
                    foreach ($html->getElementsByTagName('*') as $a) {
                        $property = $a->nodeValue;
                        $count += searchInKeywords($property, $keywordArray);
                        $count2 += searchInKeywords($property, $keywordArray2);
                        $count3 += searchInKeywords($property, $keywordArray3);
                    }

                    $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url2 . "</span> sayfası için;<br>" . $keyword .
                        " anahtar kelimesi " . $count . " kez," . $keyword2 . " anahtar kelimesi " . $count2 . " kez,"
                        . $keyword3 . " anahtar kelimesi ise " . $count3 . " kez geçiyor.<p>";

                    //derinlik 2
                    foreach ($html->getElementsByTagName('a') as $a) {

                        $property = $a->getAttribute('href');
                        $property = change_https_to_http($property);

                        if ($property != '#' && $property != '/' && str_starts_with($property, $url2)) {

                            $deepUrl = $property;

                            $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url2 .
                                "</span> -> <span style='color: #00BCD4;'>" . $deepUrl . "</span> düğümü için<p>";

                            $file2 = file_get_contents($deepUrl);
                            $html2 = new DOMDocument();
                            $html2->loadHTML(mb_convert_encoding($file2, 'HTML-ENTITIES', "UTF-8"));
                            libxml_clear_errors();
                            $tempCount = 0;
                            $tempCount2 = 0;
                            $tempCount3 = 0;

                            foreach ($html2->getElementsByTagName('*') as $a2) {
                                $property2 = $a2->nodeValue;

                                $count += searchInKeywords($property2, $keywordArray);
                                $tempCount += searchInKeywords($property2, $keywordArray);

                                $count2 += searchInKeywords($property2, $keywordArray2);
                                $tempCount2 += searchInKeywords($property2, $keywordArray2);

                                $count3 += searchInKeywords($property2, $keywordArray3);
                                $tempCount3 += searchInKeywords($property2, $keywordArray3);
                            }

                            $htmlTreeStructureText .= $keyword . " anahtar kelimesi " . $tempCount . " kez,"
                                . $keyword2 . " anahtar kelimesi " . $tempCount2 . " kez," . $keyword3 . " anahtar kelimesi ise " .
                                $tempCount3 . " kez geçiyor.<br>";


                            foreach ($html2->getElementsByTagName('a') as $a2) {
                                $property2 = $a2->getAttribute('href');
                                $property2 = change_https_to_http($property2);

                                if ($property2 != '#' && $property2 != '/' && str_starts_with($property2, $url2)) {

                                    $deepUrl2 = $property2;

                                    $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url2 .
                                        "</span> -> <span style='color: #00BCD4;'>" . $deepUrl . "</span> -> <span style='color: black;'>"
                                        . $deepUrl2 . "</span> düğümü için<p>";

                                    $file3 = file_get_contents($deepUrl2);
                                    $html3 = new DOMDocument();
                                    $html3->loadHTML(mb_convert_encoding($file3, 'HTML-ENTITIES', "UTF-8"));
                                    libxml_clear_errors();

                                    $tempCount = 0;
                                    $tempCount2 = 0;
                                    $tempCount3 = 0;

                                    //derinlik 3
                                    foreach ($html3->getElementsByTagName('*') as $a3) {
                                        $property3 = $a3->nodeValue;

                                        $count += searchInKeywords($property3, $keywordArray);
                                        $tempCount += searchInKeywords($property3, $keywordArray);

                                        $count2 += searchInKeywords($property3, $keywordArray2);
                                        $tempCount2 += searchInKeywords($property3, $keywordArray2);

                                        $count3 += searchInKeywords($property3, $keywordArray3);
                                        $tempCount3 += searchInKeywords($property3, $keywordArray3);
                                    }

                                    $htmlTreeStructureText .= $keyword . " anahtar kelimesi " . $tempCount . " kez,"
                                        . $keyword2 . " anahtar kelimesi " . $tempCount2 . " kez," . $keyword3 . " anahtar kelimesi ise " .
                                        $tempCount3 . " kez geçiyor.<br>";
                                }
                            }
                        }
                    }

                    $total = $count + $count2 + $count3;
                    $score2 = (($count + 1) / ($total + 1)) * (($count2 + 1) / ($total + 1)) * (($count3 + 1) / ($total + 1)) * 10000;
                    $htmlText .= $url2 . " sayfası için toplamda;<br>" . $keyword . " anahtar kelimesi " . $count . " kez,"
                        . $keyword2 . " anahtar kelimesi " . $count2 . " kez," . $keyword3 . " anahtar kelimesi ise " . $count3
                        . " kez geçiyor.<br>Puanı ise " . intval($score2) . "<br>";
                }

                //url 3 için
                if ($useUrl3) {
                    $htmlTreeStructureText .= "<p style='color: darkred;'>" . $url3 . " için ağaç yapısı;<p>";

                    $file = file_get_contents($url3);
                    $html = new DOMDocument();
                    $html->loadHTML(mb_convert_encoding($file, 'HTML-ENTITIES', "UTF-8"));
                    libxml_clear_errors();
                    $count = 0;
                    $count2 = 0;
                    $count3 = 0;

                    //derinlik 1
                    foreach ($html->getElementsByTagName('*') as $a) {
                        $property = $a->nodeValue;
                        $count += searchInKeywords($property, $keywordArray);
                        $count2 += searchInKeywords($property, $keywordArray2);
                        $count3 += searchInKeywords($property, $keywordArray3);
                    }

                    $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url3 . "</span> sayfası için;<br>" . $keyword .
                        " anahtar kelimesi " . $count . " kez," . $keyword2 . " anahtar kelimesi " . $count2 . " kez,"
                        . $keyword3 . " anahtar kelimesi ise " . $count3 . " kez geçiyor.<p>";

                    //derinlik 2
                    foreach ($html->getElementsByTagName('a') as $a) {

                        $property = $a->getAttribute('href');
                        $property = change_https_to_http($property);

                        if ($property != '#' && $property != '/' && str_starts_with($property, $url3)) {

                            $deepUrl = $property;

                            $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url3 .
                                "</span> -> <span style='color: #00BCD4;'>" . $deepUrl . "</span> düğümü için<p>";

                            $file2 = file_get_contents($deepUrl);
                            $html2 = new DOMDocument();
                            $html2->loadHTML(mb_convert_encoding($file2, 'HTML-ENTITIES', "UTF-8"));
                            libxml_clear_errors();
                            $tempCount = 0;
                            $tempCount2 = 0;
                            $tempCount3 = 0;

                            foreach ($html2->getElementsByTagName('*') as $a2) {
                                $property2 = $a2->nodeValue;

                                $count += searchInKeywords($property2, $keywordArray);
                                $tempCount += searchInKeywords($property2, $keywordArray);

                                $count2 += searchInKeywords($property2, $keywordArray2);
                                $tempCount2 += searchInKeywords($property2, $keywordArray2);

                                $count3 += searchInKeywords($property2, $keywordArray3);
                                $tempCount3 += searchInKeywords($property2, $keywordArray3);

                            }

                            $htmlTreeStructureText .= $keyword . " anahtar kelimesi " . $tempCount . " kez,"
                                . $keyword2 . " anahtar kelimesi " . $tempCount2 . " kez," . $keyword3 . " anahtar kelimesi ise " .
                                $tempCount3 . " kez geçiyor.<br>";


                            foreach ($html2->getElementsByTagName('a') as $a2) {
                                $property2 = $a2->getAttribute('href');
                                $property2 = change_https_to_http($property2);

                                if ($property2 != '#' && $property2 != '/' && str_starts_with($property2, $url3)) {

                                    $deepUrl2 = $property2;

                                    $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url3 .
                                        "</span> -> <span style='color: #00BCD4;'>" . $deepUrl . "</span> -> <span style='color: black;'>"
                                        . $deepUrl2 . "</span> düğümü için<p>";

                                    $file3 = file_get_contents($deepUrl2);
                                    $html3 = new DOMDocument();
                                    $html3->loadHTML(mb_convert_encoding($file3, 'HTML-ENTITIES', "UTF-8"));
                                    libxml_clear_errors();

                                    $tempCount = 0;
                                    $tempCount2 = 0;
                                    $tempCount3 = 0;

                                    //derinlik 3
                                    foreach ($html3->getElementsByTagName('*') as $a3) {
                                        $property3 = $a3->nodeValue;

                                        $count += searchInKeywords($property3, $keywordArray);
                                        $tempCount += searchInKeywords($property3, $keywordArray);

                                        $count2 += searchInKeywords($property3, $keywordArray2);
                                        $tempCount2 += searchInKeywords($property3, $keywordArray2);

                                        $count3 += searchInKeywords($property3, $keywordArray3);
                                        $tempCount3 += searchInKeywords($property3, $keywordArray3);
                                    }

                                    $htmlTreeStructureText .= $keyword . " anahtar kelimesi " . $tempCount . " kez,"
                                        . $keyword2 . " anahtar kelimesi " . $tempCount2 . " kez," . $keyword3 . " anahtar kelimesi ise " .
                                        $tempCount3 . " kez geçiyor.<br>";
                                }
                            }
                        }
                    }

                    $total = $count + $count2 + $count3;
                    $score3 = (($count + 1) / ($total + 1)) * (($count2 + 1) / ($total + 1)) * (($count3 + 1) / ($total + 1)) * 10000;
                    $htmlText .= $url3 . " sayfası için toplamda;<br>" . $keyword . " anahtar kelimesi " . $count . " kez,"
                        . $keyword2 . " anahtar kelimesi " . $count2 . " kez," . $keyword3 . " anahtar kelimesi ise " . $count3
                        . " kez geçiyor.<br>Puanı ise " . intval($score3) . "<br>";
                }

                echo $htmlText;

                if ($useUrl2 && $useUrl3) {
                    $first = 0;
                    $second = 0;
                    $third = 0;
                    if ($score1 > $score2) {
                        $first = $score1;
                        $second = $score2;
                    } else {
                        $first = $score2;
                        $second = $score1;
                    }

                    if ($first > $score3) {
                        if ($second > $score3) {
                            $third = $score3;
                        }
                    } else {
                        $third = $second;
                        $second = $third;
                        $first = $score3;
                    }
                    echo "<br>Site Sıralamaları<br>" . " " . intval($first) . " puan<br>"
                        . " " . intval($second) . " puan<br>"
                        . " " . intval($third) . " puan<br><br>";
                }

                echo "<div style='margin-top: 20px;height: 200px;overflow-y: scroll;overflow-x: hidden'><p>Ağaç Yapısı</p>" .
                    $htmlTreeStructureText . "</div>";

                break;

            //semantik analiz
            case '4':
                $htmlText = "";

                $url = $_POST['url'];
                $url = change_https_to_http_vol2($url);

                $url2 = $_POST['url2'];
                $useUrl2 = true;
                if ($url2 == "")
                    $useUrl2 = false;
                else
                    $url2 = change_https_to_http_vol2($url2);

                $url3 = $_POST['url3'];
                $useUrl3 = true;
                if ($url3 == "")
                    $useUrl3 = false;
                else
                    $url3 = change_https_to_http_vol2($url3);

                $keyword = $_POST['keyword'];
                $keywordArray = array();
                reviewKeyword($keyword, $keywordArray);
                semantikKelimeler($keyword, $keywordArray);

                $keyword2 = $_POST['keyword2'];
                $keywordArray2 = array();
                reviewKeyword($keyword2, $keywordArray2);
                semantikKelimeler($keyword2, $keywordArray2);

                $keyword3 = $_POST['keyword3'];
                $keywordArray3 = array();
                reviewKeyword($keyword3, $keywordArray3);
                semantikKelimeler($keyword3, $keywordArray3);

                $htmlTreeStructureText = "<p style='color: darkred;'>" . $url . " için ağaç yapısı;<p>";

                $file = file_get_contents($url);
                $html = new DOMDocument();
                $html->loadHTML(mb_convert_encoding($file, 'HTML-ENTITIES', "UTF-8"));
                libxml_clear_errors();
                $score1 = 0;
                $score2 = 0;
                $score3 = 0;
                $count = 0;
                $count2 = 0;
                $count3 = 0;

                //derinlik 1
                foreach ($html->getElementsByTagName('*') as $a) {
                    $property = $a->nodeValue;
                    $count += searchInKeywords($property, $keywordArray);
                    $count2 += searchInKeywords($property, $keywordArray2);
                    $count3 += searchInKeywords($property, $keywordArray3);
                }

                $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url . "</span> sayfası için;<br>" . $keyword .
                    " anahtar kelimesi " . $count . " kez," . $keyword2 . " anahtar kelimesi " . $count2 . " kez,"
                    . $keyword3 . " anahtar kelimesi ise " . $count3 . " kez geçiyor.<p>";

                //derinlik 2
                foreach ($html->getElementsByTagName('a') as $a) {

                    $property = $a->getAttribute('href');
                    $property = change_https_to_http($property);

                    if ($property != '#' && $property != '/' && str_starts_with($property, $url)) {

                        $deepUrl = $property;

                        $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url .
                            "</span> -> <span style='color: #00BCD4;'>" . $deepUrl . "</span> düğümü için<p>";

                        $file2 = file_get_contents($deepUrl);
                        $html2 = new DOMDocument();
                        $html2->loadHTML(mb_convert_encoding($file2, 'HTML-ENTITIES', "UTF-8"));
                        libxml_clear_errors();
                        $tempCount = 0;
                        $tempCount2 = 0;
                        $tempCount3 = 0;

                        foreach ($html2->getElementsByTagName('*') as $a2) {
                            $property2 = $a2->nodeValue;

                            $count += searchInKeywords($property2, $keywordArray);
                            $tempCount += searchInKeywords($property2, $keywordArray);

                            $count2 += searchInKeywords($property2, $keywordArray2);
                            $tempCount2 += searchInKeywords($property2, $keywordArray2);

                            $count3 += searchInKeywords($property2, $keywordArray3);
                            $tempCount3 += searchInKeywords($property2, $keywordArray3);
                        }

                        $htmlTreeStructureText .= $keyword . " anahtar kelimesi " . $tempCount . " kez,"
                            . $keyword2 . " anahtar kelimesi " . $tempCount2 . " kez," . $keyword3 . " anahtar kelimesi ise " .
                            $tempCount3 . " kez geçiyor.<br>";


                        foreach ($html2->getElementsByTagName('a') as $a2) {
                            $property2 = $a2->getAttribute('href');
                            $property2 = change_https_to_http($property2);

                            if ($property2 != '#' && $property2 != '/' && str_starts_with($property2, $url)) {

                                $deepUrl2 = $property2;

                                $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url .
                                    "</span> -> <span style='color: #00BCD4;'>" . $deepUrl . "</span> -> <span style='color: black;'>"
                                    . $deepUrl2 . "</span> düğümü için<p>";

                                $file3 = file_get_contents($deepUrl2);
                                $html3 = new DOMDocument();
                                $html3->loadHTML(mb_convert_encoding($file3, 'HTML-ENTITIES', "UTF-8"));
                                libxml_clear_errors();

                                $tempCount = 0;
                                $tempCount2 = 0;
                                $tempCount3 = 0;

                                //derinlik 3
                                foreach ($html3->getElementsByTagName('*') as $a3) {
                                    $property3 = $a3->nodeValue;

                                    $count += searchInKeywords($property3, $keywordArray);
                                    $tempCount += searchInKeywords($property3, $keywordArray);

                                    $count2 += searchInKeywords($property3, $keywordArray2);
                                    $tempCount2 += searchInKeywords($property3, $keywordArray2);

                                    $count3 += searchInKeywords($property3, $keywordArray3);
                                    $tempCount3 += searchInKeywords($property3, $keywordArray3);
                                }

                                $htmlTreeStructureText .= $keyword . " anahtar kelimesi " . $tempCount . " kez,"
                                    . $keyword2 . " anahtar kelimesi " . $tempCount2 . " kez," . $keyword3 . " anahtar kelimesi ise " .
                                    $tempCount3 . " kez geçiyor.<br>";
                            }
                        }
                    }
                }

                $total = $count + $count2 + $count3;
                $score1 = (($count + 1) / ($total + 1)) * (($count2 + 1) / ($total + 1)) * (($count3 + 1) / ($total + 1)) * 10000;
                $htmlText .= $url . " sayfası için toplamda;<br>" . $keyword . " anahtar kelimesi " . $count . " kez,"
                    . $keyword2 . " anahtar kelimesi " . $count2 . " kez," . $keyword3 . " anahtar kelimesi ise " . $count3
                    . " kez geçiyor.<br>Puanı ise " . intval($score1) . "<br>";

                //url2 için
                if ($useUrl2) {
                    $htmlTreeStructureText .= "<p style='color: darkred;'>" . $url2 . " için ağaç yapısı;<p>";

                    $file = file_get_contents($url2);
                    $html = new DOMDocument();
                    $html->loadHTML(mb_convert_encoding($file, 'HTML-ENTITIES', "UTF-8"));
                    libxml_clear_errors();
                    $count = 0;
                    $count2 = 0;
                    $count3 = 0;

                    //derinlik 1
                    foreach ($html->getElementsByTagName('*') as $a) {
                        $property = $a->nodeValue;
                        $count += searchInKeywords($property, $keywordArray);
                        $count2 += searchInKeywords($property, $keywordArray2);
                        $count3 += searchInKeywords($property, $keywordArray3);
                    }

                    $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url2 . "</span> sayfası için;<br>" . $keyword .
                        " anahtar kelimesi " . $count . " kez," . $keyword2 . " anahtar kelimesi " . $count2 . " kez,"
                        . $keyword3 . " anahtar kelimesi ise " . $count3 . " kez geçiyor.<p>";

                    //derinlik 2
                    foreach ($html->getElementsByTagName('a') as $a) {

                        $property = $a->getAttribute('href');
                        $property = change_https_to_http($property);

                        if ($property != '#' && $property != '/' && str_starts_with($property, $url2)) {

                            $deepUrl = $property;

                            $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url2 .
                                "</span> -> <span style='color: #00BCD4;'>" . $deepUrl . "</span> düğümü için<p>";

                            $file2 = file_get_contents($deepUrl);
                            $html2 = new DOMDocument();
                            $html2->loadHTML(mb_convert_encoding($file2, 'HTML-ENTITIES', "UTF-8"));
                            libxml_clear_errors();
                            $tempCount = 0;
                            $tempCount2 = 0;
                            $tempCount3 = 0;

                            foreach ($html2->getElementsByTagName('*') as $a2) {
                                $property2 = $a2->nodeValue;

                                $count += searchInKeywords($property2, $keywordArray);
                                $tempCount += searchInKeywords($property2, $keywordArray);

                                $count2 += searchInKeywords($property2, $keywordArray2);
                                $tempCount2 += searchInKeywords($property2, $keywordArray2);

                                $count3 += searchInKeywords($property2, $keywordArray3);
                                $tempCount3 += searchInKeywords($property2, $keywordArray3);
                            }

                            $htmlTreeStructureText .= $keyword . " anahtar kelimesi " . $tempCount . " kez,"
                                . $keyword2 . " anahtar kelimesi " . $tempCount2 . " kez," . $keyword3 . " anahtar kelimesi ise " .
                                $tempCount3 . " kez geçiyor.<br>";


                            foreach ($html2->getElementsByTagName('a') as $a2) {
                                $property2 = $a2->getAttribute('href');
                                $property2 = change_https_to_http($property2);

                                if ($property2 != '#' && $property2 != '/' && str_starts_with($property2, $url2)) {

                                    $deepUrl2 = $property2;

                                    $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url2 .
                                        "</span> -> <span style='color: #00BCD4;'>" . $deepUrl . "</span> -> <span style='color: black;'>"
                                        . $deepUrl2 . "</span> düğümü için<p>";

                                    $file3 = file_get_contents($deepUrl2);
                                    $html3 = new DOMDocument();
                                    $html3->loadHTML(mb_convert_encoding($file3, 'HTML-ENTITIES', "UTF-8"));
                                    libxml_clear_errors();

                                    $tempCount = 0;
                                    $tempCount2 = 0;
                                    $tempCount3 = 0;

                                    //derinlik 3
                                    foreach ($html3->getElementsByTagName('*') as $a3) {
                                        $property3 = $a3->nodeValue;

                                        $count += searchInKeywords($property3, $keywordArray);
                                        $tempCount += searchInKeywords($property3, $keywordArray);

                                        $count2 += searchInKeywords($property3, $keywordArray2);
                                        $tempCount2 += searchInKeywords($property3, $keywordArray2);

                                        $count3 += searchInKeywords($property3, $keywordArray3);
                                        $tempCount3 += searchInKeywords($property3, $keywordArray3);
                                    }

                                    $htmlTreeStructureText .= $keyword . " anahtar kelimesi " . $tempCount . " kez,"
                                        . $keyword2 . " anahtar kelimesi " . $tempCount2 . " kez," . $keyword3 . " anahtar kelimesi ise " .
                                        $tempCount3 . " kez geçiyor.<br>";
                                }
                            }
                        }
                    }

                    $total = $count + $count2 + $count3;
                    $score2 = (($count + 1) / ($total + 1)) * (($count2 + 1) / ($total + 1)) * (($count3 + 1) / ($total + 1)) * 10000;
                    $htmlText .= $url2 . " sayfası için toplamda;<br>" . $keyword . " anahtar kelimesi " . $count . " kez,"
                        . $keyword2 . " anahtar kelimesi " . $count2 . " kez," . $keyword3 . " anahtar kelimesi ise " . $count3
                        . " kez geçiyor.<br>Puanı ise " . intval($score2) . "<br>";
                }

                //url 3 için
                if ($useUrl3) {
                    $htmlTreeStructureText .= "<p style='color: darkred;'>" . $url3 . " için ağaç yapısı;<p>";

                    $file = file_get_contents($url3);
                    $html = new DOMDocument();
                    $html->loadHTML(mb_convert_encoding($file, 'HTML-ENTITIES', "UTF-8"));
                    libxml_clear_errors();
                    $count = 0;
                    $count2 = 0;
                    $count3 = 0;

                    //derinlik 1
                    foreach ($html->getElementsByTagName('*') as $a) {
                        $property = $a->nodeValue;
                        $count += searchInKeywords($property, $keywordArray);
                        $count2 += searchInKeywords($property, $keywordArray2);
                        $count3 += searchInKeywords($property, $keywordArray3);
                    }

                    $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url3 . "</span> sayfası için;<br>" . $keyword .
                        " anahtar kelimesi " . $count . " kez," . $keyword2 . " anahtar kelimesi " . $count2 . " kez,"
                        . $keyword3 . " anahtar kelimesi ise " . $count3 . " kez geçiyor.<p>";

                    //derinlik 2
                    foreach ($html->getElementsByTagName('a') as $a) {

                        $property = $a->getAttribute('href');
                        $property = change_https_to_http($property);

                        if ($property != '#' && $property != '/' && str_starts_with($property, $url3)) {

                            $deepUrl = $property;

                            $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url3 .
                                "</span> -> <span style='color: #00BCD4;'>" . $deepUrl . "</span> düğümü için<p>";

                            $file2 = file_get_contents($deepUrl);
                            $html2 = new DOMDocument();
                            $html2->loadHTML(mb_convert_encoding($file2, 'HTML-ENTITIES', "UTF-8"));
                            libxml_clear_errors();
                            $tempCount = 0;
                            $tempCount2 = 0;
                            $tempCount3 = 0;

                            foreach ($html2->getElementsByTagName('*') as $a2) {
                                $property2 = $a2->nodeValue;

                                $count += searchInKeywords($property2, $keywordArray);
                                $tempCount += searchInKeywords($property2, $keywordArray);

                                $count2 += searchInKeywords($property2, $keywordArray2);
                                $tempCount2 += searchInKeywords($property2, $keywordArray2);

                                $count3 += searchInKeywords($property2, $keywordArray3);
                                $tempCount3 += searchInKeywords($property2, $keywordArray3);

                            }

                            $htmlTreeStructureText .= $keyword . " anahtar kelimesi " . $tempCount . " kez,"
                                . $keyword2 . " anahtar kelimesi " . $tempCount2 . " kez," . $keyword3 . " anahtar kelimesi ise " .
                                $tempCount3 . " kez geçiyor.<br>";


                            foreach ($html2->getElementsByTagName('a') as $a2) {
                                $property2 = $a2->getAttribute('href');
                                $property2 = change_https_to_http($property2);

                                if ($property2 != '#' && $property2 != '/' && str_starts_with($property2, $url3)) {

                                    $deepUrl2 = $property2;

                                    $htmlTreeStructureText .= "<p><span style='color: #FFC107;'>" . $url3 .
                                        "</span> -> <span style='color: #00BCD4;'>" . $deepUrl . "</span> -> <span style='color: black;'>"
                                        . $deepUrl2 . "</span> düğümü için<p>";

                                    $file3 = file_get_contents($deepUrl2);
                                    $html3 = new DOMDocument();
                                    $html3->loadHTML(mb_convert_encoding($file3, 'HTML-ENTITIES', "UTF-8"));
                                    libxml_clear_errors();

                                    $tempCount = 0;
                                    $tempCount2 = 0;
                                    $tempCount3 = 0;

                                    //derinlik 3
                                    foreach ($html3->getElementsByTagName('*') as $a3) {
                                        $property3 = $a3->nodeValue;

                                        $count += searchInKeywords($property3, $keywordArray);
                                        $tempCount += searchInKeywords($property3, $keywordArray);

                                        $count2 += searchInKeywords($property3, $keywordArray2);
                                        $tempCount2 += searchInKeywords($property3, $keywordArray2);

                                        $count3 += searchInKeywords($property3, $keywordArray3);
                                        $tempCount3 += searchInKeywords($property3, $keywordArray3);
                                    }

                                    $htmlTreeStructureText .= $keyword . " anahtar kelimesi " . $tempCount . " kez,"
                                        . $keyword2 . " anahtar kelimesi " . $tempCount2 . " kez," . $keyword3 . " anahtar kelimesi ise " .
                                        $tempCount3 . " kez geçiyor.<br>";
                                }
                            }
                        }
                    }

                    $total = $count + $count2 + $count3;
                    $score3 = (($count + 1) / ($total + 1)) * (($count2 + 1) / ($total + 1)) * (($count3 + 1) / ($total + 1)) * 10000;
                    $htmlText .= $url3 . " sayfası için toplamda;<br>" . $keyword . " anahtar kelimesi " . $count . " kez,"
                        . $keyword2 . " anahtar kelimesi " . $count2 . " kez," . $keyword3 . " anahtar kelimesi ise " . $count3
                        . " kez geçiyor.<br>Puanı ise " . intval($score3) . "<br>";
                }


                echo $htmlText;

                echo "<div style='margin-top: 20px;'>Semantik Kelimeler<br>" . semantikKelimeriDondur($keyword) . "<br>"
                    . semantikKelimeriDondur($keyword2) .
                    "<br>" . semantikKelimeriDondur($keyword3) . "</div>";

                if ($useUrl2 && $useUrl3) {
                    $first = 0;
                    $second = 0;
                    $third = 0;
                    if ($score1 > $score2) {
                        $first = $score1;
                        $second = $score2;
                    } else {
                        $first = $score2;
                        $second = $score1;
                    }

                    if ($first > $score3) {
                        if ($second > $score3) {
                            $third = $score3;
                        }
                    } else {
                        $third = $second;
                        $second = $third;
                        $first = $score3;
                    }
                    echo "<br>Site Sıralamaları<br>" . " " . intval($first) . " puan<br>"
                        . " " . intval($second) . " puan<br>"
                        . " " . intval($third) . " puan<br><br>";
                }

                echo "<div style='margin-top: 20px;height: 200px;overflow-y: scroll;overflow-x: hidden'><p>Ağaç Yapısı</p>" .
                    $htmlTreeStructureText . "</div>";


                break;

        }
    } else {
        header('Location:index.php');
        exit;
    }

    //keyword için semantik ve o kelimeye yakın kelimelerden oluşan dizi için,html içeriğinde
    //olup olmadığını kontrol eder.
    function searchInKeywords($haystack, $needle, $offset = 0)
    {
        $count = 0;
        if (!is_array($needle)) $needle = array($needle);
        foreach ($needle as $query) {
            if (strpos($haystack, $query, $offset) !== false) {
                $count++;
            }
        }
        return $count;
    }

    //büyük küçük harf çevrimi,türkçe karakterler yerine ingilizce karakterli,
    //ingilizce karakterler yerine türkçe karakterli kelimenin benzerlerinin bir diziye atıldığı fonksiyondur
    function reviewKeyword($text, &$newArray)
    {
        //array_push($newArray, $text);
        array_push($newArray, ucfirst($text));
        array_push($newArray, lcfirst($text));

        if (strpos($text, 'ü')) {
            $temp = $text;
            $temp = str_replace('ü', 'u', $temp);
            array_push($newArray, $temp);
        }
        if (strpos($text, 'u')) {
            $temp = $text;
            $temp = str_replace('u', 'ü', $temp);
            array_push($newArray, $temp);
        }
        if (strpos($text, 'i')) {
            $temp = $text;
            $temp = str_replace('i', 'ı', $temp);
            array_push($newArray, $temp);
        }
        if (strpos($text, 'ı')) {
            $temp = $text;
            $temp = str_replace('ı', 'i', $temp);
            array_push($newArray, $temp);
        }
        if (strpos($text, 'ö')) {
            $temp = $text;
            $temp = str_replace('ö', 'o', $temp);
            array_push($newArray, $temp);
        }
        if (strpos($text, 'o')) {
            $temp = $text;
            $temp = str_replace('o', 'ö', $temp);
            array_push($newArray, $temp);
        }
        if (strpos($text, 'ş')) {
            $temp = $text;
            $temp = str_replace('ş', 's', $temp);
            array_push($newArray, $temp);
        }
    }

    //json dosyasındaki semantik kelimeleri o keyword için diziye atar
    function semantikKelimeler($text, &$textArray)
    {
        $json = file_get_contents("keywords.json");
        $jsonArray = json_decode($json, true);
        if (!isset($jsonArray[$text])) {

        } else {
            foreach ($jsonArray[$text] as $semantik) {
                array_push($textArray, $semantik);
            }
        }
    }

    //o keyword için varolan semantik kelimeleri döndürür
    function semantikKelimeriDondur($text)
    {
        $json = file_get_contents("keywords.json");
        $jsonArray = json_decode($json, true);

        $semantikText = "";

        if (!isset($jsonArray[$text])) {
            $semantikText = $text . " anahtar kelimesi için semantik kelime yok.";
        } else {
            $semantikText = $text . " anahar kelimesi için semantik kelimeler<br>";
            foreach ($jsonArray[$text] as $semantik) {
                $semantikText .= $semantik . "<br>";
            }
        }

        return $semantikText;
    }

    //keyword aranan sayfalardaki linkler girilen url adresi ile eşleşiğ eşleşmediğini kontrol eder.
    function str_starts_with($haystack, $needle)
    {
        return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
    }

    //sayfanın içeriğindeki url'lerde (derinlik kısmı için) https ile başlayan url'ler http'ye çevrilir
    //eğer http ile başlıyor orjinal hali döndürülür
    //https ve ya http ile başlamıyorsa # şeklinde döndürülür ve bir sonraki if engeline takılarak
    //o sayfanın içeriğine bakılmaz.
    function change_https_to_http($text)
    {
        $filename_ = explode("://", $text)[0];
        if ($filename_ == "https")
            return str_replace('https', 'http', $text);
        if ($filename_ == "http")
            return $text;

        return "#";
    }

    //girilen url'deki https ile başlayan siteleri http'ye çevirir.
    function change_https_to_http_vol2($text)
    {
        $filename_ = explode("://", $text)[0];
        if ($filename_ == "https")
            return str_replace('https', 'http', $text);
        if ($filename_ == "http")
            return $text;
    }

    ?>

</div>
</body>
</html>
