$(function() {
    $(".message_row").hover(
        function() {
            $(this).css("background", "LemonChiffon");
        },
        function() {
            $(this).css("background", "");
        }
    );
        
    $(".message_enabled").change(function() {
        var checked;
        var tweet;
        checked = (this.checked) ? 1 : 0;
        tweet = $(this).next(".message_id").val();
        $.post("update.tweet.php", { tweet: tweet, enabled: checked })
        .done(function(data) {
            
        });
        
    });
});