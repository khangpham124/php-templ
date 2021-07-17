<?php
require('fpdf.php');
include($_SERVER["DOCUMENT_ROOT"] . "/projects/storage/app_config.php");
include(LOAD_PATH."/wp-load.php");

$code = $_GET['code'];
$type = $_GET['type'];
$mypost = get_page_by_title( $code ,OBJECT, $type);

$userID = $_COOKIE['user_id'];
$user_parent = $_COOKIE['paren_user'];
if($user_parent!='') {
    $agencyId =	$user_parent;
} else {
    $agencyId =	$userID;
}

class PDF extends FPDF
{

    function Header()
    {
        // Logo
        $this->Image('logo.png',4,8,20);
        // Arial bold 15
        $this->SetFont('Arial','B',14);
        // Move to the right
        $this->Cell(150);
        // Title
        $this->Cell(40,10,'Storage',0,0,R);
        
        $this->Cell(0,25,"Phone:855-562-2532",0,0,R);
        
        $this->Cell(0,35,"Email:mail@mail.com",0,0,R);
        // Line break
        $this->Ln(20);   
        $this->SetFillColor(240,240,240);
    }

    function InfoInvoice()
    {
        // $this->SetFont('Arial','',12);
        // // Background color
        // $this->SetFillColor(146,200,62);
        // // Title
        // $this->Ln(10);
        // $this->Cell(0,6,"Invoice No:" ,0,1,'L',true);
        // // Line break
        // $this->Ln(0);
        // $this->Cell(0,6,"Date No:",0,1,'L',true);
        // $this->Ln(0);
        // $this->Cell(0,6,"Term:",0,1,'L',true);
        // $this->Ln(0);
        // $this->Cell(0,6,"Due Date:",0,1,'L',true);
        // $this->Ln(1);
    }

    function UserInvoice($from,$item,$arrives)
    {
        // Read text file
        $this->SetFont('Arial','',12);
        // // Background color
        $this->SetFillColor(240,240,240);
        // // Title
        $this->Ln(10);
        $this->Cell(0,6,"Origin:" . $from ,0,1,'L',true);
        // // Line break
        $this->Ln(0);
        $this->Cell(0,6,"Item Pallets:" . $item,0,1,'L',true);
        $this->Ln(0);
        $this->Cell(0,6,"Product arrives:" . $arrives ,0,1,'L',true);
        $this->Ln(10);

    }

    function BodyInvoice($code)
    {
        
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    

    // Simple table
    function BasicTable($header, $code, $agencyId)
    {
        $listProdut = get_field('list_products',$agencyId);
        $my_listProdut = get_field('my_products',$agencyId);
        // Header
        foreach($header as $col)
            $this->Cell(60,10,$col,1);
        $this->Ln();
        // Data
        while(has_sub_field('list_package',$code)):
            if(get_sub_field('origin',$code) == 'default' ) { 
                $name_product = $listProdut[get_sub_field('sku',$code) - 1 ]['name'];
            } else { 
                $name_product = $my_listProdut[get_sub_field('sku',$code) - 1]['name'];
            }
            $this->Cell(60,10,$name_product,1);
            $this->Cell(60,10,get_sub_field('quanlity',$code),1);
            $this->Cell(60,10,get_sub_field('quantity_real',$code),1);
            $this->Ln();
        endwhile;
        $this->Ln(10);
        
    }



}

$pdf = new PDF();
// Column headings
$header = array('Product name', 'Quantity', 'Checked');
// Data loading
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->InfoInvoice($mypost->ID);
$pdf->UserInvoice(get_field('from',$mypost->ID),get_field('item_pallets',$mypost->ID),get_field('product_arrives',$mypost->ID));
$pdf->Ln(10);
$pdf->BasicTable($header,$mypost->ID,$agencyId);
$pdf->Output();
?>