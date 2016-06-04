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
        $medewerker = "(SELECT min(mkantoormdw.MKMDWID)
            FROM mkantoormdw
              INNER JOIN wo
                ON mkantoormdw.MKID = wo.MKID
              LEFT JOIN afspraak
                ON afspraak.MKMDWID = mkantoormdw.MKMDWID
            WHERE afspraak.MKMDWID IS NULL
            AND afspraak.datum = :datum
            AND afspraak.sessie =  :sessie
            AND wo.WOID = :WOID
            LIMIT 1) as a";
        $sql = "INSERT INTO afspraak (MKMDWID, WOID, sessie, datum) 
                VALUE (".$medewerker.", :WOID, :sessie, :datum)";
            require_once 'DatabaseConnection.php';
        $statement = DatabaseConnection::getConnection()->prepare($sql);
        echo '<pre>';
        print_r($_SESSION);
        try {
            $statement->execute([
                ':WOID' => $_SESSION['WOID'],
                ':sessie' => $_SESSION['mogelijkheid'][$_SESSION['mogelijkheid']['nr']]['session'],
                ':datum' => $_SESSION['mogelijkheid'][$_SESSION['mogelijkheid']['nr']]['Date']
            ]);
            echo $statement->queryString;
            $statement->debugDumpParams();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}