<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="./Includes/Favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./Includes/Favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./Includes/Favicon/favicon-16x16.png">
    <link rel="manifest" href="./Includes/Favicon/site.webmanifest">

    <!-- Font Logo -->
    <link href="https://fonts.googleapis.com/css2?family=Leckerli+One&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./CSS/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./Includes/Font Awesome/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./CSS/style.css">

    <title>Company Directory</title>
  </head>
  <body>
    <div id="modalDiv"></div>

    <!-- Modal Create New -->
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="createTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createTitle">Add To Database</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" id="create-modal-form">
              <div id="alert"></div>
              <div class="form-row">
                <div class="col">
                  <label class="col-form-label" for="fname-create">First Name: </label>
                  <input class="form-control form-control-sm" type="text" name="fname" id="fname-create" required>
                </div>
                <div class="col">
                  <label class="col-form-label" for="lname-create">Last Name: </label>
                  <input class="form-control form-control-sm" type="text" name="lname" id="lname-create" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-12">
                  <label class="col-form-label" for="email-modal-create">Email: </label>
                  <input class="form-control form-control-sm" type="email" name="email" id="email-modal-create" required>
                </div>                
              </div>
              <div class="form-row mb-3">
                <div class="col-6">
                  <label class="col-form-label" for="department-modal-create">Department: </label>
                  <select class="custom-select custom-select-sm" name="department" id="department-modal-create" required>
                    <option selected disabled>Choose Department</option>
                    <option value="1">Human Resources</option>
                    <option value="2">Sales</option>
                    <option value="3">Marketing</option>
                    <option value="4">Legal</option>
                    <option value="5">Services</option>
                    <option value="6">Research and Development</option>
                    <option value="7">Product Management</option>
                    <option value="8">Training</option>
                    <option value="9">Support</option>
                    <option value="10">Engineering</option>
                    <option value="11">Accounting</option>
                    <option value="12">Business Development</option>
                  </select>
                </div>
                <div class="col-6">
                  <label class="col-form-label" for="location-modal-create">Location: </label>
                  <input readonly class="form-control-sm form-control-plaintext" type="text" name="location" id="location-modal-create" value="" required>
                </div>                    
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="add-button">Add</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="bg-dark border-right" id="sidebar-wrapper">
          <div class="sidebar-heading bg-dark text-light font-weight-bold"><i class="h4 far fa-folder-open"></i> Company Directory</div>

          <form action="#" class="text-light ml-2 my-2" method="POST" id="SearchForm">
            
            <!-- Search by location -->
            <p class="h3 text-secondary ml-2 "><i class="fas fa-map-marked-alt"></i> Location</p>
            <label for="London" class="btn btn-default btn-block text-left text-white">London <input type="checkbox" name="by_location[London]" value="1" id="London" class="badgebox"><span class="badge">&check;</span></label>
            <label for="New york" class="btn btn-default btn-block text-left  text-white">New york <input type="checkbox" name="by_location[New york]" value="2" id="New york" class="badgebox"><span class="badge">&check;</span></label>
            <label for="Paris" class="btn btn-default btn-block text-left  text-white">Paris <input type="checkbox" name="by_location[Paris]" value="3" id="Paris" class="badgebox"><span class="badge">&check;</span></label>
            <label for="Munich" class="btn btn-default btn-block text-left  text-white">Munich <input type="checkbox" name="by_location[Munich]" value="4" id="Munich" class="badgebox"><span class="badge">&check;</span></label>
            <label for="Rome" class="btn btn-default btn-block text-left  text-white">Rome <input type="checkbox" name="by_location[Rome]" value="5" id="Rome" class="badgebox"><span class="badge">&check;</span></label>
            
            <!-- Search by department -->
            <p class="h3 text-secondary ml-2 my-4"><i class="fas fa-building"></i> Department</p>
            <label for="Human Resources" class="btn btn-default btn-block text-left text-white">Human Resources <input type="checkbox" name="by_department[Human Resources]" value="1" id="Human Resources" class="badgebox"><span class="badge">&check;</span></label>
            <label for="Sales" class="btn btn-default btn-block text-left text-white">Sales <input type="checkbox" name="by_department[Sales]" value="2" id="Sales" class="badgebox"><span class="badge">&check;</span></label>
            <label for="Marketing" class="btn btn-default btn-block text-left text-white">Marketing <input type="checkbox" name="by_department[Marketing]" value="3" id="Marketing" class="badgebox"><span class="badge">&check;</span></label>
            <label for="Legal" class="btn btn-default btn-block text-left text-white">Legal <input type="checkbox" name="by_department[Legal]" value="4" id="Legal" class="badgebox"><span class="badge">&check;</span></label>
            <label for="Services" class="btn btn-default btn-block text-left text-white">Services <input type="checkbox" name="by_department[Services]" value="5" id="Services" class="badgebox"><span class="badge">&check;</span></label>
            <label for="Research and Development" class="btn btn-default btn-block text-left text-white">Research and Development <input type="checkbox" name="by_department[Research and Development]" value="6" id="Research and Development" class="badgebox"><span class="badge">&check;</span></label>
            <label for="Product Management" class="btn btn-default btn-block text-left text-white">Product Management <input type="checkbox" name="by_department[Product Management]" value="7" id="Product Management" class="badgebox"><span class="badge">&check;</span></label>
            <label for="Training" class="btn btn-default btn-block text-left text-white">Training <input type="checkbox" name="by_department[Training]" value="8" id="Training" class="badgebox"><span class="badge">&check;</span></label>
            <label for="Support" class="btn btn-default btn-block text-left text-white">Support <input type="checkbox" name="by_department[Support]" value="9" id="Support" class="badgebox"><span class="badge">&check;</span></label>
            <label for="Engineering" class="btn btn-default btn-block text-left text-white">Engineering <input type="checkbox" name="by_department[Engineering]" value="10" id="Engineering" class="badgebox"><span class="badge">&check;</span></label>
            <label for="Accounting" class="btn btn-default btn-block text-left text-white">Accounting <input type="checkbox" name="by_department[Accounting]" value="11" id="Accounting" class="badgebox"><span class="badge">&check;</span></label>
            <label for="Business Development" class="btn btn-default btn-block text-left text-white">Business Development <input type="checkbox" name="by_department[Business Development]" value="12" id="Business Development" class="badgebox"><span class="badge">&check;</span></label>
            <button type="submit" class="btn btn-lg btn-primary w-75 mx-3 mt-3">Search</button>
            <button type="reset" class="btn btn-sm btn-secondary w-75 mx-3 mt-4">Reset</button>
          </form>
        </div>
        

        <!-- Page Content -->
        <div id="page-content-wrapper">
          <!-- Navbar -->
          <nav class="navbar navbar-dark bg-dark fixed-top">
            <button class="btn" id="menu-toggle"><span class="navbar-toggler-icon"></span></button>
            <a class="navbar-brand" id="logo" ><img src="./Includes/Favicon/favicon-32x32.png" alt="logo">ompany Directory</a>
            <button class="btn" id="add" data-toggle="modal" data-target="#create"><i class="fas fa-user-plus text-white"></i></button>
          </nav>
    

          <div class="container-fluid">
            <!-- Search input -->
            <form action="" method="post" id="search-form-input">
              <div class="form-group has-search mt-2">
                <span class="fa fa-search form-control-feedback"></span>
                <input type="text" name="q" class="form-control" placeholder="Search" id="searchInput" autocomplete="off">
              </div>
            </form>
            <hr>

            <!-- Grid -->
            <div class="card-deck"></div>
            <nav aria-label="Page navigation">
              <ul class="pagination justify-content-center flex-wrap"></ul>
            </nav>
          </div>
        </div>
    </div>
      

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="./JS/jquery-3.5.1.min.js"></script>
    <script src="./JS/bootstrap.bundle.min.js"></script>
    <script src="./JS/bootstrap.min.js"></script>
    <!-- Custom js -->
    <script src="./JS/main.js"></script>
    <script src="./JS/functions.js"></script>
  </body>
</html>