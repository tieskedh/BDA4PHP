<?php
session_start();
if(!empty($_SESSION['SortingVals'])) {
    $_SESSION['SortingVals'] = array_merge($_SESSION['SortingVals'], $_POST);
} else {
    $_SESSION['SortingVals'] = $_POST;
}
try {
    $select = "SELECT WOID, Vraagprijs, wo.Address AS Address, soortvraagprijs.Name AS Vraagprijs_soort, wo.City AS City, WoonOppervlakte, AantalKamers, mkantoor.Name AS Makelaar_naam, wo.PC AS PC ";
    $sql = "FROM wo
              left JOIN mkantoor
                ON wo.MKID =mkantoor.MKID
              left JOIN soortvraagprijs
                ON wo.Vraagprijssoort = soortvraagprijs.ID";

    $_POST = $_SESSION['SortingVals'];
    $wheres = array();
    $params = array();
    if (!empty($_POST['straatnaam']) || !empty($_POST['huisnummer']) || !empty($_POST['toevoeging'])) {
        $wheres[] = 'wo.Address like :address';
        $params[':address'] = (empty($_POST['straatnaam']) ? '%' : $_POST['straatnaam']) . " " . (empty($_POST['huisnummer']) ? '%' : $_POST['huisnummer']) . (!empty($_POST['toevoeging']) ? " " . $_POST['toevoeging'] : "");
    }
    if (!empty($_POST['postcode'])) {
        $wheres[] = 'wo.pc LIKE :postcode';
        $params[':postcode'] = $_POST['postcode'];
    }

    if (!empty($_POST['plaatsnaam'])) {
        $wheres[] = 'wo.City LIKE :city';
        $params[':city'] = $_POST['plaatsnaam'];
    }

    if(!empty($_POST['minPrijs'])) {
        $wheres[] = 'wo.vraagprijs >= :minPrijs';
        $params[':minPrijs'] = $_POST['minPrijs'];
    }

    if(!empty($_POST['maxPrijs'])) {
        $wheres[] = 'wo.vraagprijs <= :maxPrijs';
        $paramsp[':maxPrijs'] = $_POST['maxPrijs'];
    }


    if(!empty($_POST['object'])) {
        $wheres[] = 'wo.SoortObject = :object';
        $params[':object'] = $_POST['object'];
    }

    if(!empty($_POST['bouw'])) {
        $wheres[] = 'wo.SoortBouw = :bouw';
        $params[':bouw'] = $_POST['bouw'];
    }

    if (!empty($_POST['kamers'])) {
        $wheres[] = 'wo.AantalKamers = :kamers';
        $params[':kamers'] = $_POST['kamers'];
    }

    if (!empty($_POST['oppv'])) {
        $wheres[] = 'wo.WoonOppervlakte= :oppv';
        $params[':oppv'] = $_POST['oppv'];
    }




    if (!empty($wheres)) {
        $sql .= ' WHERE ';
        $sql .= implode(' AND ', $wheres);
    }
    $page = $_GET['page']??0;
    require_once 'DatabaseConnection.php';
    $limiting=' LIMIT 15 OFFSET '.(15*$page);
    echo $select.$sql.$limiting;
    print_r($params);
    $statement = DatabaseConnection::getConnection()->prepare($select.$sql.$limiting);

    if ($statement->execute($params)) {
        $huizen = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo '<pre>' . $statement->queryString;
        echo print_r($statement->errorInfo());
    };

    $count = 'select count(*) as xount ';
    $statement = DatabaseConnection::getConnection()->prepare($count.$sql);
    if ($statement->execute($params)) {
        $count = $statement->fetchColumn(0);
    } else {
        echo '<pre>' . $statement->queryString;
        echo print_r($statement->errorInfo());
    };


    $statement = DatabaseConnection::getConnection()->query('SELECT Name, ID FROM soortobject');
    $objects = [];
    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $objects[$row['ID']] = $row['Name'];
    }

    $statement = DatabaseConnection::getConnection()->query('SELECT Name, ID FROM soortbouw');
    $bouw = [];
    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $bouw[$row['ID']] = $row['Name'];
    }

} catch (PDOException $e) {
    echo $e->getMessage();
}

require_once 'Helper.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Funda</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>

<body>

<div id="logo">
    <img src="img/funda-logo-hp.gif" id="toplogo" alt="toplogo"/>
</div>


<div id="balk">
    <ul>
        <li class="active">Woningaanbod</li>
        <li>Verkoop</li>
        <li>NVM Makelaars</li>
        <li>Gids</li>
        <li>Verhuizen</li>
        <li>My Funda</li>
    </ul>
</div>

<div id="nav">
    <ul>
        <li><a href="index.php" class="active">Koopwoningen</a></li>
        <li>Huurwoningen</li>
        <li>Nieuwbouwprojecten</li>
        <li>Recreatiewoningen</li>
        <li>Europa</li>
    </ul>
</div>

<div id="txt">
    <?=$count?> koopwoningen gevonden
</div>

<div id="main">
        <table>
            <tr>
                <td id="data" valign="top">
                    <form method="post">
                    <div class="head">Prijsklasse van/tot<br/>
                        <input type="text" name="minPrijs" value="<?=$_POST['minPrijs']??''?>" placeholder="minimum"/>
                        <input type="text" name="maxPrijs" value="<?=$_POST['maxPrijs']??''?>"placeholder="maximum"/>
                    </div>
                    <div class="head">Soort object</div>
                    <div class="content">
                        <?=Helper::getDropDown("object", $objects??[], $_POST['object']??'');?>
                    </div>

                    <div class="head">Soort bouw:</div>
                    <div class="content">
                        <?=Helper::getDropDown('bouw', $bouw??[], $_POST['bouw']??'');?>
                    </div>

                    <div class="head">Aantal kamers</div>
                    <div class="content">
                        <input type="text" value="<?=$_POST['kamers']??''?>" name="kamers"/>
                    </div>

                    <div class="head">Woonoppervlakte</div>
                    <div class="content">
                        <input type="text" name="oppv" value="<?=$_POST['oppv']??''?>"/>
                    </div>
                    <input type="submit" value="filteren">
                    </form>
                </td>


                <td valign="top">
                    <?php foreach ($huizen as $huis): ?>
                        <div class="huisdata">
                            <div class="head"><a class="normal" href="detail.php?WOID=<?=$huis['WOID']?>">
                                    <?= $huis['Address'] ?></a></div>
                            <div class="prijs"><?= $huis['Vraagprijs'] . ' ' . $huis['Vraagprijs_soort'] ?></div>
                            <br/>
                                <span class="adres">
                                    <?= $huis['PC'] . " " . $huis['City'] ?><br/>
                                    <?= $huis['WoonOppervlakte'] ?>m<sup>2</sup> -
                                    <?= $huis['AantalKamers'] ?> kamers</span><br/>
                            <span><a class="makelaar" href="makelaar.php"><?= $huis['Makelaar_naam'] ?></a></span>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($huizen)): ?>
                        <div class="huisdata">
                            Sorry,geen huizen gevonden...
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?=Helper::getPagination('overzicht.php?page=', $count/15, $_GET['page']??0, 5);?>
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
