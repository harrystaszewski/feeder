<?php
require_once('classes/class.appsettings.php');
require_once('classes/class.dbmanager.php');
$appsettings = AppSettings::getInstance();
$dbCon = DBManager::getDBDriver($appsettings->getDBDriver());
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="robots" content="noindex, nofollow" />
        <title></title>
        <link href="css\feeder.css" rel="stylesheet" type="text/css" />
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    </head>
    <body>
        <div id="canvas">
            <div id="admin_messages">
                <table>
                    <tr>
                        <td>Feed Id</td>
                        <td>Message Id</td>
                        <td>Message Text</td>
                        <td>Message User Name</td>
                        <td>Message Screen Name</td>
                        <td>Message Display Count</td>
                        <td>Message Created At</td>
                        <td>Message Enabled</td>
                    </tr>
                    <?php
                        $sql = "SELECT * FROM tweets ORDER BY tweet_id DESC";
                        $results = $dbCon->execute($sql, array());
                        foreach ($results as $row)
                        {
                            echo "<tr>";
                            echo "<td>" . $row['tweet_id'] . "</td>";
                            echo "<td>" . $row['tweet_twitter_id_str'] . "</td>";
                            echo "<td>" . $row['tweet_twitter_text'] . "</td>";
                            echo "<td>" . $row['tweet_twitter_user_name'] . "</td>";
                            echo "<td>" . $row['tweet_twitter_user_screen_name'] . "</td>";
                            echo "<td>" . $row['tweet_display_count'] . "</td>";
                            echo "<td>" . $row['tweet_twitter_created_at'] . "</td>";
                            echo "<td>" . $row['tweet_enabled'] . "</td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
            <div id="footer"></div>
        </div>
    </body>
</html>
