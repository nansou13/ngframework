<?php
class product {
	
	public $id;
	public $ref;
	public $name;
	public $description;
	public $price_const;
	public $price1;
	public $price2;
	public $price3;
	public $priceID;
	public $type;
	public $created_date;
	public $updated_date;
	
	function __construct($productComp = null) {
        if(isset($productComp))
		{
			$nameVarObject = get_object_vars($productComp);
			foreach ($nameVarObject as $key=>$value) {
				$this->$key = $value;
			}
		}
    }
    
}
?>