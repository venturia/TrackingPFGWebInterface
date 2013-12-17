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

<form action="results.php" method="post" enctype="multipart/form-data">
<select name="wantedfile">
<?php
#exec("ls /afs/cern.ch/cms/tracking/www/rootfiles2/Tracking_PFG_*.root",$dirlist);
#exec("cat $datadir/files.list",$dirlist);
exec("ls -F $datadir | grep fittedV0/",$dirlist);

foreach($dirlist as $dir) {

#  $fullsuffix = sscanf($dir,"/afs/cern.ch/cms/tracking/output/rootfiles/Tracking_PFG_%s");
#  $suffix =substr($fullsuffix[0],0,strlen($fullsuffix[0])-5);
  $suffix =substr($dir,0,strlen($dir)-1);

  if($suffix == $wantedfile ) {

    echo " <option value=$suffix SELECTED>$suffix</option>";
  }
  else {
    echo " <option value=$suffix>$suffix</option>";
  }
}
#exec("cat $datadir/files_archived.list",$dirlistarc);
#
#foreach($dirlistarc as $dir) {
#
#  $fullsuffix = sscanf($dir,"/afs/cern.ch/cms/tracking/workareas/rootfiles_archive/Tracking_PFG_%s");
#  $suffix =substr($fullsuffix[0],0,strlen($fullsuffix[0])-5);
#
#  if($suffix == $wantedfile ) {
#
#    echo " <option value=$suffix SELECTED>$suffix</option>";
#  }
#  else {
#    echo " <option value=$suffix>$suffix</option>";
#  }
#}
?>
</select>

<select name="wantedpage">
<option value=stat>Statistics</option>
<option value=clusmult>Cluster Multiplicity</option>
<option value=gt>general Tracks</option>
<option value=d0phi>D0 vs phi correlation</option>
<option value=pxt>pixel Tracks</option>
<option value=hpt>high purity Tracks</option>
<option value=past>PAS Tracks</option>
<option value=onegevt>high purity Tracks with pt>1 GeV</option>
<option value=pvgoodonly>Primary Vertices: good only (ndof>4)</option>
<option value=pvgoodDAonly>Primary Vertices with DA: good only (ndof>4)</option>
<option value=pvgoodonlynoscraping>Primary Vertices: good only (ndof>4) prescale reweigthed</option>
<option value=pvfirstonly>Primary Vertices: only the first good one</option>
<option value=pv>Primary Vertices: all (no ZS)</option>

<option value=bspv>Primary Vertices - BeamSpot: official BS</option>
<option value=firstbspv>Primary Vertices (only the first one) - BeamSpot: official BS</option>
<option value=noslopebspv>Primary Vertices - BeamSpot: official BS (no slope correction)</option>
<option value=allgoodbspv>Primary Vertices - BeamSpot: official BS vs all vertices with ndof>4</option>
<option value=onlinebspv>Primary Vertices - Beam Spot: online BS</option>
<option value=testbspv>Primary Vertices - BeamSpot: database BS</option>

<option value=pxv>Pixel Vertices</option>
<option value=pxvhtl>Pixel Vertices (HTL like)</option>
<option value=pxvfts>Pixel Vertices (FinalTrackSelector like)</option>

<option value=pixelbspv>Pixel Vertices - BeamSpot: official BS</option>

<option value=gtnoncoll>general Tracks in non-colliding crossings</option>
<option value=pvnoncoll>Primary Vertex in Non-Colliding crossings</option>
<option value=pvgoodnoncoll>Good (ndof>4) Primary Vertex in Non-Colliding crossings</option>

<option value=V0>V0s</option>
<option value=trackjets>TrackJets</option>
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

 # if(strlen($_GET['file'])!=0) {
 #   $wantedpage = $_GET['page'];
 #   $wantedfile = $_GET['file'];
 # }
 # else {
 #   $wantedpage = $_POST['wantedpage'];
 #   $wantedfile = $_POST['wantedfile'];
 # }

#  echo "$wantedpage $wantedfile prova${wantedpath}_riprova <br>";

  if($wantedpage=="V0") {

    echo "<H3>Lambda mass distributions </H3>";
    echo "<H4>Loose selection </H4>";

    $filename="Lam${wantedpath}_${wantedfile}.gif";
    draw_plots_indir("${filename}","${datadir}/${wantedfile}");
    $filename="Lammass${wantedpath}_*_${wantedfile}.gif";
    draw_plots_indir("${filename}","${datadir}/${wantedfile}");

#    echo "<H4>Tight (out of the box) selection </H4>";

#    $filename="Lamotob${wantedpath}_${wantedfile}.gif";
#    draw_plots_indir("${filename}","${wantedfile}");
#    $filename="Lammassotob${wantedpath}_*_${wantedfile}.gif";
#    draw_plots_indir("${filename}","${wantedfile}");

    echo "<H3>Ks mass distributions </H3>";
    echo "<H4>Loose selection </H4>";

    $filename="K0s${wantedpath}_${wantedfile}.gif";
    draw_plots_indir("${filename}","${datadir}/${wantedfile}");
    $filename="K0mass${wantedpath}_*_${wantedfile}.gif";
    draw_plots_indir("${filename}","${datadir}/${wantedfile}");

    echo "<H4>Tight (out of the box) selection </H4>";

    $filename="K0sotob${wantedpath}_${wantedfile}.gif";
    draw_plots_indir("${filename}","${datadir}/${wantedfile}");
    $filename="K0massotob${wantedpath}_*_${wantedfile}.gif";
    draw_plots_indir("${filename}","${datadir}/${wantedfile}");

  }

  if($wantedpage=="pvgoodonly") {

    echo "<H3>Offline primary vertices with ndof>4 </H3>";

    draw_pv("goodonly","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="pvgoodDAonly") {

    echo "<H3>Offline primary vertices (DA) with ndof>4 </H3>";

    draw_pv("goodDAonly","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="pvgoodonlynoscraping") {

    echo "<H3>Offline primary vertices with ndof>4 </H3>";

    draw_pv("goodonlynoscraping","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="pvfirstonly") {

    echo "<H3>First good offline primary vertex</H3>";

    draw_pv("firstonly","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="pv") {

    echo "<H3>All reconstructed offline primary vertices</H3>";

    draw_pv("colliding","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="bspv") {

    echo "<H3>Primary Vertices (with ndof>4 and within 24cm in Z) vs official BeamSpot </H3>";

    draw_bspv("bspv","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="firstbspv") {

    echo "<H3>FIRST Primary Vertex (with ndof>4) vs official BeamSpot </H3>";

    draw_bspv("firstbspv","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="noslopebspv") {

    echo "<H3>Primary Vertices (with ndof>4 and within 24cm in Z) vs official BeamSpot: no BS slope correction </H3>";

    draw_bspv("noslopebspv","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="allgoodbspv") {

    echo "<H3>Primary Vertices (with ndof>4) vs official BeamSpot </H3>";

    draw_bspv("allgoodbspv","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="onlinebspv") {

    echo "<H3>Primary Vertices (with ndof>4) vs online BeamSpot </H3>";

    draw_bspv("onlinebspv","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="testbspv") {

    echo "<H3>Primary Vertices (with ndof>4) vs database BeamSpot </H3>";

    draw_bspv("testbspv","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="pxvfts") {

    echo "<H3>Pixel primary vertices used by FinalTrackSelector</H3>";

    draw_pv("pixelvertexFTSlike","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="pxvhtl") {

    echo "<H3>Pixel primary vertices used by HLT</H3>";

    draw_pv("pixelvertexHLTlike","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="pxv") {

    echo "<H3>All reconstructed pixel primary vertices </H3>";

    draw_pv("pixelvertex","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="pixelbspv") {

    echo "<H3>Pixel Vertices vs official BeamSpot </H3>";

    draw_bspv("pixelbspv","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="pvnoncoll") {

    echo "<H3>Primary Vertex position in non-colliding crossings</H3>";

    draw_noncollpv("noncolliding","${wantedfile}","${datadir}");

  }

  if($wantedpage=="pvgoodnoncoll") {

    echo "<H3>Good (ndof>4) Primary Vertex position in non-colliding crossings</H3>";

    draw_noncollpv("noncollidinggood","${wantedfile}","${datadir}");

  }

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

  if($wantedpage=="clusmult") {

    echo "<H3>Cluster multiplicity</H3>";
    echo "<H4>no scraping (high purity fraction) colliding events with a good vertex</H4>";

    draw_clusmult("","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H4>Colliding events with a good vertex</H4>";

    draw_clusmult("prescraping","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H4>Colliding events with scraping filter</H4>";

    draw_clusmult("onlynoscraping","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H4>Using DA vertices</H4>";

    draw_clusmult("onlynoscrapingDA","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H4>Using HLT-like pixel vertices</H4>";

    draw_clusmult("onlynoscrapingHLTpixelvtx","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H4>Using offline pixel vertices</H4>";

    draw_clusmult("onlynoscrapingpixelvtx","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H4>Colliding events with trigger filter</H4>";

    draw_clusmult("onlytrigger","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H4>Non-colliding events (BPTX XOR) and at least 10 pixel clusters</H4>";

    draw_clusmult("noncoll","","${wantedfile}","${datadir}");

    echo "<H4>Non-colliding events (BPTX XOR)</H4>";

    draw_clusmult("noncollearly","","${wantedfile}","${datadir}");

  }

  if($wantedpage=="d0phi") {
    echo "<H3>D0 vs phi correlation</H3>";
    echo "<H4>Colliding events with one good vertex and scraping filter: central tracks with pt>10 GeV</H4>";


    draw_d0phi("centralTenGeV","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="gt") {
    echo "<H3>General Tracks</H3>";
    echo "<H4>Colliding events with one good vertex and scraping filter</H4>";


    draw_trackcount("generalTracks","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H4>Colliding events with one good vertex</H4>";

    draw_trackcount("generalTracksprescraping","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H4>Colliding events with scraping filter</H4>";

    draw_trackcount("generalTracksonlynoscraping","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H5>Ratio of tibtid , tobtec and pixelless tracks over iter0+iter1</H5>"; 

    draw_pixelless("pxllessonlynoscraping","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H5>Ratio of tibtid , tobtec and pixelless tracks over iter0+iter1: only if first vertex abs(z)<12cm </H5>"; 

    draw_pixelless("pxllesscentralonlynoscraping","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H4>Colliding events with trigger selection</H4>";

    draw_trackcount("generalTracksonlytrigger","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="gtnoncoll") {
    echo "<H3>General Tracks in non colliding crossings</H3>";
    echo "<H4>Events in non-colliding crossings with 10 pixel hits</H4>";

    draw_trackcount("generalTracksnoncolliding","","${wantedfile}","${datadir}");

    echo "<H4>Events in non-collding crossings with 10 pixel hits and one good vertex (ndof>4)</H4>";

    draw_trackcount("generalTracksnoncollidinggoodvtx","","${wantedfile}","${datadir}");

  }

  if($wantedpage=="pxt") {
    echo "<H3>Pixel Tracks in colliding events with one good vertex</H3>";

    draw_trackcount("pixelTracks","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="hpt") {
    echo "<H3>High Purity Tracks</H3>";
    echo "<H4>Colliding events with one good vertex and scraping filter</H4>";

    draw_trackcount("hpTracks","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H4>Colliding events with scraping filter</H4>";

    draw_trackcount("hpTracksonlynoscraping","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H5>Ratio of iter4 and iter5 tracks over iter0+iter1</H5>"; 

    draw_pixelless("pxllesshponlynoscraping","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H5>Ratio of iter4 and iter5 tracks over iter0+iter1: only if first vertex abs(z)<12cm </H5>"; 

    draw_pixelless("pxllesshpcentralonlynoscraping","${wantedpath}","${wantedfile}","${datadir}");

    echo "<H4>Colliding events with trigger filter</H4>";

    draw_trackcount("hpTracksonlytrigger","${wantedpath}","${wantedfile}","${datadir}");
  }

  if($wantedpage=="past") {
    echo "<H3>PAS-like Tracks (high purity and pt>500 MeV)</H3>";
    echo "<H4>Colliding events with one good vertex and scraping filter</H4>";

    draw_trackcount("pasTracks","${wantedpath}","${wantedfile}","${datadir}");

  }

  if($wantedpage=="onegevt") {
    echo "<H3>High purity tracks with pt>1 GeV in colliding events with one good vertex</H3>";
    echo "<H4>Colliding events with one good vertex and scraping filter</H4>";

    draw_trackcount("oneGeVTracks","${wantedpath}","${wantedfile}","${datadir}");

  }

}

?>