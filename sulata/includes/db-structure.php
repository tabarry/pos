<?php
     $dbs_sulata_blank = 
        array(
        
            '__ID_req'=>'*',
            '__ID_title'=>'ID',
            '__ID_max'=>'11',
            '__ID_validateas'=>'int',
            '__ID_html5_req'=>'required',
            '__ID_html5_type'=>'text',
            
            
            '__Last_Action_On_req'=>'*',
            '__Last_Action_On_title'=>'Last Action On',
            '__Last_Action_On_max'=>'',
            '__Last_Action_On_validateas'=>'required',
            '__Last_Action_On_html5_req'=>'required',
            '__Last_Action_On_html5_type'=>'text',
            
            
            '__Last_Action_By_req'=>'*',
            '__Last_Action_By_title'=>'Last Action By',
            '__Last_Action_By_max'=>'64',
            '__Last_Action_By_validateas'=>'required',
            '__Last_Action_By_html5_req'=>'required',
            '__Last_Action_By_html5_type'=>'text',
            
            
            '__dbState_req'=>'*',
            '__dbState_title'=>'dbState',
            '__dbState_max'=>'',
            '__dbState_validateas'=>'enum',
            '__dbState_html5_req'=>'required',
            '__dbState_html5_type'=>'text',
            '__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );
    
    $dbs_sulata_categories = 
        array(
        
            'category__ID_req'=>'*',
            'category__ID_title'=>'ID',
            'category__ID_max'=>'11',
            'category__ID_validateas'=>'int',
            'category__ID_html5_req'=>'required',
            'category__ID_html5_type'=>'text',
            
            
            'category__Category_req'=>'*',
            'category__Category_title'=>'Category',
            'category__Category_max'=>'128',
            'category__Category_validateas'=>'required',
            'category__Category_html5_req'=>'required',
            'category__Category_html5_type'=>'text',
            
            
            'category__Last_Action_On_req'=>'*',
            'category__Last_Action_On_title'=>'Last Action On',
            'category__Last_Action_On_max'=>'',
            'category__Last_Action_On_validateas'=>'required',
            'category__Last_Action_On_html5_req'=>'required',
            'category__Last_Action_On_html5_type'=>'text',
            
            
            'category__Last_Action_By_req'=>'*',
            'category__Last_Action_By_title'=>'Last Action By',
            'category__Last_Action_By_max'=>'64',
            'category__Last_Action_By_validateas'=>'required',
            'category__Last_Action_By_html5_req'=>'required',
            'category__Last_Action_By_html5_type'=>'text',
            
            
            'category__dbState_req'=>'*',
            'category__dbState_title'=>'dbState',
            'category__dbState_max'=>'',
            'category__dbState_validateas'=>'enum',
            'category__dbState_html5_req'=>'required',
            'category__dbState_html5_type'=>'text',
            'category__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );
    
    $dbs_sulata_locations = 
        array(
        
            'location__ID_req'=>'*',
            'location__ID_title'=>'ID',
            'location__ID_max'=>'11',
            'location__ID_validateas'=>'int',
            'location__ID_html5_req'=>'required',
            'location__ID_html5_type'=>'text',
            
            
            'location__Location_req'=>'*',
            'location__Location_title'=>'Location',
            'location__Location_max'=>'100',
            'location__Location_validateas'=>'required',
            'location__Location_html5_req'=>'required',
            'location__Location_html5_type'=>'text',
            
            
            'location__Last_Action_On_req'=>'*',
            'location__Last_Action_On_title'=>'Last Action On',
            'location__Last_Action_On_max'=>'',
            'location__Last_Action_On_validateas'=>'required',
            'location__Last_Action_On_html5_req'=>'required',
            'location__Last_Action_On_html5_type'=>'text',
            
            
            'location__Last_Action_By_req'=>'*',
            'location__Last_Action_By_title'=>'Last Action By',
            'location__Last_Action_By_max'=>'64',
            'location__Last_Action_By_validateas'=>'required',
            'location__Last_Action_By_html5_req'=>'required',
            'location__Last_Action_By_html5_type'=>'text',
            
            
            'location__dbState_req'=>'*',
            'location__dbState_title'=>'dbState',
            'location__dbState_max'=>'',
            'location__dbState_validateas'=>'enum',
            'location__dbState_html5_req'=>'required',
            'location__dbState_html5_type'=>'text',
            'location__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );
    
    $dbs_sulata_menu_details = 
        array(
        
            'menudetail__ID_req'=>'*',
            'menudetail__ID_title'=>'ID',
            'menudetail__ID_max'=>'11',
            'menudetail__ID_validateas'=>'int',
            'menudetail__ID_html5_req'=>'required',
            'menudetail__ID_html5_type'=>'text',
            
            
            'menudetail__Menu_req'=>'*',
            'menudetail__Menu_title'=>'Menu',
            'menudetail__Menu_max'=>'11',
            'menudetail__Menu_validateas'=>'int',
            'menudetail__Menu_html5_req'=>'required',
            'menudetail__Menu_html5_type'=>'text',
            
            
            'menudetail__Product_req'=>'*',
            'menudetail__Product_title'=>'Product',
            'menudetail__Product_max'=>'11',
            'menudetail__Product_validateas'=>'int',
            'menudetail__Product_html5_req'=>'required',
            'menudetail__Product_html5_type'=>'text',
            
            
            'menudetail__Product_Price_req'=>'*',
            'menudetail__Product_Price_title'=>'Product Price',
            'menudetail__Product_Price_max'=>'',
            'menudetail__Product_Price_validateas'=>'required',
            'menudetail__Product_Price_html5_req'=>'required',
            'menudetail__Product_Price_html5_type'=>'text',
            
            
            'menudetail__Last_Action_On_req'=>'*',
            'menudetail__Last_Action_On_title'=>'Last Action On',
            'menudetail__Last_Action_On_max'=>'',
            'menudetail__Last_Action_On_validateas'=>'required',
            'menudetail__Last_Action_On_html5_req'=>'required',
            'menudetail__Last_Action_On_html5_type'=>'text',
            
            
            'menudetail__Last_Action_By_req'=>'*',
            'menudetail__Last_Action_By_title'=>'Last Action By',
            'menudetail__Last_Action_By_max'=>'64',
            'menudetail__Last_Action_By_validateas'=>'required',
            'menudetail__Last_Action_By_html5_req'=>'required',
            'menudetail__Last_Action_By_html5_type'=>'text',
            
            
            'menudetail__dbState_req'=>'*',
            'menudetail__dbState_title'=>'dbState',
            'menudetail__dbState_max'=>'',
            'menudetail__dbState_validateas'=>'enum',
            'menudetail__dbState_html5_req'=>'required',
            'menudetail__dbState_html5_type'=>'text',
            'menudetail__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );
    
    $dbs_sulata_menus = 
        array(
        
            'menu__ID_req'=>'*',
            'menu__ID_title'=>'ID',
            'menu__ID_max'=>'11',
            'menu__ID_validateas'=>'int',
            'menu__ID_html5_req'=>'required',
            'menu__ID_html5_type'=>'text',
            
            
            'menu__Title_req'=>'*',
            'menu__Title_title'=>'Title',
            'menu__Title_max'=>'100',
            'menu__Title_validateas'=>'required',
            'menu__Title_html5_req'=>'required',
            'menu__Title_html5_type'=>'text',
            
            
            'menu__Status_req'=>'*',
            'menu__Status_title'=>'Status',
            'menu__Status_max'=>'',
            'menu__Status_validateas'=>'enum',
            'menu__Status_html5_req'=>'required',
            'menu__Status_html5_type'=>'text',
            'menu__Status_array'=>array(''=>'Select..','Active'=>'Active','Inactive'=>'Inactive',),
            
            'menu__Last_Action_On_req'=>'*',
            'menu__Last_Action_On_title'=>'Last Action On',
            'menu__Last_Action_On_max'=>'',
            'menu__Last_Action_On_validateas'=>'required',
            'menu__Last_Action_On_html5_req'=>'required',
            'menu__Last_Action_On_html5_type'=>'text',
            
            
            'menu__Last_Action_By_req'=>'*',
            'menu__Last_Action_By_title'=>'Last Action By',
            'menu__Last_Action_By_max'=>'64',
            'menu__Last_Action_By_validateas'=>'required',
            'menu__Last_Action_By_html5_req'=>'required',
            'menu__Last_Action_By_html5_type'=>'text',
            
            
            'menu__dbState_req'=>'*',
            'menu__dbState_title'=>'dbState',
            'menu__dbState_max'=>'',
            'menu__dbState_validateas'=>'enum',
            'menu__dbState_html5_req'=>'required',
            'menu__dbState_html5_type'=>'text',
            'menu__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );
    
    $dbs_sulata_notices = 
        array(
        
            'notice__ID_req'=>'*',
            'notice__ID_title'=>'ID',
            'notice__ID_max'=>'11',
            'notice__ID_validateas'=>'int',
            'notice__ID_html5_req'=>'required',
            'notice__ID_html5_type'=>'text',
            
            
            'notice__Subject_req'=>'*',
            'notice__Subject_title'=>'Subject',
            'notice__Subject_max'=>'128',
            'notice__Subject_validateas'=>'required',
            'notice__Subject_html5_req'=>'required',
            'notice__Subject_html5_type'=>'text',
            
            
            'notice__Notice_req'=>'*',
            'notice__Notice_title'=>'Notice',
            'notice__Notice_max'=>'',
            'notice__Notice_validateas'=>'required',
            'notice__Notice_html5_req'=>'required',
            'notice__Notice_html5_type'=>'text',
            
            
            'notice__Last_Action_On_req'=>'*',
            'notice__Last_Action_On_title'=>'Last Action On',
            'notice__Last_Action_On_max'=>'',
            'notice__Last_Action_On_validateas'=>'required',
            'notice__Last_Action_On_html5_req'=>'required',
            'notice__Last_Action_On_html5_type'=>'text',
            
            
            'notice__Last_Action_By_req'=>'*',
            'notice__Last_Action_By_title'=>'Last Action By',
            'notice__Last_Action_By_max'=>'64',
            'notice__Last_Action_By_validateas'=>'required',
            'notice__Last_Action_By_html5_req'=>'required',
            'notice__Last_Action_By_html5_type'=>'text',
            
            
            'notice__dbState_req'=>'*',
            'notice__dbState_title'=>'dbState',
            'notice__dbState_max'=>'',
            'notice__dbState_validateas'=>'enum',
            'notice__dbState_html5_req'=>'required',
            'notice__dbState_html5_type'=>'text',
            'notice__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );
    
    $dbs_sulata_order_counter = 
        array(
        
            'order_count_req'=>'*',
            'order_count_title'=>'order count',
            'order_count_max'=>'',
            'order_count_validateas'=>'required',
            'order_count_html5_req'=>'required',
            'order_count_html5_type'=>'text',
            
            
            'order_count_date_req'=>'*',
            'order_count_date_title'=>'order count date',
            'order_count_date_max'=>'',
            'order_count_date_validateas'=>'required',
            'order_count_date_html5_req'=>'required',
            'order_count_date_html5_type'=>'text',
            
            
        );
    
    $dbs_sulata_order_details = 
        array(
        
            'orderdet__ID_req'=>'*',
            'orderdet__ID_title'=>'ID',
            'orderdet__ID_max'=>'11',
            'orderdet__ID_validateas'=>'int',
            'orderdet__ID_html5_req'=>'required',
            'orderdet__ID_html5_type'=>'text',
            
            
            'orderdet__Order_req'=>'*',
            'orderdet__Order_title'=>'Order',
            'orderdet__Order_max'=>'11',
            'orderdet__Order_validateas'=>'int',
            'orderdet__Order_html5_req'=>'required',
            'orderdet__Order_html5_type'=>'text',
            
            
            'orderdet__Product_req'=>'*',
            'orderdet__Product_title'=>'Product',
            'orderdet__Product_max'=>'11',
            'orderdet__Product_validateas'=>'int',
            'orderdet__Product_html5_req'=>'required',
            'orderdet__Product_html5_type'=>'text',
            
            
            'orderdet__Code_req'=>'*',
            'orderdet__Code_title'=>'Code',
            'orderdet__Code_max'=>'50',
            'orderdet__Code_validateas'=>'required',
            'orderdet__Code_html5_req'=>'required',
            'orderdet__Code_html5_type'=>'text',
            
            
            'orderdet__Name_req'=>'*',
            'orderdet__Name_title'=>'Name',
            'orderdet__Name_max'=>'128',
            'orderdet__Name_validateas'=>'required',
            'orderdet__Name_html5_req'=>'required',
            'orderdet__Name_html5_type'=>'text',
            
            
            'orderdet__Price_req'=>'*',
            'orderdet__Price_title'=>'Price',
            'orderdet__Price_max'=>'',
            'orderdet__Price_validateas'=>'required',
            'orderdet__Price_html5_req'=>'required',
            'orderdet__Price_html5_type'=>'text',
            
            
            'orderdet__Quantity_req'=>'*',
            'orderdet__Quantity_title'=>'Quantity',
            'orderdet__Quantity_max'=>'11',
            'orderdet__Quantity_validateas'=>'int',
            'orderdet__Quantity_html5_req'=>'required',
            'orderdet__Quantity_html5_type'=>'text',
            
            
            'orderdet__Last_Action_On_req'=>'*',
            'orderdet__Last_Action_On_title'=>'Last Action On',
            'orderdet__Last_Action_On_max'=>'',
            'orderdet__Last_Action_On_validateas'=>'required',
            'orderdet__Last_Action_On_html5_req'=>'required',
            'orderdet__Last_Action_On_html5_type'=>'text',
            
            
            'orderdet__Last_Action_By_req'=>'*',
            'orderdet__Last_Action_By_title'=>'Last Action By',
            'orderdet__Last_Action_By_max'=>'64',
            'orderdet__Last_Action_By_validateas'=>'required',
            'orderdet__Last_Action_By_html5_req'=>'required',
            'orderdet__Last_Action_By_html5_type'=>'text',
            
            
            'orderdet__dbState_req'=>'*',
            'orderdet__dbState_title'=>'dbState',
            'orderdet__dbState_max'=>'',
            'orderdet__dbState_validateas'=>'enum',
            'orderdet__dbState_html5_req'=>'required',
            'orderdet__dbState_html5_type'=>'text',
            'orderdet__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );
    
    $dbs_sulata_orders = 
        array(
        
            'order__ID_req'=>'*',
            'order__ID_title'=>'ID',
            'order__ID_max'=>'11',
            'order__ID_validateas'=>'int',
            'order__ID_html5_req'=>'required',
            'order__ID_html5_type'=>'text',
            
            
            'order__UID_req'=>'*',
            'order__UID_title'=>'UID',
            'order__UID_max'=>'27',
            'order__UID_validateas'=>'required',
            'order__UID_html5_req'=>'required',
            'order__UID_html5_type'=>'text',
            
            
            'order__Number_req'=>'*',
            'order__Number_title'=>'Number',
            'order__Number_max'=>'11',
            'order__Number_validateas'=>'int',
            'order__Number_html5_req'=>'required',
            'order__Number_html5_type'=>'text',
            
            
            'order__Customer_Name_req'=>'*',
            'order__Customer_Name_title'=>'Customer Name',
            'order__Customer_Name_max'=>'50',
            'order__Customer_Name_validateas'=>'required',
            'order__Customer_Name_html5_req'=>'required',
            'order__Customer_Name_html5_type'=>'text',
            
            
            'order__Mobile_Number_req'=>'',
            'order__Mobile_Number_title'=>'Mobile Number',
            'order__Mobile_Number_max'=>'12',
            'order__Mobile_Number_validateas'=>'',
            'order__Mobile_Number_html5_req'=>'',
            'order__Mobile_Number_html5_type'=>'text',
            
            
            'order__Date_req'=>'*',
            'order__Date_title'=>'Date',
            'order__Date_max'=>'',
            'order__Date_validateas'=>'required',
            'order__Date_html5_req'=>'required',
            'order__Date_html5_type'=>'text',
            
            
            'order__Total_Amount_req'=>'*',
            'order__Total_Amount_title'=>'Total Amount',
            'order__Total_Amount_max'=>'',
            'order__Total_Amount_validateas'=>'required',
            'order__Total_Amount_html5_req'=>'required',
            'order__Total_Amount_html5_type'=>'text',
            
            
            'order__Discount_req'=>'*',
            'order__Discount_title'=>'Discount',
            'order__Discount_max'=>'',
            'order__Discount_validateas'=>'required',
            'order__Discount_html5_req'=>'required',
            'order__Discount_html5_type'=>'text',
            
            
            'order__Discount_Type_req'=>'',
            'order__Discount_Type_title'=>'Discount Type',
            'order__Discount_Type_max'=>'',
            'order__Discount_Type_validateas'=>'enum',
            'order__Discount_Type_html5_req'=>'',
            'order__Discount_Type_html5_type'=>'text',
            'order__Discount_Type_array'=>array(''=>'Select..','percentage'=>'percentage','flat'=>'flat',),
            
            'order__Cash_Recieved_req'=>'*',
            'order__Cash_Recieved_title'=>'Cash Recieved',
            'order__Cash_Recieved_max'=>'',
            'order__Cash_Recieved_validateas'=>'required',
            'order__Cash_Recieved_html5_req'=>'required',
            'order__Cash_Recieved_html5_type'=>'text',
            
            
            'order__Tax_req'=>'*',
            'order__Tax_title'=>'Tax',
            'order__Tax_max'=>'',
            'order__Tax_validateas'=>'required',
            'order__Tax_html5_req'=>'required',
            'order__Tax_html5_type'=>'text',
            
            
            'order__Tax_Value_req'=>'*',
            'order__Tax_Value_title'=>'Tax Value',
            'order__Tax_Value_max'=>'5',
            'order__Tax_Value_validateas'=>'required',
            'order__Tax_Value_html5_req'=>'required',
            'order__Tax_Value_html5_type'=>'text',
            
            
            'order__Notes_req'=>'',
            'order__Notes_title'=>'Notes',
            'order__Notes_max'=>'',
            'order__Notes_validateas'=>'',
            'order__Notes_html5_req'=>'',
            'order__Notes_html5_type'=>'text',
            
            
            'order__Status_req'=>'*',
            'order__Status_title'=>'Status',
            'order__Status_max'=>'',
            'order__Status_validateas'=>'enum',
            'order__Status_html5_req'=>'required',
            'order__Status_html5_type'=>'text',
            'order__Status_array'=>array(''=>'Select..','Being Ordered'=>'Being Ordered','Received'=>'Received','Delivered'=>'Delivered','Cancelled'=>'Cancelled',),
            
            'order__Promo_Code_req'=>'',
            'order__Promo_Code_title'=>'Promo Code',
            'order__Promo_Code_max'=>'32',
            'order__Promo_Code_validateas'=>'',
            'order__Promo_Code_html5_req'=>'',
            'order__Promo_Code_html5_type'=>'text',
            
            
            'order__Session_req'=>'*',
            'order__Session_title'=>'Session',
            'order__Session_max'=>'32',
            'order__Session_validateas'=>'required',
            'order__Session_html5_req'=>'required',
            'order__Session_html5_type'=>'text',
            
            
            'order__Location_req'=>'*',
            'order__Location_title'=>'Location',
            'order__Location_max'=>'11',
            'order__Location_validateas'=>'int',
            'order__Location_html5_req'=>'required',
            'order__Location_html5_type'=>'text',
            
            
            'order__Last_Action_On_req'=>'*',
            'order__Last_Action_On_title'=>'Last Action On',
            'order__Last_Action_On_max'=>'',
            'order__Last_Action_On_validateas'=>'required',
            'order__Last_Action_On_html5_req'=>'required',
            'order__Last_Action_On_html5_type'=>'text',
            
            
            'order__Last_Action_By_req'=>'*',
            'order__Last_Action_By_title'=>'Last Action By',
            'order__Last_Action_By_max'=>'64',
            'order__Last_Action_By_validateas'=>'required',
            'order__Last_Action_By_html5_req'=>'required',
            'order__Last_Action_By_html5_type'=>'text',
            
            
            'order__dbState_req'=>'*',
            'order__dbState_title'=>'dbState',
            'order__dbState_max'=>'',
            'order__dbState_validateas'=>'enum',
            'order__dbState_html5_req'=>'required',
            'order__dbState_html5_type'=>'text',
            'order__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );
    
    $dbs_sulata_products = 
        array(
        
            'product__ID_req'=>'*',
            'product__ID_title'=>'ID',
            'product__ID_max'=>'11',
            'product__ID_validateas'=>'int',
            'product__ID_html5_req'=>'required',
            'product__ID_html5_type'=>'text',
            
            
            'product__Category_req'=>'*',
            'product__Category_title'=>'Category',
            'product__Category_max'=>'11',
            'product__Category_validateas'=>'int',
            'product__Category_html5_req'=>'required',
            'product__Category_html5_type'=>'text',
            
            
            'product__Picture_req'=>'',
            'product__Picture_title'=>'Picture',
            'product__Picture_max'=>'128',
            'product__Picture_validateas'=>'image',
            'product__Picture_html5_req'=>'',
            'product__Picture_html5_type'=>'file',
            
            
            'product__Code_req'=>'*',
            'product__Code_title'=>'Code',
            'product__Code_max'=>'50',
            'product__Code_validateas'=>'required',
            'product__Code_html5_req'=>'required',
            'product__Code_html5_type'=>'text',
            
            
            'product__Name_req'=>'*',
            'product__Name_title'=>'Name',
            'product__Name_max'=>'128',
            'product__Name_validateas'=>'required',
            'product__Name_html5_req'=>'required',
            'product__Name_html5_type'=>'text',
            
            
            'product__Cost_Price_req'=>'*',
            'product__Cost_Price_title'=>'Cost Price',
            'product__Cost_Price_max'=>'',
            'product__Cost_Price_validateas'=>'required',
            'product__Cost_Price_html5_req'=>'required',
            'product__Cost_Price_html5_type'=>'text',
            
            
            'product__Price_req'=>'*',
            'product__Price_title'=>'Price',
            'product__Price_max'=>'',
            'product__Price_validateas'=>'required',
            'product__Price_html5_req'=>'required',
            'product__Price_html5_type'=>'text',
            
            
            'product__Description_req'=>'',
            'product__Description_title'=>'Description',
            'product__Description_max'=>'',
            'product__Description_validateas'=>'',
            'product__Description_html5_req'=>'',
            'product__Description_html5_type'=>'text',
            
            
            'product__Status_req'=>'*',
            'product__Status_title'=>'Status',
            'product__Status_max'=>'',
            'product__Status_validateas'=>'enum',
            'product__Status_html5_req'=>'required',
            'product__Status_html5_type'=>'text',
            'product__Status_array'=>array(''=>'Select..','Available'=>'Available','Unavailable'=>'Unavailable','Discontinued'=>'Discontinued',),
            
            'product__Last_Action_On_req'=>'*',
            'product__Last_Action_On_title'=>'Last Action On',
            'product__Last_Action_On_max'=>'',
            'product__Last_Action_On_validateas'=>'required',
            'product__Last_Action_On_html5_req'=>'required',
            'product__Last_Action_On_html5_type'=>'text',
            
            
            'product__Last_Action_By_req'=>'*',
            'product__Last_Action_By_title'=>'Last Action By',
            'product__Last_Action_By_max'=>'64',
            'product__Last_Action_By_validateas'=>'required',
            'product__Last_Action_By_html5_req'=>'required',
            'product__Last_Action_By_html5_type'=>'text',
            
            
            'product__dbState_req'=>'*',
            'product__dbState_title'=>'dbState',
            'product__dbState_max'=>'',
            'product__dbState_validateas'=>'enum',
            'product__dbState_html5_req'=>'required',
            'product__dbState_html5_type'=>'text',
            'product__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );
    
    $dbs_sulata_promotional_codes = 
        array(
        
            'promotionalcode__ID_req'=>'*',
            'promotionalcode__ID_title'=>'ID',
            'promotionalcode__ID_max'=>'11',
            'promotionalcode__ID_validateas'=>'int',
            'promotionalcode__ID_html5_req'=>'required',
            'promotionalcode__ID_html5_type'=>'text',
            
            
            'promotionalcode__Code_req'=>'*',
            'promotionalcode__Code_title'=>'Code',
            'promotionalcode__Code_max'=>'255',
            'promotionalcode__Code_validateas'=>'required',
            'promotionalcode__Code_html5_req'=>'required',
            'promotionalcode__Code_html5_type'=>'text',
            
            
            'promotionalcode__Validity_req'=>'*',
            'promotionalcode__Validity_title'=>'Validity',
            'promotionalcode__Validity_max'=>'',
            'promotionalcode__Validity_validateas'=>'required',
            'promotionalcode__Validity_html5_req'=>'required',
            'promotionalcode__Validity_html5_type'=>'text',
            
            
            'promotionalcode__Type_req'=>'*',
            'promotionalcode__Type_title'=>'Type',
            'promotionalcode__Type_max'=>'',
            'promotionalcode__Type_validateas'=>'enum',
            'promotionalcode__Type_html5_req'=>'required',
            'promotionalcode__Type_html5_type'=>'text',
            'promotionalcode__Type_array'=>array(''=>'Select..','percentage'=>'percentage','flat'=>'flat',),
            
            'promotionalcode__Value_req'=>'*',
            'promotionalcode__Value_title'=>'Value',
            'promotionalcode__Value_max'=>'',
            'promotionalcode__Value_validateas'=>'required',
            'promotionalcode__Value_html5_req'=>'required',
            'promotionalcode__Value_html5_type'=>'text',
            
            
            'promotionalcode__Active_req'=>'*',
            'promotionalcode__Active_title'=>'Active',
            'promotionalcode__Active_max'=>'',
            'promotionalcode__Active_validateas'=>'enum',
            'promotionalcode__Active_html5_req'=>'required',
            'promotionalcode__Active_html5_type'=>'text',
            'promotionalcode__Active_array'=>array(''=>'Select..','Active'=>'Active','Inactive'=>'Inactive',),
            
            'promotionalcode__Last_Action_On_req'=>'*',
            'promotionalcode__Last_Action_On_title'=>'Last Action On',
            'promotionalcode__Last_Action_On_max'=>'',
            'promotionalcode__Last_Action_On_validateas'=>'required',
            'promotionalcode__Last_Action_On_html5_req'=>'required',
            'promotionalcode__Last_Action_On_html5_type'=>'text',
            
            
            'promotionalcode__Last_Action_By_req'=>'*',
            'promotionalcode__Last_Action_By_title'=>'Last Action By',
            'promotionalcode__Last_Action_By_max'=>'64',
            'promotionalcode__Last_Action_By_validateas'=>'required',
            'promotionalcode__Last_Action_By_html5_req'=>'required',
            'promotionalcode__Last_Action_By_html5_type'=>'text',
            
            
            'promotionalcode__dbState_req'=>'*',
            'promotionalcode__dbState_title'=>'dbState',
            'promotionalcode__dbState_max'=>'',
            'promotionalcode__dbState_validateas'=>'enum',
            'promotionalcode__dbState_html5_req'=>'required',
            'promotionalcode__dbState_html5_type'=>'text',
            'promotionalcode__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );
    
    $dbs_sulata_raw_materials = 
        array(
        
            'rawmaterial__ID_req'=>'*',
            'rawmaterial__ID_title'=>'ID',
            'rawmaterial__ID_max'=>'11',
            'rawmaterial__ID_validateas'=>'int',
            'rawmaterial__ID_html5_req'=>'required',
            'rawmaterial__ID_html5_type'=>'text',
            
            
            'rawmaterial__Material_req'=>'*',
            'rawmaterial__Material_title'=>'Material',
            'rawmaterial__Material_max'=>'100',
            'rawmaterial__Material_validateas'=>'required',
            'rawmaterial__Material_html5_req'=>'required',
            'rawmaterial__Material_html5_type'=>'text',
            
            
            'rawmaterial__Unit_req'=>'*',
            'rawmaterial__Unit_title'=>'Unit',
            'rawmaterial__Unit_max'=>'',
            'rawmaterial__Unit_validateas'=>'enum',
            'rawmaterial__Unit_html5_req'=>'required',
            'rawmaterial__Unit_html5_type'=>'text',
            'rawmaterial__Unit_array'=>array(''=>'Select..','Each'=>'Each','Grams'=>'Grams',),
            
            'rawmaterial__Last_Action_On_req'=>'*',
            'rawmaterial__Last_Action_On_title'=>'Last Action On',
            'rawmaterial__Last_Action_On_max'=>'',
            'rawmaterial__Last_Action_On_validateas'=>'required',
            'rawmaterial__Last_Action_On_html5_req'=>'required',
            'rawmaterial__Last_Action_On_html5_type'=>'text',
            
            
            'rawmaterial__Last_Action_By_req'=>'*',
            'rawmaterial__Last_Action_By_title'=>'Last Action By',
            'rawmaterial__Last_Action_By_max'=>'64',
            'rawmaterial__Last_Action_By_validateas'=>'required',
            'rawmaterial__Last_Action_By_html5_req'=>'required',
            'rawmaterial__Last_Action_By_html5_type'=>'text',
            
            
            'rawmaterial__dbState_req'=>'*',
            'rawmaterial__dbState_title'=>'dbState',
            'rawmaterial__dbState_max'=>'',
            'rawmaterial__dbState_validateas'=>'enum',
            'rawmaterial__dbState_html5_req'=>'required',
            'rawmaterial__dbState_html5_type'=>'text',
            'rawmaterial__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );
    
    $dbs_sulata_settings = 
        array(
        
            'setting__ID_req'=>'*',
            'setting__ID_title'=>'ID',
            'setting__ID_max'=>'11',
            'setting__ID_validateas'=>'int',
            'setting__ID_html5_req'=>'required',
            'setting__ID_html5_type'=>'text',
            
            
            'setting__Setting_req'=>'*',
            'setting__Setting_title'=>'Setting',
            'setting__Setting_max'=>'64',
            'setting__Setting_validateas'=>'required',
            'setting__Setting_html5_req'=>'required',
            'setting__Setting_html5_type'=>'text',
            
            
            'setting__Key_req'=>'*',
            'setting__Key_title'=>'Key',
            'setting__Key_max'=>'64',
            'setting__Key_validateas'=>'required',
            'setting__Key_html5_req'=>'required',
            'setting__Key_html5_type'=>'text',
            
            
            'setting__Value_req'=>'*',
            'setting__Value_title'=>'Value',
            'setting__Value_max'=>'256',
            'setting__Value_validateas'=>'required',
            'setting__Value_html5_req'=>'required',
            'setting__Value_html5_type'=>'text',
            
            
            'setting__Type_req'=>'*',
            'setting__Type_title'=>'Type',
            'setting__Type_max'=>'',
            'setting__Type_validateas'=>'enum',
            'setting__Type_html5_req'=>'required',
            'setting__Type_html5_type'=>'text',
            'setting__Type_array'=>array(''=>'Select..','Private'=>'Private','Public'=>'Public','Site'=>'Site',),
            
            'setting__Last_Action_On_req'=>'*',
            'setting__Last_Action_On_title'=>'Last Action On',
            'setting__Last_Action_On_max'=>'',
            'setting__Last_Action_On_validateas'=>'required',
            'setting__Last_Action_On_html5_req'=>'required',
            'setting__Last_Action_On_html5_type'=>'text',
            
            
            'setting__Last_Action_By_req'=>'*',
            'setting__Last_Action_By_title'=>'Last Action By',
            'setting__Last_Action_By_max'=>'64',
            'setting__Last_Action_By_validateas'=>'required',
            'setting__Last_Action_By_html5_req'=>'required',
            'setting__Last_Action_By_html5_type'=>'text',
            
            
            'setting__dbState_req'=>'*',
            'setting__dbState_title'=>'dbState',
            'setting__dbState_max'=>'',
            'setting__dbState_validateas'=>'enum',
            'setting__dbState_html5_req'=>'required',
            'setting__dbState_html5_type'=>'text',
            'setting__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );
    
    $dbs_sulata_uploads = 
        array(
        
            'upload__ID_req'=>'*',
            'upload__ID_title'=>'ID',
            'upload__ID_max'=>'11',
            'upload__ID_validateas'=>'int',
            'upload__ID_html5_req'=>'required',
            'upload__ID_html5_type'=>'text',
            
            
            'upload__Title_req'=>'*',
            'upload__Title_title'=>'Title',
            'upload__Title_max'=>'128',
            'upload__Title_validateas'=>'required',
            'upload__Title_html5_req'=>'required',
            'upload__Title_html5_type'=>'text',
            
            
            'upload__Picture_req'=>'*',
            'upload__Picture_title'=>'Picture',
            'upload__Picture_max'=>'255',
            'upload__Picture_validateas'=>'image',
            'upload__Picture_html5_req'=>'required',
            'upload__Picture_html5_type'=>'file',
            
            
            'upload__Last_Action_On_req'=>'*',
            'upload__Last_Action_On_title'=>'Last Action On',
            'upload__Last_Action_On_max'=>'',
            'upload__Last_Action_On_validateas'=>'required',
            'upload__Last_Action_On_html5_req'=>'required',
            'upload__Last_Action_On_html5_type'=>'text',
            
            
            'upload__Last_Action_By_req'=>'*',
            'upload__Last_Action_By_title'=>'Last Action By',
            'upload__Last_Action_By_max'=>'64',
            'upload__Last_Action_By_validateas'=>'required',
            'upload__Last_Action_By_html5_req'=>'required',
            'upload__Last_Action_By_html5_type'=>'text',
            
            
            'upload__dbState_req'=>'*',
            'upload__dbState_title'=>'dbState',
            'upload__dbState_max'=>'',
            'upload__dbState_validateas'=>'enum',
            'upload__dbState_html5_req'=>'required',
            'upload__dbState_html5_type'=>'text',
            'upload__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );
    
    $dbs_sulata_users = 
        array(
        
            'user__ID_req'=>'*',
            'user__ID_title'=>'ID',
            'user__ID_max'=>'11',
            'user__ID_validateas'=>'int',
            'user__ID_html5_req'=>'required',
            'user__ID_html5_type'=>'text',
            
            
            'user__Name_req'=>'*',
            'user__Name_title'=>'Name',
            'user__Name_max'=>'32',
            'user__Name_validateas'=>'required',
            'user__Name_html5_req'=>'required',
            'user__Name_html5_type'=>'text',
            
            
            'user__Phone_req'=>'',
            'user__Phone_title'=>'Phone',
            'user__Phone_max'=>'32',
            'user__Phone_validateas'=>'',
            'user__Phone_html5_req'=>'',
            'user__Phone_html5_type'=>'text',
            
            
            'user__Email_req'=>'*',
            'user__Email_title'=>'Email',
            'user__Email_max'=>'64',
            'user__Email_validateas'=>'email',
            'user__Email_html5_req'=>'required',
            'user__Email_html5_type'=>'email',
            
            
            'user__Password_req'=>'*',
            'user__Password_title'=>'Password',
            'user__Password_max'=>'64',
            'user__Password_validateas'=>'password',
            'user__Password_html5_req'=>'required',
            'user__Password_html5_type'=>'password',
            
            
            'user__Status_req'=>'*',
            'user__Status_title'=>'Status',
            'user__Status_max'=>'',
            'user__Status_validateas'=>'enum',
            'user__Status_html5_req'=>'required',
            'user__Status_html5_type'=>'text',
            'user__Status_array'=>array(''=>'Select..','Active'=>'Active','Inactive'=>'Inactive',),
            
            'user__Picture_req'=>'',
            'user__Picture_title'=>'Picture',
            'user__Picture_max'=>'128',
            'user__Picture_validateas'=>'image',
            'user__Picture_html5_req'=>'',
            'user__Picture_html5_type'=>'file',
            
            
            'user__Type_req'=>'*',
            'user__Type_title'=>'Type',
            'user__Type_max'=>'',
            'user__Type_validateas'=>'enum',
            'user__Type_html5_req'=>'required',
            'user__Type_html5_type'=>'text',
            'user__Type_array'=>array(''=>'Select..','Admin'=>'Admin','User'=>'User',),
            
            'user__Notes_req'=>'',
            'user__Notes_title'=>'Notes',
            'user__Notes_max'=>'',
            'user__Notes_validateas'=>'',
            'user__Notes_html5_req'=>'',
            'user__Notes_html5_type'=>'text',
            
            
            'user__Theme_req'=>'*',
            'user__Theme_title'=>'Theme',
            'user__Theme_max'=>'24',
            'user__Theme_validateas'=>'required',
            'user__Theme_html5_req'=>'required',
            'user__Theme_html5_type'=>'text',
            
            
            'user__Last_Action_On_req'=>'*',
            'user__Last_Action_On_title'=>'Last Action On',
            'user__Last_Action_On_max'=>'',
            'user__Last_Action_On_validateas'=>'required',
            'user__Last_Action_On_html5_req'=>'required',
            'user__Last_Action_On_html5_type'=>'text',
            
            
            'user__Last_Action_By_req'=>'*',
            'user__Last_Action_By_title'=>'Last Action By',
            'user__Last_Action_By_max'=>'64',
            'user__Last_Action_By_validateas'=>'required',
            'user__Last_Action_By_html5_req'=>'required',
            'user__Last_Action_By_html5_type'=>'text',
            
            
            'user__dbState_req'=>'*',
            'user__dbState_title'=>'dbState',
            'user__dbState_max'=>'',
            'user__dbState_validateas'=>'enum',
            'user__dbState_html5_req'=>'required',
            'user__dbState_html5_type'=>'text',
            'user__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
            'user__IP_req'=>'*',
            'user__IP_title'=>'IP',
            'user__IP_max'=>'15',
            'user__IP_validateas'=>'required',
            'user__IP_html5_req'=>'required',
            'user__IP_html5_type'=>'text',
            
            
        );
    
    $dbs_sulata_videos = 
        array(
        
            'video__ID_req'=>'*',
            'video__ID_title'=>'ID',
            'video__ID_max'=>'11',
            'video__ID_validateas'=>'int',
            'video__ID_html5_req'=>'required',
            'video__ID_html5_type'=>'text',
            
            
            'video__Title_req'=>'*',
            'video__Title_title'=>'Title',
            'video__Title_max'=>'128',
            'video__Title_validateas'=>'required',
            'video__Title_html5_req'=>'required',
            'video__Title_html5_type'=>'text',
            
            
            'video__Code_req'=>'*',
            'video__Code_title'=>'Code',
            'video__Code_max'=>'',
            'video__Code_validateas'=>'required',
            'video__Code_html5_req'=>'required',
            'video__Code_html5_type'=>'text',
            
            
            'video__Sequence_req'=>'*',
            'video__Sequence_title'=>'Sequence',
            'video__Sequence_max'=>'11',
            'video__Sequence_validateas'=>'int',
            'video__Sequence_html5_req'=>'required',
            'video__Sequence_html5_type'=>'text',
            
            
            'video__Last_Action_On_req'=>'*',
            'video__Last_Action_On_title'=>'Last Action On',
            'video__Last_Action_On_max'=>'',
            'video__Last_Action_On_validateas'=>'required',
            'video__Last_Action_On_html5_req'=>'required',
            'video__Last_Action_On_html5_type'=>'text',
            
            
            'video__Last_Action_By_req'=>'*',
            'video__Last_Action_By_title'=>'Last Action By',
            'video__Last_Action_By_max'=>'64',
            'video__Last_Action_By_validateas'=>'required',
            'video__Last_Action_By_html5_req'=>'required',
            'video__Last_Action_By_html5_type'=>'text',
            
            
            'video__dbState_req'=>'*',
            'video__dbState_title'=>'dbState',
            'video__dbState_max'=>'',
            'video__dbState_validateas'=>'enum',
            'video__dbState_html5_req'=>'required',
            'video__dbState_html5_type'=>'text',
            'video__dbState_array'=>array(''=>'Select..','Live'=>'Live','Deleted'=>'Deleted',),
            
        );
    
    $uniqueArray = array('category__Category','menu__Title','notice__Subject','order__UID','product__Name','setting__Setting','setting__Key','upload__Title','user__Email');