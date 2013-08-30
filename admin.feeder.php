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
        <link href="css/feeder.css" rel="stylesheet" type="text/css" />
        <script src="//ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
        <script>
          WebFont.load({
            google: {
              families: ['Raleway']
            }
          });
        </script>
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="scripts/admin.feeder.js"></script>
    </head>
    <body>
        <div id="canvas">
            <h1>Feeder Administration</h1>
            <div id="admin_messages">
                <table class="message_list">
                    <tr>
                        <th>Id</th>
                        <th>Tweet Id</th>
                        <th>Tweet Text</td>
                        <th>User Name</td>
                        <th>Screen Name</td>
                        <th>Display Cycle</td>
                        <th>Tweeted At</td>
                        <th>Enabled</th>
                    </tr>
                    <?php
                        $sql = "SELECT * FROM tweets ORDER BY tweet_twitter_id_str DESC";
                        $results = $dbCon->execute($sql, array());
                        foreach ($results as $row)
                        {
                            $bgcolor = ($bgcolor == "#eeeeee") ? "#ffffff" : "#eeeeee";
                            echo "<tr class='message_row' bgcolor='$bgcolor'>";
                            echo "<td>" . $row['tweet_id'] . "</td>";
                            echo "<td>" . $row['tweet_twitter_id_str'] . "</td>";
                            echo "<td align='left'>&nbsp;" . $row['tweet_twitter_text'] . "</td>";
                            echo "<td>" . $row['tweet_twitter_user_name'] . "</td>";
                            echo "<td>" . $row['tweet_twitter_user_screen_name'] . "</td>";
                            echo "<td>" . $row['tweet_display_count'] . "</td>";
                            echo "<td>" . date("d/m/Y H:i:sa", strtotime($row['tweet_twitter_created_at'])) . "</td>";
                            echo "<td><input class='message_enabled' type='checkbox'";
                            echo ($row['tweet_enabled']) ? " checked='checked' " : "";
                            echo "/><input class='message_id' type='hidden' value='" . $row['tweet_id'] . "' /></td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
            <div id="footer"></div>
        </div>
    </body>
</html>
