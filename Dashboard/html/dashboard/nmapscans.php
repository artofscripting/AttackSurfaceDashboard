<?PHP
include("./parts/head.php");

?>
<?PHP
include("./parts/nav.php");
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
); 
?>      
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">Domain Dashboard</a>
          </div>
         <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            
            <ul class="navbar-nav">
             
            </ul>
          </div>
         
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
        
			<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-warning">
                  <h4 class="card-title">Highlighted Nmap Results</h4>
                  <p class="card-category">Nmap scanning</p>
                </div>
                <div class="card-body table-responsive">
                  <?PHP $vulnerabilities = file_get_contents($server . '/dashboard/parts/getnmapsum.php?ns='.$GLOBALS["namespaceCompany"], false, stream_context_create($arrContextOptions));
echo $vulnerabilities; ?>
                </div>
              </div>
            </div>
          </div>
		  <div class="row">
        
			<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-warning">
                  <h4 class="card-title">Nmap Results</h4>
                  <p class="card-category">Nmap scanning</p>
                </div>
                <div class="card-body table-responsive">
                  <?PHP $vulnerabilities = file_get_contents($server . '/dashboard/parts/getnmapresults.php?ns='.$GLOBALS["namespaceCompany"], false, stream_context_create($arrContextOptions));
echo $vulnerabilities; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     
  

	
<?PHP
include("./parts/foot.php");

?> 