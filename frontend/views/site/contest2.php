<?php $this->params['bodyClass'] = 'about_page';?>

<div class="page_wrapper ">
    <div class="row text_center">
        <a href="#" class="main_title"></a>
    </div>

    <div class="text text_center">
        <div class="like-p">
            <div><b>Расскажи</b> свою захватывающую историю путешествия</div>
            <div>и <b>поделись</b> ею в социальных сетях</div>
            <div><b>собирай</b> голоса и выигрывай новые</div>
            <div>революционные шины <b>Michelin X-Ice North 4</b></div>
        </div>
    </div>
    <div class="start-block">
        <div class="left">
            <div>Старт</div>
            <div>конкурса</div>
        </div>
        <div class="right">
            <div><span>17</span> сентября</div>
        </div>
    </div>
</div>
<?php
        $arr2 = [
            ['tire' => '00', 'css' => 'background-position: 0 0'],
            ['tire' => '01', 'css' => 'background-position: 0 5.263158%'],
            ['tire' => '02', 'css' => 'background-position: 0 10.526316%'],
            ['tire' => '03', 'css' => 'background-position: 0 15.789474%'],
            ['tire' => '04', 'css' => 'background-position: 0 21.052632%'],
            ['tire' => '05', 'css' => 'background-position: 0 26.315789%'],
            ['tire' => '06', 'css' => 'background-position: 0 31.578947%'],
            ['tire' => '07', 'css' => 'background-position: 0 36.842105%'],
            ['tire' => '08', 'css' => 'background-position: 0 42.105263%'],
            ['tire' => '09', 'css' => 'background-position: 0 47.368421%'],
            ['tire' => '10', 'css' => 'background-position: 0 52.631579%'],
            ['tire' => '11', 'css' => 'background-position: 0 57.894737%'],
            ['tire' => '12', 'css' => 'background-position: 0 68.421053%'],
        ];

        // foreach ($arr as $v) {
        //     for ($i=0; $i < 7; $i++) { 
        //         $tire = (int)$v['tire'] + 13 * $i;
        //         $marker = $v['marker'] + 15 * $i;
        //         echo '
        //         #tire.frame-00'.$tire.' .marker'.$marker;
        //         if($i != 6) {
        //             echo ', ';
        //         }
        //     }
        //     echo '</br>';
        //     echo ' {
        //             display: block;
        //             '.$v['css'].'
        //         }';
        //     echo '</br>';
        // }

        foreach ($arr2 as $v) {
            for ($i=0; $i < 7; $i++) { 
                $tire = (int)$v['tire'] + 13 * $i;
                echo '
                #tire.frame-00'.$tire;
                if($i != 6) {
                    echo ', ';
                }
            }
            echo '</br>';
            echo ' {
                    '.$v['css'].'
                }';
            echo '</br>';
        }
        ?>