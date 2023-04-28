<head>
<script type="text/javascript" src="game2/jquery-1.4.2.js"></script>
<script type="text/javascript" src="game2/jquery.jqpuzzle.full.js"></script>
<link rel="stylesheet" type="text/css" href="game2/jquery.jqpuzzle.css" />
</head>
<body style=background:transparent;>
 <div align=center style=width:100%;align:center;color:black;><h1>Posuvné Puzzle</h1></div>
<div width=100% height=100% valign=middle align=center style=background:transparent;><br /><br /><br />
<?  $files = glob('./game2/images/*.jpg');
  $img = $files[rand(0, count($files) - 1)];?>
<img src="<?echo@$img;?>" alt="" class="jqPuzzle" />
</div>
</body>