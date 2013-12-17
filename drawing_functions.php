<?php
include 'draw_plots.php';

function draw_trackcount($modulelabel,$wantedpath,$wantedfile,$datadir){
      $filename="ntrk_${modulelabel}${wantedpath}_${wantedfile}.gif pt_${modulelabel}${wantedpath}_${wantedfile}.gif ptphieta_${modulelabel}${wantedpath}_${wantedfile}.gif eta_${modulelabel}${wantedpath}_${wantedfile}.gif phi_${modulelabel}${wantedpath}_${wantedfile}.gif phieta_${modulelabel}${wantedpath}_${wantedfile}.gif n*hits_${modulelabel}${wantedpath}_${wantedfile}.gif nhitphieta_${modulelabel}${wantedpath}_${wantedfile}.gif n*layers_${modulelabel}${wantedpath}_${wantedfile}.gif nlayerphieta_${modulelabel}${wantedpath}_${wantedfile}.gif hhpfrac_${modulelabel}${wantedpath}_${wantedfile}.gif halgo_${modulelabel}${wantedpath}_${wantedfile}.gif hntrkvslumi_${modulelabel}${wantedpath}_${wantedfile}.gif hntrkvslumi2D_${modulelabel}${wantedpath}_${wantedfile}.gif";
      draw_plots_indir("${filename}","${datadir}/${wantedfile}");
}

function draw_clusmult($selectionlabel,$wantedpath,$wantedfile,$datadir){

    $filename="*clusmultinvest${selectionlabel}${wantedpath}_${wantedfile}.gif";
    draw_plots_indir("${filename}","${datadir}/${wantedfile}");

    $filename="*pixelvstkmultcorr${selectionlabel}${wantedpath}_${wantedfile}.gif *pixelovertkmultcorr${selectionlabel}${wantedpath}_${wantedfile}.gif";
    draw_plots_indir("${filename}","${datadir}/${wantedfile}");



}


function draw_bspv($modulelabel,$wantedpath,$wantedfile,$datadir){

    $filename="delta*_${modulelabel}${wantedpath}_${wantedfile}.gif";
    draw_plots_indir("${filename}","${datadir}/${wantedfile}/${modulelabel}${wantedpath}");

    exec("ls ${datadir}/${wantedfile}/${modulelabel}${wantedpath}/deltaxrun_${modulelabel}${wantedpath}_${wantedfile}_run_*.gif",$runlist);
    foreach($runlist as $runfile) {

      sscanf($runfile,"${datadir}/${wantedfile}/${modulelabel}${wantedpath}/deltaxrun_${modulelabel}${wantedpath}_${wantedfile}_run_%d.gif",$run);
      echo "<H4>Primary Vertex - BeamSpot position in run $run </H4>";
      $filename="deltaxrun_${modulelabel}${wantedpath}_${wantedfile}_run_${run}.gif deltayrun_${modulelabel}${wantedpath}_${wantedfile}_run_${run}.gif deltazrun_${modulelabel}${wantedpath}_${wantedfile}_run_${run}.gif";
      draw_plots_indir("${filename}","${datadir}/${wantedfile}/${modulelabel}${wantedpath}");

      $filename="delta*vsorb_${modulelabel}${wantedpath}_${wantedfile}_run_${run}.gif";
      draw_plots_indir("${filename}","${datadir}/${wantedfile}/${modulelabel}${wantedpath}");

    }



}

function draw_d0phi($modulelabel,$wantedpath,$wantedfile,$datadir){

    $filename="*_${modulelabel}${wantedpath}_${wantedfile}.gif";
    draw_plots_indir("${filename}","${datadir}/${wantedfile}");

}

function draw_pixelless($modulelabel,$wantedpath,$wantedfile,$datadir){

    $filename="*_${modulelabel}${wantedpath}_${wantedfile}.gif";
    draw_plots_indir("${filename}","${datadir}/${wantedfile}");

}

function draw_pv($modulelabel,$wantedpath,$wantedfile,$datadir){

    $filename="*_${modulelabel}${wantedpath}_${wantedfile}.gif";
    draw_plots_indir("${filename}","${datadir}/${wantedfile}/${modulelabel}${wantedpath}");

    exec("ls ${datadir}/${wantedfile}/${modulelabel}${wantedpath}/pvtxx_${modulelabel}${wantedpath}_${wantedfile}_run_*.gif",$runlist);
    foreach($runlist as $runfile) {

      sscanf($runfile,"${datadir}/${wantedfile}/${modulelabel}${wantedpath}/pvtxx_${modulelabel}${wantedpath}_${wantedfile}_run_%d.gif",$run);
      echo "<H4>Primary Vertex position in run $run </H4>";
      $filename="pvtxx_${modulelabel}${wantedpath}_${wantedfile}_run_${run}.gif pvtxy_${modulelabel}${wantedpath}_${wantedfile}_run_${run}.gif pvtxz_${modulelabel}${wantedpath}_${wantedfile}_run_${run}.gif";
      draw_plots_indir("${filename}","${datadir}/${wantedfile}/${modulelabel}${wantedpath}");

      $filename="pvtx*vsorb_${modulelabel}${wantedpath}_${wantedfile}_run_${run}.gif";
      draw_plots_indir("${filename}","${datadir}/${wantedfile}/${modulelabel}${wantedpath}");

      $filename="nvtxvsorb_${modulelabel}${wantedpath}_${wantedfile}_run_${run}.gif nvtxvsbx_${modulelabel}${wantedpath}_${wantedfile}_run_${run}.gif nvtxvsbxvsorb_${modulelabel}${wantedpath}_${wantedfile}_run_${run}.gif nvtxvsorbsliced_${modulelabel}${wantedpath}_${wantedfile}_run_${run}.gif";
      draw_plots_indir("${filename}","${datadir}/${wantedfile}/${modulelabel}${wantedpath}");
    }


}

function draw_noncollpv($modulelabel,$wantedfile,$datadir){


    $filename="*_${modulelabel}_${wantedfile}.gif";
    draw_plots_indir("${filename}","${datadir}/${wantedfile}/${modulelabel}");

    exec("ls ${datadir}/${wantedfile}/${modulelabel}/pvtxx_${modulelabel}_${wantedfile}_run_*.gif",$runlist);
    foreach($runlist as $runfile) {
      sscanf($runfile,"${datadir}/${wantedfile}/${modulelabel}/pvtxx_${modulelabel}_${wantedfile}_run_%d.gif",$run);
      echo "<H3>Run $run </H3>";
      echo "<h4>Both Beams</h4>";
      
      $filename="pvtxx_${modulelabel}_${wantedfile}_run_${run}.gif pvtxy_${modulelabel}_${wantedfile}_run_${run}.gif pvtxz_${modulelabel}_${wantedfile}_run_${run}.gif";
      draw_plots_indir("${filename}","${datadir}/${wantedfile}/${modulelabel}");
      
      echo "<h4>Beam Plus</h4>";
      
      $filename="pvtxx_${modulelabel}plus_${wantedfile}_run_${run}.gif pvtxy_${modulelabel}plus_${wantedfile}_run_${run}.gif pvtxz_${modulelabel}plus_${wantedfile}_run_${run}.gif";
      draw_plots_indir("${filename}","${datadir}/${wantedfile}/${modulelabel}plus");
      
      echo "<h4>Beam Minus</h4>";
      
      $filename="pvtxx_${modulelabel}minus_${wantedfile}_run_${run}.gif pvtxy_${modulelabel}minus_${wantedfile}_run_${run}.gif pvtxz_${modulelabel}minus_${wantedfile}_run_${run}.gif";
      draw_plots_indir("${filename}","${datadir}/${wantedfile}/${modulelabel}minus");
    }


}
?>