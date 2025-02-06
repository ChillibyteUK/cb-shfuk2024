<section class="location_intro py-5">
    <div class="container-xl">
        <h2><?=get_field('title')?></h2>
        <div class="row g-4">
            <div class="col-lg-8 location_intro__content">
                <?=get_field('content')?>
            </div>
            <div class="col-lg-4">
                <div class="vimeo-embed ratio ratio-16x9" id="<?=get_field('vimeo_id')?>" title="<?=get_the_title()?>"></div>
                <a href="#" class="view-transcript" data-bs-toggle="collapse" data-bs-target="#transcriptCollapse" aria-expanded="false" aria-controls="transcriptCollapse">View Transcript <i class="fa-regular fa-plus"></i></a>
            </div>
        </div>
        <div class="collapse mt-4" id="transcriptCollapse">
            <div class="card card-body">
                <?=get_field('transcript') ?? null?>
            </div>
        </div>
    </div>
</section>
<?php
if (get_field('vimeo_id')) {
    $vimeo_id = get_field('vimeo_id');
    $transcript = get_field('transcript') ?? null;

    $vimeo_data = file_get_contents("https://vimeo.com/api/v2/video/{$vimeo_id}.json");
    $vimeo_data = json_decode($vimeo_data, true);

    echo '<!-- <pre>' . print_r($vimeo_data, true) . '</pre> -->';


    $title = $vimeo_data[0]['title'];
    $description = $vimeo_data[0]['description'];
    $thumbnail = $vimeo_data[0]['thumbnail_large'];
    $uploadDate = $vimeo_data[0]['upload_date'];

    $default_duration = 60; // Default to 60 seconds if needed
    $duration = $default_duration;
    if (isset($vimeo_data[0]['duration']) && is_numeric($vimeo_data[0]['duration'])) {
        $duration = (int)$vimeo_data[0]['duration'];
    }

    try {
        // Create the DateInterval object using the duration in seconds
        $duration_iso = new DateInterval("PT{$duration}S");
    } catch (Exception $e) {
        // Handle exception and fallback to default duration (if needed)
        $duration_iso = new DateInterval("PT{$default_duration}S");
    }

    // Format the ISO 8601 duration string correctly
    $hours = $duration_iso->h;
    $minutes = $duration_iso->i;
    $seconds = $duration_iso->s;

    $formatted_duration = 'PT';
    if ($hours > 0) {
        $formatted_duration .= $hours . 'H';
    }
    if ($minutes > 0) {
        $formatted_duration .= $minutes . 'M';
    }
    if ($seconds > 0) {
        $formatted_duration .= $seconds . 'S';
    }

    // // Convert duration to ISO 8601 format
    // $duration_iso = new DateInterval("PT{$duration}S");

    $image = get_stylesheet_directory_uri() . '/img/sellhousefast-logo--dark.svg';

    // Generate the schema markup
    $schema_markup = [
        "@context" => "https://schema.org",
        "@type" => "VideoObject",
        "name" => $title,
        "description" => $description,
        "thumbnailUrl" => $thumbnail,
        "uploadDate" => $uploadDate,
        "contentUrl" => "https://vimeo.com/{$vimeo_id}",
        "embedUrl" => "https://player.vimeo.com/video/{$vimeo_id}",
        "duration" => $formatted_duration,
        "transcript" => $transcript,
        "publisher" => [
            "@type" => "Organization",
            "name" => "SellHouseFast.uk",
            "logo" => [
                "@type" => "ImageObject",
                "url" => $image
            ]
        ]
    ];

    echo '<script type="application/ld+json">' . json_encode($schema_markup) . '</script>';
}

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

    v.innerHTML = `<img loading="lazy" src="https://${poster}" alt="${v.title}" aria-label="Play">`;

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