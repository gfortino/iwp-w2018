<html>
   <body>
      <div>
         <div>
            <button type='button' onclick="getElementById('div').style.display=' block'">Show</button>
            <button type='button' onclick="getElementById('div').style.display= 'none'">Hide</button>
         </div>
         <div>
            Text size: <input type='text' id="inputTextSize" onchange="textSize()";>
         </div>
         <div>
            Width: <input type='text' id="inputWidth" onchange="width()";>
         </div>
         <div>
            Height: <input type='text' id="inputHeight" onchange="height()";>
         </div>
         <div>
            Border color: <input type='text' id="inputBorderColor" onchange="borderColor()";>
         </div>
         <div>
            Text Color: <input type='text' id="inputTextColor" onchange="textColor()";>
         </div>
         <div>
            <button type="button" onclick="backgroundColor()">Background Color</button>
         </div>
         <div>
            <button type="button" onclick="border()">Display border</button>
         </div>
         <div>
            <button type="button" onclick="borderSize()">Border</button>
         </div>
      </div>
      <div id="div">Content</div>
   </body>
</html>
<script type='text/javascript'>
   var color = ["blue","grey","green","red","purple"];
   var textSize = function ()
   {
   var x = document.getElementById("inputTextSize");
   document.getElementById("div").style.fontSize= x.value;
   }
   var width = function ()
   {
   var x = document.getElementById("inputWidth");
   document.getAttribute("div").style.width = x.value;
   }
   var height = function ()
   {
   var x = document.getElementById("inputHeight");
   document.getElementById("div").style.height= x.value;
   }
   var borderColor = function ()
   {
   var x = document.getElementById("inputBorderColor");
   document.getElementById("div").style.borderColor = x.value;
   }
   var textColor = function ()
   {
   var x = document.getElementById("inputTextColor");
   document.getElementById("div").style.color= x.value;
   }
   var backgroundColor = function ()
   {
   document.getElementById('div').style.backgroundColor = color[Math.round(Math.random(color.length))];
   }
   var border = function ()
   {
   document.getElementById('div').style.border = "solid red 2px";
   }

   var borderSize = function ()
   {
   document.getElementById('div').style.border = " solid black 5px";
   }
</script>
