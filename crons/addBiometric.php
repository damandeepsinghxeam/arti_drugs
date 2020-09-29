<?php 
        // create curl resource 
        $ch = curl_init(); 

        // set url  //set to every 15 minutes
        curl_setopt($ch, CURLOPT_URL, "http://erp.xeamventures.com/employees/add-biometric-cron"); 

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $info = curl_getinfo($ch);


        
        $output = curl_exec($ch); 

        
        curl_close($ch);    
?>