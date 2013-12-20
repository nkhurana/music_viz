<?php
    
    class Song {
        //Member Variables
        public $title;
        public $artist;
        public $play_count;
        public $length;
        public $play_date;
        public $file_path;
        //Constructor
        function __construct($title,$artist,$play_count,$length,$play_date,$file_path) {
            $this->title = $title;
            $this->artist = $artist;
            $this->play_count = $play_count;
            $this->length = $length;
            $this->play_date = $play_date;
            $this->file_path = $file_path;
        }
    }

    class Artist {
        //Member Variables
        public $name;
        public $song_count;
        public $play_count;
        public $play_date;
        //Constructor
        function __construct($name,$song_count,$play_count,$play_date) {
            $this->name = $name;
            $this->song_count = $song_count;
            $this->play_count = $play_count;
            $this->play_date = $play_date;
        }
    }
    
?>