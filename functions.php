<?php
    function comparePlayCount($a, $b) {
        $p1 = $a->play_count;
        $p2 = $b->play_count;
        if ($p1 == $p2) {
            return 0;
        }
        return ($p1 < $p2) ? -1 : 1;
    }

    function compareSongCount($a, $b) {
        $p1 = $a->song_count;
        $p2 = $b->song_count;
        if ($p1 == $p2) {
            return 0;
        }
        return ($p1 < $p2) ? -1 : 1;
    }
?>