<?php 
setcookie("email","",time()-1, "/");  
setcookie("type","",time()-1, "/");
echo "<meta http-equiv='refresh' content='0;url=index.php'>";
?>