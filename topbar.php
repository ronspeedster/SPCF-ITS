<!-- Topbar -->
 <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top" style="background-color: #424242 !important;">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" style="color: white; display: block;">
            <i class="fa fa-bars"></i>
          </button>

          <div class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block">
            </div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown" style="white-space: normal;">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-white mr-2 d-none d-lg-inline text-white-600 medium"><?php echo ucfirst($_SESSION['username']); ?></span><i class="text-white fas fa-user-circle"></i>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-600"></i>
                  Logout
                </a>
              </div>
            </li>
          </div>
        </nav>
        <!-- End of Topbar -->