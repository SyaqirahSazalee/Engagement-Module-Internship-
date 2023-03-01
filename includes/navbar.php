
<div id="sidebar-wrapper">
  <style type="text/css">
    #navbar::-webkit-scrollbar {
        display: none;
    }

    #navbar {
      -ms-overflow-style: none; 
      scrollbar-width: none; 
    }

    .border-3 {
      border-width:5px !important;
    }

    .radius{
      border-top-right-radius: 50px;
      border-bottom-right-radius: 50px;
    }
  </style>
  <?php
  if($resultresult->superadmin){
  ?>
  <div class="list-group list-group-flush" id="navbar" style="overflow-y: scroll; height: 200px;">
    <a class="list-group-item list-group-item-light border-0"><b><?php echo $array['home'];?></b></a>
    <a href="home-dashboard.php?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="superadmindashboardtab">
      <div class="row">
        <div class="col-2"><i class="fa fa-dashboard"></i></div>
        <div class="col">Super Admin Dashboard</div>
      </div>
    </a>
  </div>
  <?php
  }else{
  ?>

  <?php
  if($resultresult->corporateID){
    $corporateobject = new Corporate();
    $corporateresult = $corporateobject->searchCorporate($resultresult->corporateID);
    if($corporateresult){
      if($corporateresult->package === "Trial"){
        $navbarpackage = "Trial";
      }elseif($corporateresult->package === "Free"){
        $navbarpackage = "Free";
      }elseif($corporateresult->package === "Basic"){
        $navbarpackage = "Basic";
      }elseif($corporateresult->package === "Pro"){
        $navbarpackage = "Pro";
      }elseif($corporateresult->package === "Business"){
        $navbarpackage = "Business";
      }elseif($corporateresult->package === "Enterprise"){
        $navbarpackage = "Enterprise";
      }
    }
  }else{
    $companyobject = new Company();
    $companyresult = $companyobject->searchCompany($resultresult->companyID);
    if($companyresult){
      if($companyresult->package === "Trial"){
        $navbarpackage = "Trial";
      }elseif($companyresult->package === "Free"){
        $navbarpackage = "Free";
      }elseif($companyresult->package === "Basic"){
        $navbarpackage = "Basic";
      }elseif($companyresult->package === "Pro"){
        $navbarpackage = "Pro";
      }elseif($companyresult->package === "Business"){
        $navbarpackage = "Business";
      }elseif($companyresult->package === "Enterprise"){
        $navbarpackage = "Enterprise";
      }
    }
  }
  ?>

  <div class="list-group list-group-flush" id="navbar" style="overflow-y: auto;">

    <a class="list-group-item list-group-item-light border-0"></a>
    <a href="home-dashboard?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="dashboardtab">
      <div class="row">
        <div class="col-2"><i class="fa fa-dashboard"></i></div>
        <div class="col"><?php echo $array['dashboard'];?></div>
      </div>
    </a>
    <?php


    if($navbarpackage === "Basic" || $navbarpackage === "Pro" || $navbarpackage === "Business" || $navbarpackage === "Enterprise"){
      ?>
      <a href="home-calendar?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="calendartab">
        <div class="row">
          <div class="col-2"><i class="fa fa-calendar"></i></div>
          <div class="col">Calendar</div>
        </div>
      </a>
      <a href="home-engagement?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="engagementtab">
        <div class="row">
            <div class="col-2">
              <i class="fa fa-handshake-o"></i>
            </div>
            <div class="col">Engagement</div>
        </div>
      </a>

      <a href="home-engagement?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="home-engagetab">
        <div class="row">
            <div class="col-2"></div>
            <div class="col">Home</div>
        </div>
      </a>

      <a href="analytics-engagement?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="analytics-engagetab">
        <div class="row">
            <div class="col-2"></div>
            <div class="col">Analytics</div>
        </div>
      </a>

      <a href="company-engagement?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="company-engagetab">
        <div class="row">
            <div class="col-2"></div>
            <div class="col">Company</div>
        </div>
      </a>

      <a href="user-engagement?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="user-engagetab">
        <div class="row">
            <div class="col-2"></div>
            <div class="col">User</div>
        </div>
      </a>

      <a href="recog-engagement?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="recog-engagetab">
        <div class="row">
            <div class="col-2"></div>
            <div class="col">Recognition</div>
        </div>
      </a>


      <?php
    }


    ?>





    <a class="list-group-item list-group-item-light border-0"></a>
  </div>
  <?php
  }
  ?>
</div>

  



