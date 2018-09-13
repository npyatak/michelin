<?php
        $res = [];
        foreach ($arr as $key => $a) {
            $res[$a['id']] = $a;
        }
        asort($res);

        foreach ($res as $key => $a) {
            echo '[';
            echo "'".$a['id']."', ";
            echo "'".$a['name']."', ";
            if(isset($cArr[$a['id']])) {
                echo "'".$cArr[$a['id']]."', ";
            } else {
                echo "'', ";
            }
            echo "'".$a['descr']."', ";
            echo "'".$a['coord']."', ";
            echo "'".$a['type']."', ";
            echo "'".$a['score1']."', ";
            echo "'".$a['score2']."', ";
            echo "'".$a['score3']."', ";
            echo "'".$a['yt_id']."'";
            echo '],';
            echo '<br>';
        }
?>
