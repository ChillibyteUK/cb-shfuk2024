<?php
$class = $block['className'] ?? 'py-5';

$containerBg = get_field('background') == 'grey-400' ? 'bg-grey-400' : 'bg-white';
$contentBg = get_field('background') == 'grey-400' ? 'bg-white' : 'bg-grey-400';

?>
<section class="text_video <?=$containerBg?> <?=$class?>">
    <div class="container-xl">
        <div class="row g-4">
            <div class="col-md-6 <?=$contentBg?> p-5">
                <?=get_field('text')?>
            </div>
            <div class="col-md-6 text_video__video">
                <div class="vimeo-embed ratio ratio-16x9" id="<?=get_field('vimeo_id')?>" title="VIDEO"></div>
            </div>
        </div>
    </div>
</div>
</section>
<?php

/*
<div class="vimeo-embed ratio ratio-16x9" id="<?=get_field('vimeo_id')?>" title="VIDEO"></div>
*/

/*
// VIMEO with overlay
<div class="video-wrapper" id="video-container">
    <div class="video-thumbnail">
        <img src="https://vumbnail.com/<?=get_field('vimeo_id')?>_large.jpg" alt="Vimeo Thumbnail" />
        <div class="play-button">&#9658;</div> <!-- Unicode play icon --></div>
    </div>
</div>


add_action('wp_footer', function(){
    $vimeo_id = get_field('vimeo_id');
    ?>
<style>
.video-wrapper {
    position: relative;
    width: 640px;
    height: 360px;
    cursor: pointer;
}

.video-thumbnail {
    position: relative;
    width: 100%;
    height: 100%;
}

.video-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 60px;
    color: white;
    background-color: rgba(0, 0, 0, 0.6);
    border-radius: 50%;
    width: 80px;
    height: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const videoContainer = document.getElementById('video-container');

    // Listen for click event on the video container (thumbnail area)
    videoContainer.addEventListener('click', function () {
        const videoID = '<?=$vimeo_id?>'; // Replace with your Vimeo video ID
        const iframe = document.createElement('iframe');
        iframe.src = `https://player.vimeo.com/video/${videoID}?autoplay=1`;
        iframe.width = '640';
        iframe.height = '360';
        iframe.frameBorder = '0';
        iframe.allow = 'autoplay; fullscreen; picture-in-picture';
        iframe.allowFullscreen = true;

        // Clear out the thumbnail and play button, then insert the iframe
        videoContainer.innerHTML = '';
        videoContainer.appendChild(iframe);
    });
});
</script>
    <?php
});


// NATIVE VIMEO
<iframe src="https://player.vimeo.com/video/<?=get_field('vimeo_id')?>" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
*/

// MY VIMEO EMBED


add_action('wp_footer', function(){
    ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const lazyVideos = document.querySelectorAll('.vimeo-embed, .youtube-embed');
  
  // Lazy load placeholder images
  lazyVideos.forEach(v => {
    const [poster, src] = v.classList.contains('vimeo-embed') ?
      [`vumbnail.com/${v.id}_large.jpg`, 'player.vimeo.com/video'] :
      [`i.ytimg.com/vi/${v.id}/hqdefault.jpg`, 'www.youtube.com/embed'];

    v.innerHTML = `<img src="https://${poster}" alt="${v.title}" aria-label="Play">`;

    v.children[0].addEventListener('click', () => {
        v.innerHTML = `<iframe allow="autoplay" src="https://${src}/${v.id}?autoplay=1" allowfullscreen></iframe>`;
        v.classList.add('video-loaded');
    });
  });

  // Preload the video iframes in the background after the page has loaded
  window.addEventListener('load', function() {
    lazyVideos.forEach(v => {
      const iframe = document.createElement('iframe');
      iframe.src = v.classList.contains('vimeo-embed') ?
        `https://player.vimeo.com/video/${v.id}` :
        `https://www.youtube.com/embed/${v.id}`;
      iframe.setAttribute('allowfullscreen', true);
      iframe.style.display = 'none'; // Keep it hidden until user clicks

      v.appendChild(iframe);
    });
  });
});
</script>
    <?php
});
