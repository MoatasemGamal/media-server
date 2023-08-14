<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <nav><a href="/filemanager/">Back to home</a></nav>
    </header>
    <main>
        <div class="series">
            <?php
            require_once 'files.php';
            if (isset($_GET['series']) && !empty($_GET['series'])) :
                $series = $_GET['series'];
                $seriesVideos = FileMAnager::getSeriesVideos($series);
                $currentVideo;
                if (isset($_GET['v']) && !empty($_GET['v'])) {
                    $currentVideo = FileMAnager::encodeNameAsURL($_GET['v']);
                    setcookie($series, $currentVideo, time() + 3 * 30 * 24 * 60 * 60);
                }

            ?>

                <div class="current-video">
                    <h1><?= trim($_GET['v'], '.mp4') ?></h1>
                    <video src="media/series/<?= $series ?>/<?= $currentVideo ?>" controls autoplay type="video/mp4">
                        Your Browser Doesn't Support Videos!!</video>
                </div>
                <ul class="videos">

                    <?php
                    foreach ($seriesVideos as $video) :
                    ?>
                        <li class="<?= ($video['encoded'] == $currentVideo) ? 'active' : ''; ?>"><a href="series.php?series=<?= $series . '&v=' . $video['encoded'] ?>"><span><?= $video['duration'] ?></span> <span><?= trim($video['name'], '.mp4') ?></span></a></li>
                    <?php endforeach; ?>
                </ul>
        </div>
    <?php endif; ?>
    </main>
    <footer>

    </footer>
</body>

</html>