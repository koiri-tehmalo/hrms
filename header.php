  <header class="main-header">
    <!-- Logo 50x50 pixels -->
    <a href="#" class="logo">
      <span class="logo-mini"><b>Hr</b></span>
      <span class="logo-lg"><b>Hr</b></span>
    </a>
    
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
                   
          <!-- User Account: style can be found in dropdown.less -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs">ยินดีต้อนรับ : <?php echo $record['First_name'];?> <?php echo $record['Last_name'];?> </span>
              <!--<span class="fa fa-angle-double-down" style="padding-left: 20px;"></span>-->
            </a>

            <!--<ul class="dropdown-menu">
              <li class="user-footer">
                <div class="pull-right">
                  <a href="edit_profile.php" class="btn btn-flat" style="color: #000">เปลี่ยนแปลงรหัสผ่าน</a>
                </div>
              </li>
            </ul>-->
          </li>
		  <li class="header"><a href="change_password.php" ><span class="fa fa-lock"></span> เปลี่ยนรหัสผ่าน</a></li>
          <li class="header"><a href="logout.php"><span class="fa fa-power-off"></span> ออกจากระบบ</a></li>


      </div>
    </nav>
  </header>