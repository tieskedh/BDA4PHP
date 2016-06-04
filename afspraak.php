<?php
if (empty($_GET['WOID'])) {
    die('u bent op de verkeerde pagina beland');
} elseif (!isset($_POST['appointment'])) {
    $sql = "SELECT min(mkantoormdw.MKMDWID), date.Date, sessie_id, start, end
            FROM mkantoormdw
              INNER JOIN wo
                ON mkantoormdw.MKID = wo.MKID
              CROSS JOIN (
                           SELECT curdate() + INTERVAL (a+10*b) DAY AS Date
                           FROM (
                                  SELECT 0 AS a
                                  UNION ALL SELECT 1
                                  UNION ALL SELECT 2
                                  UNION ALL SELECT 3
                                  UNION ALL SELECT 4
                                  UNION ALL SELECT 5
                                  UNION ALL SELECT 6
                                  UNION ALL SELECT 7
                                  UNION ALL SELECT 8
                                  UNION ALL SELECT 9
                                ) AS innerdate
                                CROSS JOIN (
                                SELECT 0 AS b
                                  UNION ALL SELECT 1
                                  UNION ALL SELECT 2
                                  UNION ALL SELECT 3
                                  UNION ALL SELECT 4
                                  UNION ALL SELECT 5
                                  UNION ALL SELECT 6
                                  UNION ALL SELECT 7
                                  UNION ALL SELECT 8
                                  UNION ALL SELECT 9
                                ) AS innerdate2
                         ) AS date
              CROSS JOIN sessies
              LEFT JOIN afspraak
                ON afspraak.MKMDWID = mkantoormdw.MKMDWID
                   AND afspraak.datum = date.Date
                   AND afspraak.sessie = sessies.sessie_id
            WHERE afspraak.MKMDWID IS NULL
                  AND wo.WOID = :woid
            GROUP BY date, sessie_id
            LIMIT 5";
    require_once 'DatabaseConnection.php';
    require_once "Helper.php";
    $statement = DatabaseConnection::getConnection()->prepare($sql);
    $mogelijkheden = [];
    if ($statement->execute([':woid' => $_GET['WOID']])) {
        session_start();
        $nr = 0;
        while ($mogelijkheid = $statement->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['mogelijkheid'][$nr]['Date'] = $mogelijkheid['Date'];
            $_SESSION['mogelijkheid'][$nr]['session'] = $mogelijkheid['sessie_id'];
            $_SESSION['mogelijkheid'][$nr]['start'] = $mogelijkheid['start'];
            $_SESSION['mogelijkheid'][$nr]['end'] = $mogelijkheid['end'];
            $_SESSION['WOID'] = $_GET['WOID'];
            $mogelijkheden[$nr] = $mogelijkheid['Date'] . ' ' . $mogelijkheid['start'] . '-' . $mogelijkheid['end'].'.';
            $nr++;
        }
    } else {
        echo '<pre>' . $statement->queryString;
        echo print_r($statement->errorInfo());
    };
    if (empty($mogelijkheden)) {
        die("On this moment,you can't make an apointmant,try it later again");
    } else {
        echo "<form method='post'>";
        echo Helper::getDropDown('appointment', $mogelijkheden);
        echo '<input type="submit" value="verzenden">';
        echo '</form>';
    }
} else {
    session_start();
    $_SESSION['mogelijkheid']['nr'] = $mogelijkheid = $_POST['appointment']?>
    Weet u zeker dat u het volgende wilt afspreken:<br/>
    Datum: <?= $_SESSION['mogelijkheid'][$mogelijkheid]['Date'] ?><br/>
    starttijd: <?= $_SESSION['mogelijkheid'][$mogelijkheid]['start'] ?><br/>
    eindtijd: <?= $_SESSION['mogelijkheid'][$mogelijkheid]['end'] ?><br/>
    huis: <?= $_SESSION['WOID'] ?><br/>
    <form action="bevestig.php">
        <?php require_once 'Helper.php'?>
        <?=Helper::getCheckBox('confirmed', '1', '0') ?>
        <label for='confirmed'>Ik wil deze afspraak inplannen</label><br />
        <input type="submit" value="verzenden"/>
    </form>
<?php } ?>