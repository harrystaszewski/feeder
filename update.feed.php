<?php
require_once('scripts/TwitterAPIExchange.php');
require_once('classes/class.appsettings.php');
require_once('classes/class.dbmanager.php');

//Settings array for twitter api
$settings = array(
    'oauth_access_token' => "285105029-sb8rEgtlGLzs8ZjDwzX5YbtbwN7h85wKTtW4TXoY",
    'oauth_access_token_secret' => "lGDlE33EHi0hiUAggwnbB5QvZZPhHZl0AbTQYOVqus",
    'consumer_key' => "ieJhglh16MMCaKapTG7Kw",
    'consumer_secret' => "zWkX2S73hDNIkD66iQWmWl4CJqK5WWWayizK8grjo"
);
$url = 'https://api.twitter.com/1.1/search/tweets.json';

$appsettings = AppSettings::getInstance();
$dbCon = DBManager::getDBDriver($appsettings->getDBDriver());

//Set api query parameters
$getfield = '?q=#pmmainstage2013';

//Only get tweets since last tweet in database
//Get max tweet display count to maintain rotation with existing tweets
$sql = "SELECT MAX(tweet_twitter_id_str) AS 'since_id', MAX(tweet_display_count) AS 'max_display_count'
    FROM tweets";
$result = $dbCon->execute($sql, array());
foreach ($result as $row)
{
    $since_id = $row['since_id'];
    $max_display_count = $row['max_display_count'];
}
$getfield .= ($since_id) ? '&since_id=' . $since_id : "";
$max_display_count = ($max_display_count) ? $max_display_count : 0;

$requestMethod = 'GET';

//Get the tweets!
$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
                    ->buildOauth($url, $requestMethod)
                   ->performRequest();
$tweets = json_decode($response);
if ($tweets)
{
    foreach ($tweets->statuses as $status)
    {
        //Do not show replies or retweets
        if (!$status->in_reply_to_status_id_str)
        {
            //Does tweet exist in DB?
            $sql = "SELECT tweet_id FROM tweets WHERE tweet_twitter_id_str = ?";
            $result = $dbCon->execute($sql, array($status->id_str));
            if (!$result)
            {
                $sql = "INSERT INTO tweets(tweet_twitter_id_str, tweet_twitter_text, tweet_twitter_user_name,
                    tweet_twitter_user_screen_name, tweet_twitter_created_at, tweet_display_count) VALUES (?, ?, ?, ?, ?, ?)";
                $dbCon->execute($sql, array($status->id_str, $status->text, $status->user->name,
                    $status->user->screen_name, date("Y-m-d H:i:s", strtotime($status->created_at)), $max_display_count));
            }
        }
    }
}
?>
