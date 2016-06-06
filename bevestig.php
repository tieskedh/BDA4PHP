<?php
/**
 * Created by PhpStorm.
 * User: thijs
 * Date: 1-6-2016
 * Time: 20:13
 */
if(!isset($_GET['confirmed'])) {
    die('u bent op de verkeerde pagina beland.');
} else {
    session_start();
    if($_GET['confirmed']==1) {
        require_once 'DatabaseConnection.php';

        $medewerker = "
            SELECT Name, MKMDWID
            FROM mkantoormdw
            WHERE MKMDWID = (
                  SELECT min(mk.MKMDWID)
                  FROM mkantoormdw as mk
                    LEFT JOIN afspraak
                      ON afspraak.MKMDWID = mk.MKMDWID
                         AND afspraak.datum = :datum
                         AND afspraak.sessie = :sessie
                  WHERE afspraak.MKMDWID IS NULL
                        AND mk.MKID =
                          (SELECT MKID FROM wo WHERE wo.WOID = :WOID)
                  LIMIT 1
            ) LIMIT 1";
        $statement = DatabaseConnection::getConnection()->prepare($medewerker);
        $params = [
            ':WOID' => $_SESSION['WOID'],
            ':sessie' => $_SESSION['mogelijkheid'][$_SESSION['mogelijkheid']['nr']]['session'],
            ':datum' => $_SESSION['mogelijkheid'][$_SESSION['mogelijkheid']['nr']]['Date']
        ];
        $statement->execute($params);
        if($statement->rowCount()==0) {
            die('Iemand anders heeft de pagina voor uw neus weggekaapt');
        };
        $medewerker = $statement->fetch(PDO::FETCH_ASSOC);
        $params[':medewerker'] = $medewerker['MKMDWID'];
        $sql = "INSERT INTO afspraak (MKMDWID, WOID, sessie, datum) 
                VALUE (:medewerker, :WOID, :sessie, :datum)";
        $statement = DatabaseConnection::getConnection()->prepare($sql);

        try {
            if($statement->execute($params)) {
                echo 'u hebt succesvol een afspraak gemaakt met '.$medewerker['Name'];
            } else {
                echo 'Probeer het later opnieuw';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}