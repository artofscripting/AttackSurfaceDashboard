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
    <div class="main-panel" style="background-color: #191923;">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">Attack Surface Dashboard</a>
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
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon" style="background: linear-gradient(60deg, #76080e, #bc3030);
    box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgb(255 0 0 / 40%);">
                    <i class="material-icons">offline_bolt</i>
                  </div>
                  <p class="card-category">Vulnerabilities</p>
                  <h3 class="card-title"><?PHP $vulnerabilities = file_get_contents($server . '/dashboard/parts/getvulnlmh.php?ns='.$GLOBALS["namespaceCompany"], false, stream_context_create($arrContextOptions));
echo $vulnerabilities; ?>
                    
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons text-danger">warning</i>
                    <a href="javascript:;">Vulnerabilities over 7 days</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon" style="background: linear-gradient(60deg, #76080e, #bc3030);">
                    <i class="material-icons">store</i>
                  </div>
                  <p class="card-category">All Findings</p>
                  <h3 class="card-title"><?PHP $vulnerabilities = file_get_contents($server . '/dashboard/parts/getvulnallcount.php?ns='.$GLOBALS["namespaceCompany"], false, stream_context_create($arrContextOptions));
echo $vulnerabilities; ?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Last 7 Days OpenVas Scans
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon" style="background: linear-gradient(60deg, #76080e, #bc3030);">
                    <i class="material-icons">info_outline</i>
                  </div>
                  <p class="card-category">IP Count</p>
                  <h3 class="card-title"><?PHP $vulnerabilities = file_get_contents($server . '/dashboard/parts/getvulnipcount.php?ns='.$GLOBALS["namespaceCompany"], false, stream_context_create($arrContextOptions));
echo $vulnerabilities; ?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">local_offer</i> IPs scanned by OpenVas last 24hrs
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon" style="background: linear-gradient(60deg, #76080e, #bc3030);">
                    <i class="material-icons">open_with</i>
                  </div>
                  <p class="card-category">Vulnerable Ports</p>
                  <h3 class="card-title"><?PHP $vulnerabilities = file_get_contents($server . '/dashboard/parts/getvulnportcount.php?ns='.$GLOBALS["namespaceCompany"], false, stream_context_create($arrContextOptions));
echo $vulnerabilities; ?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i> IP and Port count by OpenVas
                  </div>
                </div>
              </div>
            </div>
          </div>
          
		  <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon"  >
                  <div class="card-icon" style="background: linear-gradient(60deg, #76080e, #bc3030);">
                    <i class="material-icons" >search</i>
                  </div>
                  <p class="card-category">Domains Detected </p>
                  <h3 class="card-title"><?PHP $vulnerabilities = file_get_contents($server . '/dashboard/parts/getdomainscount.php?ns='.$GLOBALS["namespaceCompany"], false, stream_context_create($arrContextOptions));
echo $vulnerabilities; ?><br>
                    <small></small>
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons text-danger">warning</i>
                   Daily Amass Scans
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon" style="background: linear-gradient(60deg, #76080e, #bc3030);">
                    <i class="material-icons">search_off</i>
                  </div>
                  <p class="card-category">Down Detection rate</p>
                  <h3 class="card-title"><?PHP $vulnerabilities = file_get_contents($server . '/dashboard/parts/getdowndetectorcount.php?ns='.$GLOBALS["namespaceCompany"], false, stream_context_create($arrContextOptions));
echo $vulnerabilities; ?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Last 15 mins compared to the last 24 hrs
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon" style="background: linear-gradient(60deg, #76080e, #bc3030);">
                    <i class="material-icons">fact_check</i>
                  </div>
                  <p class="card-category">Monitored Hosts</p>
                  <h3 class="card-title"><?PHP $vulnerabilities = file_get_contents($server . '/dashboard/parts/getmonhostscount.php?ns='.$GLOBALS["namespaceCompany"], false, stream_context_create($arrContextOptions));
echo $vulnerabilities; ?>
				  
				  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">local_offer</i> Total tracked by masscan monitoring 24hrs
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon" style="background: linear-gradient(60deg, #76080e, #bc3030);">
                    <i class="material-icons">fingerprint</i>
                  </div>
                  <p class="card-category">SSL Vulnerabilities</p>
                  <h3 class="card-title"><?PHP $vulnerabilities = file_get_contents($server . '/dashboard/parts/getvulnsslcount.php?ns='.$GLOBALS["namespaceCompany"], false, stream_context_create($arrContextOptions));
echo $vulnerabilities; ?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i> Tracked by OpenVas Scans
                  </div>
                </div>
              </div>
            </div>
          </div>
          
		  
		  <div class="row">
        
           
            <div class="col-md-12"">
              <div class="card">
                <div class="card-header card-header-warning">
                  <h4 class="card-title">Vulnerablities</h4>
                  <p class="card-category">OpenVas Scored findings </p>
                </div>
                <div class="card-body table-responsive">
                  <?PHP $vulnerabilities = file_get_contents($server . '/dashboard/parts/getvulnipportsevtable.php?ns='.$GLOBALS["namespaceCompany"], false, stream_context_create($arrContextOptions));
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