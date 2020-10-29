<?php 

/*

    file name crud.php
    programmer: sanjjeev
    created: 4/9/2019

*/

require_once('dbclass.php');

$action = '';

$status = $error = $data = '';
$sub_total = 0;
$data1 = array();

if($_POST['action']!='')
{
    $action = $_POST['action'];
}

switch($action)
{
    case 'add_sub':
        
        $sql = "INSERT INTO purchase_sublist(entry_date,purchase_no,item_name,quantity,rate,tax,discount,amount) VALUES('".$_POST['entry_date']."','".$_POST['purchase_no']."','".$_POST['item_name']."','".$_POST['quantity']."','".$_POST['rate']."','".$_POST['tax']."','".$_POST['discount']."','".$_POST['sub_total']."')";
        
        $res = $db->query($sql);
        
        if($res)
        {
            $status = 'Successfully Added';
            $data1 = purchasesublist($_POST['purchase_no']);
            $data = $data1['data'];
            $sub_total = $data1['sub_total'];
        }
        else
        {
            $error = $db->error_info();
        }
        
        echo json_encode(array('data'=>$data,'sub_total'=>$sub_total,'status'=>$status,'error'=>$error,'sql'=>$sql));
        
    break;
        
    case 'sub_del':
        $id = '';
        $id = $_POST['id'];
        $sql = "UPDATE purchase_sublist SET delete_status='1' WHERE sub_id='$id'";
        
        $res = $db->query($sql);
        
        if($res)
        {
            $status = 'Successfully Deleted';
            $data1 = purchasesublist($_POST['purchase_no']);
            $data = $data1['data'];            
            $sub_total = $data1['sub_total'];
            
        }
        else
        {
            $error = $db->error_info();
        }
        
        echo json_encode(array('data'=>$data,'sub_total'=>$sub_total,'status'=>$status,'error'=>$error,'sql'=>$sql.$id));
        
    break;
        
    case 'edit_sub':
        $id = '';
        $id = $_POST['id'];
        $sql = "SELECT * FROM purchase_sublist WHERE sub_id='$id'";
        
        $res = $db->query($sql);
        
        if($res)
        {
            while($key = $res->fetch_assoc())
            {
                $item_name = $key['item_name'];
                $quantity = $key['quantity'];
                $tax = $key['tax'];
                $rate = $key['rate'];
                $discount = $key['discount'];
                $total = $key['amount'];
            }
        }
        else
        {
            $error = $db->error_info();
        }
        
        echo json_encode(array('item'=>$item_name,'quantity'=>$quantity,'tax'=>$tax,'rate'=>$rate,'discount'=>$discount,'total'=>$total,'id'=>$id,'error'=>$error));
        
    break;
        
    case 'update_sub':
        $id = '';
        $id = $_POST['id'];
        $sql = "UPDATE purchase_sublist SET item_name='".$_POST['item_name']."', quantity='".$_POST['quantity']."',rate='".$_POST['rate']."',tax='".$_POST['tax']."',discount='".$_POST['discount']."',amount='".$_POST['sub_total']."' WHERE sub_id='$id'";
        
        $res = $db->query($sql);
        
        if($res)
        {
            $status = 'Successfully Updated';
            $data1 = purchasesublist($_POST['purchase_no']);
            $data = $data1['data'];  
            $sub_total = $data1['sub_total'];
        }
        else
        {
            $error = $db->error_info();
        }        
        echo json_encode(array('data'=>$data,'sub_total'=>$sub_total,'status'=>$status,'error'=>$error,'sql'=>$sql.$id));
        
    break;
        
    case 'save':
        
        $sql = "INSERT INTO purchase(date,purchase_no,party_name,gst_no,payment,cash,ref_num,bank_name,ifsc,total) VALUES('".$_POST['entry_date']."', '".$_POST['purchase_no']."', '".$_POST['party_name']."', '".$_POST['gst_no']."', '".$_POST['payment']."', '".$_POST['cash']."', '".$_POST['ref_num']."', '".$_POST['bank_name']."', '".$_POST['ifsc']."', 0)";
        
        $res = $db->query($sql);
        
        if($res)
        {
            $status = 'Successfully Added';
        }
        else
        {
            $error = $db->error_info();
        }
        
        echo json_encode(array('data'=>$data,'status'=>$status,'error'=>$error,'sql'=>$sql));
        
    break;  
    
    case 'update':
        
        $sql = "UPDATE purchase SET party_name='".$_POST['party_name']."', gst_no='".$_POST['gst_no']."', payment='".$_POST['payment']."', cash='".$_POST['cash']."', ref_num='".$_POST['ref_num']."', bank_name='".$_POST['bank_name']."', ifsc='".$_POST['ifsc']."' WHERE purchase_no='".$_POST['purchase_no']."'";
        
        $res = $db->query($sql);
        
        if($res)
        {
            $status = 'Successfully Updated';
        }
        else
        {
            $error = $db->error_info();
        }
        
        echo json_encode(array('data'=>$data,'status'=>$status,'error'=>$error,'sql'=>$sql));
        
    break; 
    
    case 'delete':
        
        $sql = "UPDATE purchase SET delete_status='1' WHERE id='".$_POST['id']."'";
        
        $sql .= "UPDATE purchase_sublist SET delete_status='1' WHERE purchase_no='".$_POST['purchase_no']."'";
        
        $res = $db->query($sql);
        
        if($res)
        {
            $status = 'Successfully Delete';
        }
        else
        {
            $error = $db->error_info();
        }
        
        echo json_encode(array('data'=>$data,'status'=>$status,'error'=>$error,'sql'=>$sql));
        
    break;  
}

?>