<?php
class slider extends NgGadget
{

    function launch()
    {
	 $this->has_css = true;
	 $this->has_js = false;

	 $this->nans = (isset($_SESSION['panier']) && is_array($_SESSION['panier']['qte']))?array_sum($_SESSION['panier']['qte']):0;
    }
}
?>