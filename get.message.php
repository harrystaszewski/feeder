<?php
require_once('classes/class.appsettings.php');
require_once('classes/class.dbmanager.php');
$appsettings = AppSettings::getInstance();
$dbCon = DBManager::getDBDriver($appsettings->getDBDriver());
$sql = "SELECT * FROM tweets ORDER BY tweet_display_count, tweet_twitter_id_str ASC LIMIT 1";
$result = $dbCon->execute($sql, array());
foreach ($result as $row)
{
    $user_screen_name = $row['tweet_twitter_user_screen_name'];
    $message = $row['tweet_twitter_text'];
}
$sql = "UPDATE tweets SET tweet_display_count = ? WHERE tweet_id = ?";
$dbCon->execute($sql, array(($row['tweet_display_count']+1), $row['tweet_id']));
echo $user_screen_name . " - " . $message;
?>
