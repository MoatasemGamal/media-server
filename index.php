<?php
require_once 'files.php';
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manger</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <nav>

        </nav>
    </header>
    <main>
        <div class="search">
            <form action="" method="get">
                <input type="search" name="search" id="search">
                <div class="search-type">
                    <input type="radio" required name="type" id="series-check" value="series"><label for="series-check">Courses</label>
                    <input type="radio" name="type" id="video-check" value="video"><label for="video-check">Videos</label>
                </div>
                <input type="submit" value="Search">
            </form>
        </div>
        <div class="series">




            <?php
            $seriesCollection = FileMAnager::getAllSeries();
            if (isset($_GET['search']) && !empty($_GET['search']) && isset($_GET['type']) && $_GET['type'] == 'series') {
                $search = $_GET['search'];
                $seriesColl = [];
                foreach ($seriesCollection as $series) {
                    if (str_contains(strtolower($series[0]), strtolower($search)) || str_contains(strtolower($series[1]), strtolower($search)) || str_contains(strtolower($series[2]), strtolower($search))) {
                        $seriesColl[] = $series;
                    }
                }
                $seriesCollection = $seriesColl;
            }
            foreach ($seriesCollection as $series) :
                $implodedSeries = implode('-', $series);
            ?>


                <a class="card" href="series.php?series=<?= $implodedSeries ?>&v=<?= isset($_COOKIE[implode('-', $series)]) ? $_COOKIE[$implodedSeries] : FileMAnager::getSeriesVideos($implodedSeries)[0]['encoded'] ?>">
                    <img src="<?= 'media/series/' . implode('-', $series) . DS . 'thumbnail.jpg' ?>" alt="">
                    <h3><?= $series[0] ?></h3>
                    <div class="details">
                        <span class="author"><?= $series[1] ?></span>
                        <span class="year"><?= $series[2] ?></span>
                    </div>
                </a>
            <?php
            endforeach;
            ?>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>