<?php

class make_aff_link {
    
    
    function udemy_with_coupon($compound_url) {
        $prefix = "http://click.linksynergy.com/fs-bin/click?id=" . LINKSHARE_ID . "&subid=&offerid=323085.1&type=10&tmpid=14537&RD_PARM1=";
        $url = $prefix . urlencode($compound_url);
        return $url;
    }
    
    function udemy_no_coupon($compound_url) {
        $prefix = "http://click.linksynergy.com/fs-bin/click?id=" . LINKSHARE_ID . "&subid=&offerid=323085.1&type=10&tmpid=14538&RD_PARM1=";
        $url = $prefix . urlencode($compound_url);
        return $url;
    }
    
    
}

?>