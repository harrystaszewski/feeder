<?php
if ($_POST['tweet']) {
    require_once('classes/class.appsettings.php');
    require_once('classes/class.dbmanager.php');
    $appsettings = AppSettings::getInstance();
    $dbCon = DBManager::getDBDriver($appsettings->getDBDriver());
    $enabled = ($_POST['enabled']) ? 1 : 0;
    $sql = "SELECT MAX(tweet_display_count) AS 'max_display_count'
        FROM tweets";
    $result = $dbCon->execute($sql, array());
    foreach ($result as $row)
    {
        $max_display_count = $row['max_display_count'];
    }
    $max_display_count = ($max_display_count) ? $max_display_count : 0;
    $sql = "UPDATE tweets SET tweet_enabled = ?, tweet_display_count = ? WHERE tweet_id = ?";
    $dbCon->execute($sql, array($enabled, $max_display_count, $_POST['tweet']));
}
?>
