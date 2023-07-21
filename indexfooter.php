<!DOCTYPE html>
<html>
<head>
<title>Membuat footer tetap di bawah</title>
<style>
html,body{margin:0;padding:0;height:100%;font:13px Arial;}
#wrapper{min-height:100%;position:relative;}
#header{background:#f0f0f0;padding:5px;height:50px;color:#0000ff;}
#body{padding-bottom:40px;padding-left:10px;}
#footer{background:#f0f0f0;position:absolute;bottom:0;width:100%;
   text-align:center;color:#808080;}
</style>
</head>
<body>
<div id="wrapper">
   <div id="header"><h1>Membuat footer tetap di bawah</h1></div>
   <div id="body">
    <p>Content</p><p>Content</p><p>Content</p><p>Content</p><p>Content</p>
   </div>
   <div id="footer"><p>Copyright &copy; 2014 - All Rights Reserved</p></div>
</div>
</body>
</html>