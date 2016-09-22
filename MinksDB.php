<?php
class MinksDB extends SQLite3{
    function addMinksUser($username){
        /*
        Creates new user in minksdb.

        username specifies name, although it should be done in ID format.
        ex: ff928jkdpgweginwe926GGFyf01FM825 instead of chef_meagaloaf (mea-ga-loaf)
        */

        $addUserSQL = "CREATE TABLE IF NOT EXISTS $username (word varchar PRIMARY KEY, kl byte)";
        $rel = $this->exec($addUserSQL);
        if ($rel == True){
            print("user '".$username."' created<br />\n");
        }else{
            print("ERROR: ".$this->lastErrorMsg());
        }
    }
    function modifyUserWord($username, $word, $kl){
        /*
        Modifies user's word to knowledge level kl.

        username is username in sqlitedb.
        word is the word you want to modify.
        kl is the knowledge level you want assigned.
        */

        $modifyUserWordSQL = "INSERT OR REPLACE INTO ".$username." (word, kl) VALUES('".$word."', ".$kl.")";
        $rel = $this->exec($modifyUserWordSQL);
        $passed = checkDBError($rel, $this);
        if ($passed == True){
            print($username."'s kl value of ".$word." is now ".$kl."<br />\n");
        }else{
            print("ERROR: ".$db->lastErrorMsg());
        }
    }
    function getUserWords($username){
        /*
        Returns list of dict of user's words, ex:
        [
            {"word": '同意', "kl": 1},
            {"word": '非常', "kl": 2},
            ...
        ]

        $username is just the username to search the DB for.
        */

        return $this->getListFromQuery("SELECT * FROM ".$username);
    }
    function genUserCSS($username){
        /*
        retruns string of CSS making all words with kl>0 invisible.

        $username is username to query on.
        */

        $fullCssString = "";
        $words = $this->getUserWords($username);
        foreach ($words as $word){
            if ($word['kl'] == 1){
                $cssString = ".phonetic-script.".$word['word']."{display:none;}";
                $fullCssString = $fullCssString.$cssString;
            }
        }
        return $fullCssString;
    }
    function getListFromQuery($query){
        $rel = $this->query($query);
        $ret = [];

        while ($table = $rel->fetchArray(SQLITE3_ASSOC)) {
            array_push($ret, $table);
        }
        return $ret;
    }
}
?>
