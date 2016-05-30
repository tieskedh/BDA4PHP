<? require 'header.php'; ?>
<?php
if (empty($_GET['WOID'])) {
    die('U bent op de verkeerdepagina beland');
} else {
    require_once 'DatabaseConnection.php';
    $statement = DatabaseConnection::getConnection()->prepare('SELECT Omschrijving, Address FROM WO WHERE WOID= :WOID');
    $statement->execute([':WOID'=>$_GET['WOID']]);
    $huis = $statement->fetch(PDO::FETCH_ASSOC);
}
?>
<div style="border: solid gray 1px; width: 600px; padding: 6px; margin-left: 30px;">
    <?= $huis['Omschrijving'] ?>
    <a href="detail.php?detailsOnly=true&WOID=<?=$_GET['WOID']?>">Alle kenmerken van <?= $huis['Address'] ?></a>
</div>

</body>
</html>
