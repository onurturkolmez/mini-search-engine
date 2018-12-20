<html>
<head>
    <title>Mini Search Engine</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://www.google.com.tr/images/branding/product/ico/googleg_lodp.ico" rel="shortcut icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .tab-pane > h3 {
            text-align: center;
        }
    </style>
</head>
<body>
<div>

    <div class="container">
        <h2>Mini Search Engine</h2>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Count Keyword</a></li>
            <li><a data-toggle="tab" href="#menu1">Order Page Url</a></li>
            <li><a data-toggle="tab" href="#menu2">Order Page</a></li>
            <li><a data-toggle="tab" href="#menu3">Semantic Analysis</a></li>
        </ul>

        <div class="tab-content col-lg-9">
            <div id="home" class="tab-pane fade in active">
                <h3>Count Keyword</h3>
                <form action="search.php" method="post" id="form1">
                    <input type="hidden" name="searchType" value="1" />
                    <div class="form-group col-lg-6">
                        <label>Keyword:</label>
                        <input class="form-control" type="text" name="keyword" id="form1_keyword"/>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Url:</label>
                        <input class="form-control" type="text" name="url" id="form1_url"/>
                    </div>
                    <div class="form-group col-lg-12">
                        <input class="btn-block btn btn-primary" type="submit" value="Search"/>
                    </div>
                </form>
            </div>
            <div id="menu1" class="tab-pane fade">
                <h3>Sayfa Url Sıralama</h3>
                <form action="search.php" method="post" id="form2">
                    <input type="hidden" name="searchType" value="2" />
                    <div class="form-group col-lg-12" style="margin-bottom: 0px !important;">
                        <label>Anahtar Kelimeler:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="keyword" id="form2_keyword1"/>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="keyword2" id="form2_keyword2"/>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="keyword3" id="form2_keyword3"/>
                    </div>
                    <div class="form-group col-lg-12" style="margin-bottom: 0px !important;">
                        <label>Urller:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="url" id="form2_url"/>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="url2" id="form2_url2"/>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="url3" id="form2_url3"/>
                    </div>
                    <div class="form-group col-lg-12">
                        <input class="btn-block btn btn-primary" type="submit" value="Ara"/>
                    </div>
                </form>
            </div>
            <div id="menu2" class="tab-pane fade">
                <h3>Site Sıralama</h3>
                <form action="search.php" method="post" id="form3">
                    <input type="hidden" name="searchType" value="3" />
                    <div class="form-group col-lg-12" style="margin-bottom: 0px !important;">
                        <label>Anahtar Kelimeler:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="keyword" id="form3_keyword1"/>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="keyword2" id="form3_keyword2"/>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="keyword3" id="form3_keyword3"/>
                    </div>
                    <div class="form-group col-lg-12" style="margin-bottom: 0px !important;">
                        <label>Urller:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="url" id="form3_url"/>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="url2" id="form3_url2"/>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="url3" id="form3_url3"/>
                    </div>
                    <div class="form-group col-lg-12">
                        <input class="btn-block btn btn-primary" type="submit" value="Ara"/>
                    </div>
                </form>
            </div>
            <div id="menu3" class="tab-pane fade">
                <h3>Semantik Analiz</h3>
                <form action="search.php" method="post" id="form4">
                    <input type="hidden" name="searchType" value="4" />
                    <div class="form-group col-lg-12" style="margin-bottom: 0px !important;">
                        <label>Anahtar Kelimeler:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="keyword" id="form4_keyword1"/>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="keyword2" id="form4_keyword2"/>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="keyword3" id="form4_keyword3"/>
                    </div>
                    <div class="form-group col-lg-12" style="margin-bottom: 0px !important;">
                        <label>Urller:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="url" id="form4_url"/>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="url2"/>
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="text" name="url3"/>
                    </div>
                    <div class="form-group col-lg-12">
                        <input class="btn-block btn btn-primary" type="submit" value="Ara"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("#form1").on("submit",function (event) {

        var url = document.getElementById('form1_url');

        if($("#form1_keyword").val() == ""){
           alert("The keyword cannot be empty");
           return false;
       }

       if(!url.value.startsWith("https") && !url.value.startsWith("http")){

          if(url.value.startsWith("www")){
            url.value = "http://" + url.value;
          }

          else{
            alert("Wrong Url Format");
            return false;
          }
       }

        return true;
    });

    $("#form2").on("submit",function (event) {

        var url = $("#form2_url").val();
        var url2 = $("#form2_url2").val();
        var url3 = $("#form2_url3").val();

        if($("#form2_keyword1").val() == "" && $("#form2_keyword2").val() == "" && $("#form2_keyword3").val() == ""){
            alert("Anahtar Kelime Boş Olamaz");
            return false;
        }

        if(!url.startsWith("https") && !url.startsWith("http")){
            alert("Yanlış Url Formatı");
            return false;
        }

        if(!url2.startsWith("https") && !url2.startsWith("http")){
            alert("Yanlış Url Formatı");
            return false;
        }

        if(!url3.startsWith("https") && !url3.startsWith("http")){
            alert("Yanlış Url Formatı");
            return false;
        }

        return true;
    });

    $("#form3").on("submit",function (event) {

        var url = $("#form3_url").val();

        if($("#form3_keyword1").val() == "" && $("#form3_keyword2").val() == "" && $("#form3_keyword3").val() == ""){
            alert("Anahtar Kelime Boş Olamaz");
            return false;
        }

        if(!url.startsWith("https") && !url.startsWith("http")){
            alert("Yanlış Url Formatı");
            return false;
        }

        return true;
    });

    $("#form4").on("submit",function (event) {

        var url = $("#form4_url").val();

        if($("#form4_keyword1").val() == "" && $("#form4_keyword2").val() == "" && $("#form4_keyword3").val() == ""){
            alert("Anahtar Kelime Boş Olamaz");
            return false;
        }

        if(!url.startsWith("https") && !url.startsWith("http")){
            alert("Yanlış Url Formatı");
            return false;
        }

        return true;
    });
</script>
</body>
</html>
