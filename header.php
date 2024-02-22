      <!-- Page Header Start-->
      <div class="page-main-header">
          <div class="main-header-right">
              <div class="main-header-left text-center">
                  <div class="logo-wrapper"><a href="index.php"><img src="./assets/images/logo.png" height="80" style=" object-fit: coverว"></a></div>
              </div>
              <div class="vertical-mobile-sidebar"><i class="fa fa-bars sidebar-bar"></i></div>
              <div class="nav-right col pull-right right-menu">
                  <ul class="nav-menus">
                      <li>
                      </li>

                      <li class="onhover-dropdown"> <span class="media user-header"><img class="img-fluid" src="assets/images/dashboard/user.png" alt=""></span>
                          <ul class="onhover-show-div profile-dropdown">
                              <li class="gradient-primary">
                                  <p class="f-w-600 mb-0"><?php echo $_SESSION['user_fullName']; ?></p>
                              </li>
                              <a href="logout.php">
                                  <li><i data-feather="settings"> </i>Logout</li>
                              </a>
                          </ul>
                      </li>
                  </ul>
                  <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
              </div>
              <script id="result-template" type="text/x-handlebars-template">
                  <div class="ProfileCard u-cf">                        
            <div class="ProfileCard-avatar"><i class="pe-7s-home"></i></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName">{{name}}</div>
            </div>
            </div>
          </script>
              <script id="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
          </div>
      </div>
      <!-- Page Header Ends                              -->