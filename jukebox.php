<?php
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

// This should be url where all music files are and this file jukebox.php
$baseURL = "https://yourdomain.com/jukebox/";
$title = "Hello, welcome to Becky's Jukebox";
$voice = "Polly.Kimberly-Neural";

$songs = [
    '1' => ['file' => 'IMissYou.mp3', 'description' => 'I Miss You'],
    '2' => ['file' => 'HoHey.mp3', 'description' => 'Ho Hey'],
    '3' => ['file' => 'IWillWait.mp3', 'description' => 'I Will Wait'],
    '4' => ['file' => 'OvertheRainbow.mp3', 'description' => 'Over the Rainbow']
];

function getNextSong($currentSong, $songs)
{
    $keys = array_keys($songs);
    $currentIndex = array_search($currentSong, $keys);
    $nextIndex = ($currentIndex + 1) % count($keys);
    return $keys[$nextIndex];
}

function getPreviousSong($currentSong, $songs)
{
    $keys = array_keys($songs);
    $currentIndex = array_search($currentSong, $keys);
    $previousIndex = $currentIndex > 0 ? $currentIndex - 1 : count($keys) - 1;
    return $keys[$previousIndex];
}

$currentSong = isset($_REQUEST['CurrentSong']) ? $_REQUEST['CurrentSong'] : '1';
$maxDigits = strlen(strval(max(array_keys($songs))));

if (isset($_REQUEST['Digits'])) {
    $digits = $_REQUEST['Digits'];

    if ($digits == '0') {
        ?>
        <Response>
            <Redirect>jukebox.php</Redirect>
        </Response>
        <?php
        exit;
    } elseif ($digits == '*') {
        $currentSong = getPreviousSong($currentSong, $songs);
    } elseif ($digits == '#') {
        $currentSong = getNextSong($currentSong, $songs);
    } elseif (array_key_exists($digits, $songs)) {
        $currentSong = $digits;
    } else {
        header("Location: jukebox.php");
        die;
    }

    $song = $songs[$currentSong]['file'];
    ?>
    <Response>
        <Gather numDigits="<?php echo $maxDigits; ?>" action="jukebox.php?CurrentSong=<?php echo $currentSong; ?>" method="POST" timeout="10" finishOnKey="">
            <Say voice="<?php echo $voice; ?>"><?php echo $songs[$currentSong]['description'] ?></Say>
            <Play><?php echo "$baseURL/$song"; ?></Play>
            <Say voice="<?php echo $voice; ?>">Press * to play the previous song, # to play the next song, or 0 to return to the main menu.</Say>
        </Gather>
    </Response>
    <?php
} else {
    ?>
    <Response>
        <Pause length="1"/>
        <Say voice="<?php echo $voice; ?>"><?php echo $title; ?></Say>
        <Pause length="1"/>
        <Gather numDigits="<?php echo $maxDigits; ?>" timeout="20" action="jukebox.php" method="POST">
            <Say voice="<?php echo $voice; ?>">
                <?php
                foreach ($songs as $digit => $song) {
                    echo $song['description'] . ", press " . $digit . ". ";
                }
                echo "To return to the main menu at any time, press 0.";
                ?>
            </Say>
        </Gather>
    </Response>
    <?php
}
?>
