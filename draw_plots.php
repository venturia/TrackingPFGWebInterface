<?php
function draw_plots($filetemplate){
    exec("ls ${filetemplate}",$giflist);
    echo"<p>";
    foreach($giflist as $giffile) {
      echo " <a href='${giffile}'>";
      echo "<img border='2' src='${giffile}' width='370' height='252'></a>";
    }
    echo"</p>";
}
function draw_plots_indir($filetemplate,$directory){
    exec("cd ${directory}; ls ${filetemplate}",$giflist);
    echo"<p>";
    foreach($giflist as $giffile) {
      echo " <a href='${directory}/${giffile}'>";
      echo "<img border='2' src='${directory}/${giffile}' width='370' height='252'></a>";
    }
    echo"</p>";
}
?>