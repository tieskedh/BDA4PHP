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
        document.onclick = function () {
            kk = document.getElementById('kk');
            ks = document.getElementById('ks');
            bdp = document.getElementById('bdp');
            totall =document.getElementById('totall');
            ks.onkeyup = function up() {
                kk.value = parseInt(parseInt(ks.value) * 0.2);
                calctotall();
            }
        };

    function calctotall() {
        totall.value = parseInt(bdp)+parseInt(ks.value)+parseInt(kk.value);
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
        <td>€<input type="text" name="jaarinkomen"></td>
    </tr>
    <tr>
        <td>Inschatting Kosten koper</td>
        <td>€<input type="text" name="kk" id="kk"></td>
        <td>Bruto jaarinkomen parttner</td>
        <td>€<input type="text" name="jaarinkomenPartner"></td>
    </tr>
    <tr>
        <td>Bouwdepot</td>
        <td>€<input type="text" name="bouwdepot"></td>
        <td>eigen geld</td>
        <td>€<input type="text" name="cash"></td>
    </tr>
    <tr>
        <td colspan="4">
            <hr/>
        </td>
    </tr>
    <tr>
        <td>TOTAAL</td>
        <td>€<input type="text" name="toaal" id="totall"></td>
        <td>eigen geld</td>
        <td>€<input type="submit" value="reken uit"></td>
    </tr>
</table>
</div>
</div>
</body>
</html>