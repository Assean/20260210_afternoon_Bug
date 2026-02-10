<?php
    session_start();
    $games=[];
    $hande=opendir('games');
    if($hande){
        while(false !== ($entry=readdir($hande))){
            if($entry != "." && $entry != ".."){
                $json_path="games/".$entry."game.json";
                if(file_exists($json_path)){
                    $data=json_decode(file_get_contents($json_path),true);
                    $data["path"]="games/".$entry."index.html";
                    $games[]=$data;
                }
            }
        }
        closedir($hande);
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <div id="R-B">
            <div>遊戲名稱:<span id="GameTitle"></span></div>
            <div>遊戲狀態:<span id="GameStat"></span></div>
            <div>遊戲時間:<span id="GameTime"></span></div>
        </div>
        <?php foreach($games as $game){ ?>
        <div>
            <div>遊戲名稱:
                <?= $game['title']; ?>
            </div>
            <div>遊戲描述:
                <?= mb_strlen($game['description']) > 50 ?
                    mb_substr($game['description'],0,50) . "...":
                    $game['description']; ?>
            </div>
        </div>
        <button onclick="openGame('<?=$game['path']?>'),('<?=$game['title']?>')">PLAY</button>
        <?php } ?>
        <script>
            let actGame;
            let GameURL;
            function receiveGameResult(data){
                $("#GameTitle").text(data.game);
                $("#GameStat").text(data.data.result);
                $("#GameTime").text(data.data.time);
                $("#R-B").removeClass("d-none");
                $("#R-B").addClass("d-block");
            }
        </script>
    </body>
    </html>