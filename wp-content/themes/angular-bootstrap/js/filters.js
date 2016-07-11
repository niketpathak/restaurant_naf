/**
 * Created by niketpathak on 12/07/16.
 */

//filter to remove all html tags
app.filter('stripHtmlTags', function() {
        return function(text) {
            return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
        };
    }
);