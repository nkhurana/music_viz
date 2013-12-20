<?php
    
    class Song {

        public $title;
        public $artist;
        public $play_count;
        public $length;
        public $play_date;
        public $file_path;
        
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
        
        public $name;
        public $song_count;
        public $play_count;
        public $play_date;

        function __construct($name,$song_count,$play_count,$play_date) {
            $this->name = $name;
            $this->song_count = $song_count;
            $this->play_count = $play_count;
            $this->play_date = $play_date;
        }

    }

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

<html>
    <body>
        <div>
        <?php
        
            $songs = array();
            $artists = array();

            $xml_object = simplexml_load_file("test.xml");
            foreach ($xml_object->dict->dict->dict as $song_xml) {
                
                //SONG VARIABLES
                $title = "";
                $artist = "";
                $play_count = 0;
                $length = 0;
                $play_date = 0;
                $location = "";

                //ITERATE THROUGH THE SONG FIELDS
                $xml_iterator = new SimpleXMLIterator($song_xml->asXML());
                for( $xml_iterator->rewind(); $xml_iterator->valid(); $xml_iterator->next() ) {    
                    if ((string)$xml_iterator->current() == "Name") {
                        $xml_iterator->next();
                        $title = (string)$xml_iterator->current();
                    }
                    else if ((string)$xml_iterator->current() == "Artist") {
                        $xml_iterator->next();
                        $artist = (string)$xml_iterator->current();
                    }
                    else if ((string)$xml_iterator->current() == "Total Time") {
                        $xml_iterator->next();
                        $length = (int)$xml_iterator->current();
                    }
                    else if ((string)$xml_iterator->current() == "Play Count") {
                        $xml_iterator->next();
                        $play_count = (int)$xml_iterator->current();
                    }
                    else if ((string)$xml_iterator->current() == "Play Date") {
                        $xml_iterator->next();
                        $play_date = (int)$xml_iterator->current();
                    }
                    else if ((string)$xml_iterator->current() == "Location") {
                        $xml_iterator->next();
                        $location = (string)$xml_iterator->current();
                    }
                }

                //CREATE SONG OBJECT
                $song = new Song($title,$artist,$play_count,$length,$play_date,$location);
                
                //ADD SONG TO LIBRARY ARRAY
                array_push($songs, $song);
            }

            //ITERATE THROUGH SONG ARRAY TO CREATE ARTIST ARRAY
            foreach ($songs as $song) {
                $artist = $song->artist;
                $repeat = "no";
                for ($i=sizeof($artists)-1; $i>=0; $i--) {
                    if ($artist == $artists[$i]->name) {
                        $artists[$i]->song_count++;
                        $artists[$i]->play_count+=$song->play_count;
                        if ($artists[$i]->play_date < $song->play_date) {
                            $artists[$i]->play_date = $song->play_date;
                        }
                        $repeat = "yes";
                        break;
                    }
                }
                if ($repeat == "no") {
                    array_push($artists, new Artist($artist,1,$song->play_count,$song->play_date));
                }
            }
            
            //SORT ARTIST ARRAY
            usort($artists, "comparePlayCount");
        
            //DISPLAY ARTISTS WITH PLAYCOUNT OF GREATER THAN 50
            foreach ($artists as $artist) {
                if ($artist->play_count > 50) {
                    echo $artist->name." (Song Count: ".$artist->song_count."; Play Count: ".$artist->play_count.")<br/>";
                }
            }

        ?>
        </div>
    </body>
</html>