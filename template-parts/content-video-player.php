<?php

$content_video_player = new WPST_Content_Video_Player( $post->ID );
echo '<div class="video-player">';
echo $content_video_player->get_content_video_player();
echo '</div>';
