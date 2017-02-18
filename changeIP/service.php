<?php 
echo getenv('HTTP_CLIENT_IP').'(1)<br>'; 
echo getenv('HTTP_X_FORWARDED_FOR').'(2)<br>'; 
echo getenv('REMOTE_ADDR').'(3)<br>'; 
