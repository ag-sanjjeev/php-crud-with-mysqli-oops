<?php

/*

    file: all database based functions for inclusion
    programmer: sanjjeev
    created: 4/9/2019

*/
global $db;

$db = new mysqli('localhost','root','','crud') or die($db->connect_error());

function get_purchase_no()
{
    global $db;
    
    $sql = "SELECT purchase_no FROM purchase WHERE delete_status='0' ORDER BY purchase_no DESC LIMIT 1";
    
    $res = $db->query($sql);
    
    $row = $res->fetch_assoc();
    
    return $row;
}

function get_purchaselist()
{
    global $db;
    
    $sql = "SELECT p1.*,SUM(p2.amount) as total FROM purchase p1 INNER JOIN purchase_sublist p2 ON (p1.purchase_no=p2.purchase_no) WHERE p1.delete_status='0' AND p2.delete_status='0' GROUP BY p2.purchase_no";
    
    $res = $db->query($sql);
    $ser = 1;
    $datalist = '';
    while($key = $res->fetch_assoc())
    {
        $datalist .= '<tr>';
        $datalist .= '<td>'.$ser.'</td>';
        $datalist .= '<td>'.$key['date'].'</td><td>'.$key['purchase_no'].'</td><td>'.$key['party_name'].'</td><td>'.$key['gst_no'].'</td><td>'.$key['payment'].'</td><td>'.$key['cash'].'</td><td>'.$key['total'].'</td>';
        $datalist .= '<td><a href="update.php?id='.$key['id'].'"><i class="fa fa-edit"></i></a><a href="#" onclick="purchase_cu(\''.$key['id'].'\',\'delete\')"><i class="fa fa-trash"></i></a></td></tr>';
        $ser++;
    }
    
    return array('data'=>$datalist,'sql'=>$sql);
}

function get_purchaselist2($id)
{
    global $db;
    
    $sql = "SELECT p1.*,SUM(p2.amount) as total FROM purchase p1 INNER JOIN purchase_sublist p2 ON (p1.purchase_no=p2.purchase_no) WHERE p1.id='".$id."' AND p1.delete_status='0' AND p2.delete_status='0' GROUP BY p2.purchase_no";
    
    $res = $db->query($sql);
    $ser = 1;
    $datalist = '';
    $date = $purchase_no = $party = $gst = $payment = $cash = $ref = $bank = $ifsc = '';
    while($key = $res->fetch_assoc())
    {
        $date = $key['date'];
        $purchase_no = $key['purchase_no'];
        $party = $key['party_name'];
        $gst = $key['gst_no'];
        $payment = $key['payment'];
        $cash = $key['cash'];
        $ref = $key['ref_num'];
        $bank = $key['bank_name'];
        $ifsc = $key['ifsc'];
        $total = $key['total'];
    }
    
    return array('sql'=>$sql,'date'=>$date,'purchase_no'=>$purchase_no,'party'=>$party,'gst'=>$gst,'payment'=>$payment,'cash'=>$cash,'ref'=>$ref,'bank'=>$bank,'ifsc'=>$ifsc,'total'=>$total,'id'=>$id);
}

function purchasesublist($purchase_no)
{
    global $db;
    
    $condition = '';
    $ser = 1;
    $datalist = '';
    $sub_total = 0;
    $row = $key = array();
    if($purchase_no!='')
    {
        $condition = " AND purchase_no='".$purchase_no."'";
    }
    
    $sql = "SELECT * FROM purchase_sublist WHERE delete_status='0'".$condition;
    
    $res = $db->query($sql);    
    
    while($key = $res->fetch_assoc())
    {
        $datalist .= '<tr>';
        $datalist .= '<td>'.$ser.'</td>';
        $datalist .= '<td>'.$key['entry_date'].'</td><td>'.$key['item_name'].'</td><td>'.$key['quantity'].'</td><td>'.$key['rate'].'</td><td>'.$key['tax'].'</td><td>'.$key['discount'].'</td><td>'.$key['amount'].'</td>';
        $datalist .= '<td><a href="#" onclick="purchase_su(\''.$key['sub_id'].'\',\'edit_sub\')"><i class="fa fa-edit"></i></a><a href="#" onclick="purchase_su(\''.$key['sub_id'].'\',\'sub_del\')"><i class="fa fa-trash"></i></a></td></tr>';
        
        $sub_total+=$key['amount'];
        $ser++;
    }
    
    return array('data'=>$datalist,'sub_total'=>$sub_total,'sql'=>$sql);
}

?>