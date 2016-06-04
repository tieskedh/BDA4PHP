<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Funda</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<script>
        var kk;
        var ks;
        var totall;
        var bdp;
        var iz;
        var ip;
        var bez;
        var lenen;
        document.onclick = function () {
            kk = document.getElementById('kk');
            ks = document.getElementById('ks');
            bdp = document.getElementById('bdp');
            totall =document.getElementById('totall');
            iz =document.getElementById('iz');
            ip =document.getElementById('ip');
            bez =document.getElementById('bez');
            lenen = document.getElementById('lenen')
            ks.onkeyup = function up() {
                kk.value = parseInt(parseInt(ks.value) * 0.02);
                calctotall();
            }
            bdp.onkeyup = function test(){calctotall()};
            kk.onkeyup = function test(){calctotall()};
            iz.onkeyup = function test(){calctotall()};
            ip.onkeyup = function test(){calctotall()};
            bez.onkeyup = function test(){calctotall()};
        };

    function calctotall() {
        if(bdp.value=="") {
            bdp.value = "0";
        }
        if(iz.value=="") {
            iz.value = "0";
        }
        if(ip.value=="") {
            ip.value = "0";
        }
        if(bez.value=="") {
            bez.value = "0";
        }
        totall.value = parseInt(bdp.value)+parseInt(ks.value)+parseInt(kk.value);
        lenen.innerHTML  = (parseInt(iz.value)+parseInt(ip.value))*1.5+parseInt(bez.value);
    }
</script>
<body>
<div id="main">
<div id="details">
<table id="kenmerken">
    <tr>
        <th colspan="2">Stap 1. Wat kost je droomhuis?</th>
        <th colspan="2">Stap 2. Wat kan ik lenen?</th>
    </tr>
    <tr>
        <td>Koopsom huis</td>
        <td>€<input type="text" name="koopsom" id='ks'></td>
        <td>Bruto jaarinkomen</td>
        <td>€<input type="text" name="jaarinkomen" id="iz"></td>
    </tr>
    <tr>
        <td>Inschatting Kosten koper</td>
        <td>€<input type="text" name="kk" id="kk"></td>
        <td>Bruto jaarinkomen parttner</td>
        <td>€<input type="text" name="jaarinkomenPartner" id="ip"></td>
    </tr>
    <tr>
        <td>Bouwdepot</td>
        <td>€<input type="text" name="bouwdepot" id="bdp"></td>
        <td>eigen geld</td>
        <td>€<input type="text" name="cash" id="bez"></td>
    </tr>
    <tr>
        <td colspan="4">
            <hr/>
        </td>
    </tr>
    <tr>
        <td>TOTAAL</td>
        <td>€<input type="text" name="toaal" id="totall"></td>
        <td colspan="2" id="lenen"></td>
    </tr>
</table>
</div>
</div>
</body>
</html>