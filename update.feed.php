<?php
require_once('scripts/TwitterAPIExchange.php');
require_once('classes/class.appsettings.php');
require_once('classes/class.dbmanager.php');

$settings = array(
    'oauth_access_token' => "285105029-sb8rEgtlGLzs8ZjDwzX5YbtbwN7h85wKTtW4TXoY",
    'oauth_access_token_secret' => "lGDlE33EHi0hiUAggwnbB5QvZZPhHZl0AbTQYOVqus",
    'consumer_key' => "ieJhglh16MMCaKapTG7Kw",
    'consumer_secret' => "zWkX2S73hDNIkD66iQWmWl4CJqK5WWWayizK8grjo"
);
$url = 'https://api.twitter.com/1.1/search/tweets.json';

$appsettings = AppSettings::getInstance();
$dbCon = DBManager::getDBDriver($appsettings->getDBDriver());

$sql = "SELECT MAX(tweet_twitter_id_str) AS 'since_id' FROM tweets";
$result = $dbCon->execute($sql, array());
if ($result)
{
    foreach ($result as $row)
    {
        $since_id = $row['since_id'];
    }
    $getfield = '?q=#pmmainstage2013&since_id=' . $since_id;
} else {
    $getfield = '?q=#pmmainstage2013';
}
$requestMethod = 'GET';

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
                    tweet_twitter_user_screen_name, tweet_twitter_created_at) VALUES (?, ?, ?, ?, ?)";
                $dbCon->execute($sql, array($status->id_str, $status->text, $status->user->name,
                    $status->user->screen_name, date("Y-m-d H:i:s", strtotime($status->created_at))));
            }
        }
    }
}
?>
