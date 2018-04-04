<html>
    <head>
        <title>Shop Cart View</title>
        <link rel="stylesheet" href="table3.css">
        <link rel="stylesheet" href="default3.css">
    </head>
    <body>
        <div class="head">
            Vegetables/Carrots <?php echo "<br>" ?>
        </div>
        
            <div class="img">
                <img style="float" id="myImage" src="image/carottes.jpg" width="200px" height="120px" onmouseover="this.src='image/carottes.jpg'" onmouseout="this.src='image/carottes2.jpg'">
            </div>
        
        <div class="title">
            <p>
                 <?php echo "<br>" ?> Canadian Carrots <?php echo "<br>" ?> Price : $4.5/kg <?php echo "<br>" ?> Quantity Available : 30 
            </p>
        </div>
        
        <div class="desc">
            <p id="demo" style="align : right; display:none;" >
                The carrot (Daucus carota subsp. sativus) is a root vegetable, usually orange in colour, though purple, black, red, white, and yellow cultivars exist. Carrots are a domesticated form of the wild carrot, Daucus carota, native to Europe and southwestern Asia. 
            </p>
        </div>
        
        <div class="butto">
        <button onclick="document.getElementById('myImage').src='image/carottes.jpg'">View Image 1</button>
        
        <button onclick="document.getElementById('myImage').src='image/carottes2.jpg'">View Image 2</button>
            
        <button type="button" onclick="document.getElementById('demo').style.display='block'">Show</button>
            
        <button type="button" onclick="document.getElementById('demo').style.display='none'">Hide</button>
        
        <?php echo "<br>" ?>
            
        <button type="button" onclick="document.getElementById('com').style.display='block'">Comment</button>
            
        </div>
        
        <div class="comment">
            <p id="com" style="display:none">
            Leave your comment here: <input type="text" id="fname" onchange="myFunction()">
    
            <script>
                function myFunction() 
                {
                var x = document.getElementById("fname");
                    x.value = x.value.length;
                alert("Thanks for your comment (" + x.value + " Caracters)")
                }
            </script>
            </p>
        </div>
        
    </body>
</html>