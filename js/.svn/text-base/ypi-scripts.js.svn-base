// Initialize variables, store original page title
var ypi_players = [];
var ypi_player_count = 0;
var orig_page_title = document.title;

// When YouTube IFrame API is ready
function onYouTubeIframeAPIReady() {

  // Find all iframe elements on page with a source containing "youtube.com"
  var ypi_iframes = document.getElementsByTagName( 'iframe' );
  var ypi_iframes_len = ypi_iframes.length;
  for ( var i = 0; i < ypi_iframes_len; i++ ) {
    if ( ypi_iframes[i].src.indexOf( "youtube.com" ) > -1 ) {

      // If video has no id, assign an id of "ypi_player0", "ypi_player1", etc.
      if ( !ypi_iframes[i].id.length )
        ypi_iframes[i].id = "ypi_player" + ypi_player_count;

      // Assign a new ypi_player object to each video
      ypi_players[ypi_player_count] = new ypi_player( ypi_iframes[i].id );

      // Update player count
      ypi_player_count++;
    }
  }
}

// Object constructor for the ypi_player class
// Contains YouTube IFrame API YT.Player event handler
function ypi_player( id ) {
  this.id = id;
  this.playing = false;
  this.paused = false;
  this.triggers = new YT.Player( id, {
          events: {
            'onStateChange': onPlayerStateChange
          }
    });
}

// When a player's state changes
function onPlayerStateChange( event ) {

  // If a video has started playing
  if ( event.data == YT.PlayerState.PLAYING ) {

    // Remember which video is playing
    var playing_video_id = event.target.getIframe().id;
    for ( var j = 0; j < ypi_player_count; j++ ) {
      if ( ypi_players[j].id == playing_video_id ) {
        ypi_players[j].playing = true;
        ypi_players[j].paused = false;
      }
    }

    // Display a play icon before the page title
    document.title = "\u25B6 " + orig_page_title;
  }

  // If a video has stopped playing
  else if ( event.data == YT.PlayerState.PAUSED || event.data == YT.PlayerState.ENDED || event.data == YT.PlayerState.BUFFERING || event.data == YT.PlayerState.CUED ) {

    // Remember which video has stopped playing
    var stopped_video_id = event.target.getIframe().id;
    for ( var j = 0; j < ypi_player_count; j++ ) {
      if ( ypi_players[j].id == stopped_video_id ) {
        ypi_players[j].playing = false;
        if ( event.data == YT.PlayerState.PAUSED )
          ypi_players[j].paused = true;
        else
          ypi_players[j].paused = false;
      }
    }

    // If all videos have stopped playing
    for ( var k = 0; k < ypi_player_count; k++) {
      if ( ypi_players[k].playing == true )
        break;
      if ( k == ypi_player_count - 1 ) {

        // If user has chosen to display pause icon
        if ( ypi_pause_icon == 'on' && event.data == YT.PlayerState.PAUSED ) {

          // If at least one video is paused
          for ( var l = 0; l < ypi_player_count; l++) {
            if ( ypi_players[l].paused == true ) {

              // Display pause icon before the page title
              document.title = "\u275A\u275A " + orig_page_title;
              break;
            }

            // Else, remove play icon from page title
            else if ( l == ypi_player_count - 1)
              document.title = orig_page_title;
          }
        }

        // Else, remove play icon from page title
        else
          document.title = orig_page_title;
      }
    } 
  }
}