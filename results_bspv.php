<?php
#include 'draw_plots.php';
include 'drawing_functions.php';

$rootdir='/afs/cern.ch/cms/tracking/www/plots';
$datadir='data';

if($_POST['request'] || $_POST['getpath'] || strlen($_GET['file']) !=0 ) {
  
  if(strlen($_GET['file'])!=0) {
    $wantedpage = $_GET['page'];
    $wantedfile = $_GET['file'];
    $wantedpath = $_GET['path'];
  }
  else {
    $wantedpage = $_POST['wantedpage'];
    $wantedfile = $_POST['wantedfile'];
    $wantedpath = $_POST['wantedpath'];
  }
  
 }
?>



<H1>2010/2011 Collision Results Plots</H1>

<form action="results_bspv.php" method="post" enctype="multipart/form-data">
<select name="wantedfile">
<?php
#exec("ls /afs/cern.ch/cms/tracking/www/rootfiles2/Tracking_PFG_*.root",$dirlist);
exec("cat $rootdir/files_bspv.list",$dirlist);

foreach($dirlist as $dir) {

  $fullsuffix = sscanf($dir,"/afs/cern.ch/cms/tracking/output/rootfiles/%s");
  $suffix =substr($fullsuffix[0],0,strlen($fullsuffix[0])-5);

  if($suffix == $wantedfile ) {

    echo " <option value=$suffix SELECTED>$suffix</option>";
  }
  else {
    echo " <option value=$suffix>$suffix</option>";
  }
}
?>
</select>

<select name="wantedpage">
<option value=stat>Statistics</option>

<option value=pvgoodonly>Primary Vertices: good only (ndof>4)</option>
<option value=pvfirstonly>Primary Vertices: only the first good one</option>
<option value=pxv>Pixel Vertices</option>

<option value=bspv>Primary Vertices - BeamSpot: official BS</option>
<option value=noslopebspv>Primary Vertices - BeamSpot: official BS (no slope correction)</option>
<option value=firstbspv>Primary Vertices (only the first one) - BeamSpot: official BS</option>
<option value=onlinebspv>Primary Vertices - Beam Spot: online BS</option>
<option value=testbspv>Primary Vertices - BeamSpot: database BS</option>
<option value=noslopeonlinebspv>Primary Vertices - Beam Spot: online BS (no slope correction)</option>
<option value=noslopetestbspv>Primary Vertices - BeamSpot: database BS (no slope correction)</option>

<option value=pixelbspv>Pixel Vertices - BeamSpot: official BS</option>

</select>

<?php
if( strlen($wantedfile) !=0 ) {
  
  echo "<select name='wantedpath'>";
#  echo "<option value=''>No Selection</option>";

  exec("ls $rootdir/$datadir/$wantedfile/nevents_colliding*_$wantedfile.gif",$pathlist);
  
  foreach($pathlist as $pathstring) {
    
    $patharr = sscanf($pathstring,"$rootdir/$datadir/$wantedfile/nevents_colliding%s");
    $path = substr($patharr[0],0,strpos($patharr[0],"_"));
#    $path = $patharr[0];
    
    if($path == "" ) {
      
      echo " <option value=$path>No Selection</option>";

    }
    else if($path == $wantedpath ) {
      
      echo " <option value=$path SELECTED>$path</option>";

    }
    else {

      echo " <option value=$path>$path</option>";

    }
  }
  

  echo "</select>";

  echo "<p><input onClick='return true;' name='request' type='submit' value='Show Plots'/></p>";
  
}
?>

<p><input onClick="return true;" name="getpath" type="submit" value="Get Paths"/></p>

</form>

<?php 

if($_POST['request'] || strlen($_GET['file']) !=0 ) {

  if($wantedpage=="stat") {

    echo "<H3>Number of events vs run </H3>";
    echo "<H4>Colliding </H4>";

    $filename="nevents_colliding${wantedpath}_${wantedfile}.gif";
    draw_plots_indir("${filename}","${datadir}/${wantedfile}");

    echo "<H4>Non-Colliding: at least 10 clusters in Pixel detector </H4>";

    $filename="nevents_noncolliding_${wantedfile}.gif";
    draw_plots_indir("${filename}","${datadir}/${wantedfile}");

    exec("ls $rootdir/$datadir/${wantedfile}/orbit_colliding${wantedpath}_${wantedfile}_run_*.gif",$runlist);
    foreach($runlist as $runfile) {
      sscanf($runfile,"$rootdir/$datadir/${wantedfile}/orbit_colliding${wantedpath}_${wantedfile}_run_%d.gif",$run);

      echo "<H3>Event distribution in run $run </H3>";
      echo "<H4>BX, DBX and Orbit distribution of events with BPTX AND</H4>";
      $filename="orbit_colliding${wantedpath}_${wantedfile}_run_${run}.gif bx_colliding${wantedpath}_${wantedfile}_run_${run}.gif dbx_colliding${wantedpath}_${wantedfile}_run_${run}.gif";
      draw_plots_indir("${filename}","${datadir}/${wantedfile}");

      echo "<H4>BX, DBX and Orbit distribution of events with BPTX XOR and at least 10 clusters in Pixel detector</H4>";
      $filename="orbit_noncolliding_${wantedfile}_run_${run}.gif bx_noncolliding_${wantedfile}_run_${run}.gif dbx_noncolliding_${wantedfile}_run_${run}.gif";
      draw_plots_indir("${filename}","${datadir}/${wantedfile}");
    }

  }

  if($wantedpage=="pvgoodonly") {

    echo "<H3>Offline primary vertices with ndof>4 </H3>";

    draw_pv("goodonly","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="pvfirstonly") {

    echo "<H3>First good offline primary vertex</H3>";

    draw_pv("firstonly","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="pxv") {

    echo "<H3>All reconstructed pixel primary vertices </H3>";

    draw_pv("pixelvertex","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="bspv") {

    echo "<H3>Primary Vertices (with ndof>4) vs official BeamSpot </H3>";

    draw_bspv("bspv","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="noslopebspv") {

    echo "<H3>Primary Vertices (with ndof>4) vs official BeamSpot: no BS slope correction </H3>";

    draw_bspv("noslopebspv","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="firstbspv") {

    echo "<H3>FIRST Primary Vertex (with ndof>4) vs official BeamSpot </H3>";

    draw_bspv("firstbspv","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="onlinebspv") {

    echo "<H3>Primary Vertices (with ndof>4) vs online BeamSpot </H3>";

    draw_bspv("onlinebspv","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="testbspv") {

    echo "<H3>Primary Vertices (with ndof>4) vs database BeamSpot </H3>";

    draw_bspv("testbspv","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="noslopeonlinebspv") {

    echo "<H3>Primary Vertices (with ndof>4) vs online BeamSpot (no BS correction)</H3>";

    draw_bspv("onlinenoslopebspv","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="noslopetestbspv") {

    echo "<H3>Primary Vertices (with ndof>4) vs database BeamSpot (no BS correction)</H3>";

    draw_bspv("testnoslopebspv","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="pixelbspv") {

    echo "<H3>Pixel Vertices vs official BeamSpot </H3>";

    draw_bspv("pixelbspv","${wantedpath}","${wantedfile}","${datadir}");

  }

}

?>