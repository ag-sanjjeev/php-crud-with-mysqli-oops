<?php

/*

File: index and list page

    programmer: sanjjeev
    created: 4/9/2019
*/


require_once('dbclass.php');


?>
<html>
    <head>
        <title>CRUD MYSQLI</title>
        <link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/fontawesome/css/all.css" />
        <link rel="stylesheet" href="css/animate.css" />
        <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="purchase.js"></script>       
    </head>
    <body class="container-fluid">
        <header class="row mt-2">
            <div class="col-md-5">
                <h3>CRUD Application</h3>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-5 text-right">
                <a href="create.php"><button class="btn btn-info">ADD&nbsp;<span class="badge badge-light"><i class="fa fa-plus"></i></span></button>
                </a>
            </div>
        </header>
        <hr />
        <section class="row">
            <div class="col-md-12"> 
                <table class="table table-stripped">
                    <thead class="thead-dark">
                        <th>#</th>
                        <th>Date</th>
                        <th>Purchase/INV No</th>
                        <th>Party Name</th>
                        <th>GST No</th>
                        <th>Payment</th>
                        <th>Cash</th>
                        <th>Total</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="entrylist">
                        <?php
                        
                            $purchase = get_purchaselist();
                            echo $purchase['data'];
                            
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </body>
</html>