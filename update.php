<?php

/*
    filename update.php
    programmer: sanjjeev
    created: 4/9/2019
*/

require_once('dbclass.php');

$purchaselist = array();

if($_GET['id']!='')
{
    $updateid = $_GET['id'];
    $purchaselist = get_purchaselist2($updateid);
    $date = $purchaselist['date'];
    $id = $purchaselist['id'];
    $purchase_no = $purchaselist['purchase_no'];
    $party = $purchaselist['party'];
    $cash = $purchaselist['cash'];
    $gst_no = $purchaselist['gst'];
    $payment = $purchaselist['payment'];
    $ref = $purchaselist['ref'];
    $bank = $purchaselist['bank'];
    $ifsc = $purchaselist['ifsc'];
}

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
                <a href="index.php"><button class="btn btn-info">Back&nbsp;<span class="badge badge-light"><i class="fa fa-arrow-left"></i></span></button>
                </a>
            </div>
        </header>
        <hr />
        <form name="purchaseentry" method="post">
        <section class="row">
            <div class="col-md-12">
                
                    <div class="row p-4 justify-content-center">
                        <div class="form-group col-md-3">
                            <label for="entry_date">Entry Date</label>
                            <input type="date" name="entry_date" id="entry_date" class="form-control" value="<?php echo $date; ?>" readonly/>     
                        </div>
                        <div class="form-group col-md-3">
                             <label for="purhase_no">Purchase No</label>
                             <input type="text" name="purchase_no" id="purchase_no" class="form-control" value="<?php echo $purchase_no; ?>" readonly/>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="party_name">Party Name</label> 
                            <input type="text" name="party_name" id="party_name" value="<?php echo $party; ?>" class="form-control"  />
                        </div>
                        <div class="form-group col-md-3">
                            <label for="gst_no">GST No</label>
                            <input type="text" name="gst_no" id="gst_no" value="<?php echo $gst_no; ?>" class="form-control"  />
                        </div>                        
                    </div>
                    <div class="row p-4 justify-content-center">
                        <div class="form-group col-md-3">
                            <label for="item_name">Item Name</label>
                            <input type="text" name="item_name" id="item_name" class="form-control"  />
                        </div>
                        <div class="form-group col-md-3">
                            <label for="quantity">Quantity</label>
                            <input type="number" min="0" name="quantity" id="quantity" class="form-control" value="0"/>     
                        </div>
                        <div class="form-group col-md-3">
                             <label for="tax">Tax</label>
                             <select name="tax" id="tax" class="form-control"  >
                                <option value="">Select</option>
                                <option value="5.00">5%</option>
                                <option value="12.00">12%</option>
                                <option value="18.00">18%</option>
                                <option value="28.00">28%</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="rate">Rate</label> 
                            <input type="number" min="0" name="rate" id="rate" value="0" class="form-control"  />
                        </div>                        
                    </div>
                    <div class="row p-4 justify-content-center">                        
                        <div class="form-group col-md-3">
                            <label for="discount">Discount</label> 
                            <input type="number" min="0" name="discount" id="discount" value="0" class="form-control"  />
                        </div>
                        <div class="form-group col-md-3">
                            <label for="sub_total">Total</label>
                            <input type="number" name="sub_total" id="sub_total" value="" class="form-control"  readonly/>
                        </div>
                        <div class="col-md-3">
                            
                        </div>
                        <div class="col-md-3">
                            
                        </div>
                    </div>
                    <div class="row">
                        <a href="#" class="btn btn-outline-success ml-4" id="addbtn"  onclick="purchase_su('','add_sub')">Add</a>
                    </div>                
            </div>
        </section>
        <section class="row mt-4">
            <div class="col-md-12"> 
                <table class="table table-stripped">
                    <thead class="thead-dark">
                        <th>#</th>
                        <th>Date</th>
                        <th>Item Name</th>                        
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Tax</th>
                        <th>Discount</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="entrylist">
                        <?php
                        $data = array();
                        $sub_total = '';
                        $data = purchasesublist($purchase_no);                        
                        $sub_total = $data['sub_total'];
                        echo $data['data'];                        
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <div class="row mt-4 justify-content-center">
            <section class="col-md-6 text-left">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="payment">Payment</label>
                        <select class="form-control" name="payment" id="payment"  >
                            <option value="cash" <?php if($payment=='cash'){echo 'selected';}  ?>>Cash</option>
                            <option value="check" <?php if($payment=='check'){echo 'selected';}  ?>>Check</option>
                            <option value="bank" <?php if($payment=='bank'){echo 'selected';}  ?>>Bank</option>
                            <option value="online" <?php if($payment=='online'){echo 'selected';}  ?>>Online</option>
                        </select>    
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cash">Cash</label>
                        <input type="number" name="cash" id="cash" value="<?php echo $cash; ?>" class="form-control"  />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="ref_num">Check / Ref.No</label>
                        <input type="text" name="ref_num" id="ref_num" value="<?php echo $ref; ?>" class="form-control"  />
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="bank_name">Bank Name</label>
                        <input type="text" name="bank_name" id="bank_name" value="<?php echo $bank; ?>" class="form-control"  />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="ifsc">IFSC</label>
                        <input type="text" name="ifsc" id="ifsc" value="<?php echo $ifsc; ?>" class="form-control"  />
                    </div>
                </div>
            </section>
            <aside class="col-md-6 text-right">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 form-group">
                        <label for="total">Total</label>
                        <input type="number" name="total" id="total" value="<?php echo $sub_total; ?>" class="form-control" readonly/>
                    </div>
                </div>
            </aside>
        </div>        
    </form>
        <div class="row justify-content-center my-4">
            <div class="col-md-1">
                <a href="#" class="btn btn-outline-success" onclick="purchase_cu('<?php echo $purchase_no; ?>','update')">Update</a> 
            </div>
            <div class="col-md-1">
                <a href="index.php"><button class="btn btn-outline-danger">Cancel</button></a>
            </div>
        </div>
    </body>
</html>