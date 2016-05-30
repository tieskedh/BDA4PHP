<?php
if (empty($_GET['WOID'])) {
    die('sorry, you are at a wrong place');
} else {
    $sql = "SELECT SUBSTRING_INDEX(omschrijving,' ',30) AS omschrijving, 
                CONCAT_WS(' ', Vraagprijs, (SELECT Name FROM soortvraagprijs WHERE ID = wo.Vraagprijssoort)) AS VraagPrijs,
                (SELECT Name FROM soortobject WHERE wo.SoortObject = SoortObject.ID) AS SoortObject,
                (SELECT Name FROM soortwoning WHERE wo.SoortWoning = SoortWoning.Id) as SoortWoning,
                (SELECT Name FROM soortbouw WHERE wo.SoortBouw= soortbouw.Id) as SoortBouw,
                (SELECT Name FROM typewoning WHERE wo.TypeWoning = TypeWoning.ID) as TypeWoning,
                (SELECT NAME FROM status WHERE wo.Status = Status.Id) as Status,
                (CASE 
                    WHEN TuinAanwezig <> 0 THEN 'ja'
                    WHEN TuinAanwezig =  0 THEN 'Nee'
                    ELSE 'onbekend'
                  END) as  TuinAanwezig,
                CONCAT_WS(' ', PC, City) as Address2,
                BouwJaar,
                TuinOppervlakte, 
                WoonOppervlakte, 
                Inhoud,
                AantalKamers,
                AantalBadkamers,
                AantalWoonlagen,
                PerceelOppervlakte,
                PlaatsingDatum,
                Address
            FROM wo
            WHERE WOID = :woid
            ";
    require_once 'DatabaseConnection.php';
    try {
        $statement = DatabaseConnection::getConnection()->prepare($sql);
        $statement->execute([':woid' => $_GET['WOID']]);
        $huis = $statement->fetch(PDO::FETCH_ASSOC);
        $huis['WOID'] = $_GET['WOID'];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
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
<?php if(empty($_GET['detailsOnly']) || !$_GET['detailsOnly']): ?>

        <div id="balk">
            <ul>
                <li class="active">Woningaanbod</a></li>
                <li>Verkoop</li>
                <li>NVM Makelaars</li>
                <li>Gids</li>
                <li>Verhuizen</li>
                <li>My Funda</li>
            </ul>
        </div>

    <div id="main">
        <div id="adresgegevens">
            <div class="head"><?= $huis['Address'] ?></div>
            <div class="adres"><?= $huis['Address2'] ?></div>
            <div class="prijs"><?= $huis['VraagPrijs'] ?></div>
        </div>

        <div id="details">
        <ul>
            <li><a href="detail.php" class="active">Overzicht</a></li>
            <li><a href="omschrijving.php?<?=$huis['WOID']?>" class="licht">Omschrijving</a></li>
            <li><a href="detail.php?WOID=<?=$huis['WOID']?>&detailsOnly=true" class="licht">Kenmerken</a></li>
            <li><a href="hypotheek.php<?=$huis['WOID']?>" class="licht">Hypotheek</a></li>
            <li><a href="afspraak.php<?=$huis['WOID']?>" class="licht">Afspraak makelaar</a></li>

        </ul>

    <div id="content"><?= $huis['omschrijving'] ?>...
            <a href="omschrijving.php?WOID=<?= $huis['WOID'] ?>">Volledige omschrijving</a>
        <?php endif;?>

        <table id="kenmerken">
                <tr>
                    <th colspan="2">Kenmerken</th>
                </tr>

                <?php $kenmerken = [
                    'VraagPrijs'=>'vraagprijs',
                    'SoortObject'=>'soort object',
                    'SoortWoning'=>'soort woning',
                    'TypeWoning'=>'type woning',
                    'SoortBouw' =>'soort bouw',
                    'Address'=>'adres',
                    'Address2'=>'PC + woonplaats',
                    'BouwJaar'=>'bouwjaar',
                    'Status' =>'status',
                    'TuinAanwezig' => 'tuin aanwezig',
                    'TuinOppervlakte'=>'tuin oppervlakte',
                    'WoonOppervlakte' => 'woonoppervlakte',
                    'Inhoud' => 'inhoud',
                    'AantalKamers' => 'kamers',
                    'AantalBadkamers' => 'badkamers',
                    'AantalWoonlagen'=>'woonlagen',
                    'PerceelOppervlakte'=>'perceeloppervrlakte',
                    'PlaatsingDatum' => 'plaatsingsDatum'
                ];

                foreach ($kenmerken as $kenmerk => $value):?>
                    <tr>
                        <td class="kop"><?= $value ?></td>
                        <td><?= $huis[$kenmerk] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table >
        </div >
    </div >
</div >


</body >
</html >



