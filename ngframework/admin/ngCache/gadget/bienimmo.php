<div class="productlisting"><h4 style="color: #558C8A;text-align: center;"><?php echo $valueBien->nom;?></h4><div class="imgpl">
<?php

if ($valueBien->online==0) {
?>
<img width="280" height="142" src="/LD/IM/globals/livre.png" style="position: absolute;"/>
<?php

}

?>
<a href="/programmes/detail/<?php echo $valueBien->id;?>/<?php echo $valueBien->urltext;?>.html"><img width="280" height="142" src="/LD/IM/globals/neufimg/<?php echo $valueBien->id;?>/01.jpg"/></a></div><div style="background-color: #D0D8DF;padding: 20px;margin-top: 8px;">
<?php

if ($valueBien->online==1) {
?>
<div class="" style="height: 27px;line-height: 27px;vertical-align: middle;"><img src="/LD/IM/globals/localisation1.png" style="float: left;margin-right: 10px;width: 15px;"/>
	<?php echo $valueBien->ville;?> - <?php echo $valueBien->quartier;?>
</div><div style="margin-top:5px; height: 22px; line-height: 22px; vertical-align: middle;"><img src="/LD/IM/globals/cle.png" style="width: 20px; float: left; margin-right: 6px;"/> <?php echo $valueBien->date_livraison;?>
</div><div style="margin-top:5px; height: 23px; line-height: 23px; vertical-align: middle;"><img src="/LD/IM/globals/maison.png" style="width: 20px; float: left; margin-right: 6px;"/>
	<?php echo $valueBien->nbre_lot;?> Appartements restants</div><div style="margin-top:5px; height: 19px; line-height: 19px; vertical-align: middle;"><img src="/LD/IM/globals/apn.png" style="width: 22px; float: left; margin-right: 6px;"/>
	+ d'images
</div><div style="font-size: 17px;font-weight: bold;height: 27px;line-height: 27px;vertical-align: middle;"><img src="/LD/IM/globals/euro.png" style="width: 20px; float: left; margin-right: 6px;"/>A partir de : <?php echo $valueBien->prix;?> &euro;</div><div style="margin-top: 15px; text-align: center;"><a class="btnbienimmo" href="/programmes/detail/<?php echo $valueBien->id;?>/<?php echo $valueBien->urltext;?>.html">+ de detail</a></div>
<?php

}else{
?>
<div class="" style="height: 165px;line-height: 27px;vertical-align: middle;"><img src="/LD/IM/globals/exclam.jpg" style="float: left;margin-right: 10px;width: 15px;"/>
	Programme livr&eacute;
</div>
<?php

}

?>
</div></div>