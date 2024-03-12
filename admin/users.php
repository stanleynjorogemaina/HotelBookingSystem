<?php
   require('inc/essentials.php');
   require('inc/db_config.php');
   adminLogin();
 ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset='utf-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <title>Admin Panel - Users</title>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <?php require('inc/links.php'); ?>
   </head>
   <body class="bg-light">

    <?php require('inc/header.php'); ?>

      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
               <h3 class="mb-4">USERS</h3>

               <div class="card border-0 shadow-sm mb-4">
                  <div class="card-body">
                     
                     <div class="text-end mb-3"> 
                       <input type="text" oninput="search_user(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Type to search">
                     </div>
                     
                     <!-- Add the download button -->
                     <div class="text-end mb-3">
                        <button onclick="downloadPDF()" class="btn btn-primary">Print report</button>
                     </div>

                     <div class="table-responsive">
                        <table class="table table-hover border text-center" style="min-width: 1300px;">
                              <thead>
                                 <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>        
                                    <th scope="col">Phone no.</th>        
                                    <!-- <th scope="col">Location</th>-->
                                    <th scope="col">DOB</th>  
                                    <th scope="col">Verified</th>        
                                    <th scope="col">Status</th>        
                                    <th scope="col">Date</th>   
                                    <th scope="col">Delete user</th>     
                                    <!-- <th scope="col">Action</th>-->
                                 </tr>
                              </thead>
                              <tbody id="users-data">
                                 
                                 <h2>Users data</h2>
                              </tbody>
                        </table>
                     </div>   
                  
                  </div>
               </div>

            </div>
         </div>
      </div> 

    <?php require('inc/script.php'); ?>  

    <script src="scripts/users.js"></script>  

    <!-- Add a reference to the html2pdf library -->
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    

    <script>
      // Function to download the table as PDF
      function downloadPDF() {
         var element = document.getElementById('users-data');
         html2pdf(element);
      }

      html2pdf(element, { filename: filename });
    </script>

   </body>
</html>
