<?php
   require('inc/essentials.php');
   require('inc/db_config.php');
   adminLogin();

   if(isset($_GET['seen']))
   {
      $frm_data = filteration($_GET);

      if(isset($frm_data['seen']) && $frm_data['seen'] =='all'){
         $q = "UPDATE `user_queries` SET `seen`=?";
         $values = [1];
         if(update($q,$values,'i')){
            alert('success','Marked all as read');
         }
         else{
            alert('error','Operation Failed!');
         }
      }
      else if(isset($frm_data['seen']) &&$frm_data['seen'] != ''){
         $q = "UPDATE `user_queries` SET `seen`=? WHERE `sr_no`=?";
         $values = [1,$frm_data['seen']];
         if(update($q,$values,'ii')){
            alert('success','Marked as read');
         }
         else{
            alert('error','Operation Failed!');
         }
      }
   }

   if(isset($_GET['del']))
   {
      $frm_data = filteration($_GET);

      if(isset($frm_data['del']) && $frm_data['del'] =='all'){
         $q = "DELETE FROM `user_queries`";
         if(mysqli_query($con,$q)){
            alert('success','All data deleted!');
         }
         else{
            alert('error','Operation Failed!');
         }
      }
      else if(isset($frm_data['del']) &&$frm_data['del'] != ''){
         $q = "DELETE FROM `user_queries` WHERE `sr_no`=?";
         $values = [$frm_data['del']];
         if(delete($q,$values,'i')){
            alert('success','Data deleted!');
         }
         else{
            alert('error','Operation Failed!');
         }
      }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Admin Panel - User Queries</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

  <?php require('inc/header.php'); ?>

   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">USER QUERIES</h3>

            <div class="card border-0 shadow-sm mb-4">
               <div class="card-body">
                  
                 <div class="text-end mb-4">
                   <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm">
                     <i class="bi bi-check-all"></i> Mark all as read
                  </a>
                   <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm">
                     <i class="bi bi-trash"></i> Delete all read
                  </a>
                 </div>
                 <div class="text-end mb-3">
                        <button onclick="downloadPDF()" class="btn btn-primary">Print report</button>
                     </div>
               <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                 <table class="table table-hover border">
                     <thead class="sticky-top">
                        <tr class="bg-dark text-light">
                           <th scope="col">#</th>
                           <th scope="col">Name</th>
                           <th scope="col">Email</th>
                           <th scope="col" width="20%">Subject</th>
                           <th scope="col" width="30%">Message</th>
                           <th scope="col">Date</th>
                           <th scope="col">Action</th>        
                        </tr>
                     </thead>
                     <tbody id = user-queries>
                       <?php
                          $q= "SELECT * FROM `user_queries` ORDER BY `sr_no` DESC";
                          $data = mysqli_query($con,$q);
                          $i=1;

                           while($row = mysqli_fetch_assoc($data))
                           {
                              $date= date('d-m-Y',strtotime($row['datentime']));
                              $seen='';
                              if($row['seen']!=1){
                                 $seen = "<a href='?seen=$row[sr_no]' class='btn btn-sm rounded-pill btn-primary'>Mark as read</a>";
                              }
                              $seen.="<a href='?del=$row[sr_no]' class='btn btn-sm rounded-pill btn-danger mt-2'>Delete</a>";
                              echo<<<query
                              <tr>
                                 <td>$i</td>
                                 <td>$row[name]</td>
                                 <td>$row[email]</td>
                                 <td>$row[subject]</td>
                                 <td>$row[message]</td>
                                 <td>$date</td>
                                 <td>$seen</td>
                              </tr>
                              query;
                              $i++;
                           }

                       ?>
                    </tbody>
                  </table>
               </div>  
               
               </div>
            </div>


         </div>
      </div>
   </div> 


 <?php require('inc/script.php'); ?>   

 <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
      <script>
      // Function to download the table as PDF
      function downloadPDF() {
         var element = document.getElementById('user-queries');
         html2pdf(element);
      }

      html2pdf(element, { filename: filename });
    </script>

</body>
</html>