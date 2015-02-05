<?php
class selection extends NgGadget
{

    function launch()
    {
	 $this->has_css = true;
	 $this->has_js = false;
	 if(!isset($this->nb))
		 $this->nb = 8;
    }
}
?>