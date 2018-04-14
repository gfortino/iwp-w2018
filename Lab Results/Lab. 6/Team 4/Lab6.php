<html>
    <head>
        <link rel="stylesheet" href="StyleSheet.css">
        <script src="JavaLab6.js"></script>
            <script type='text/javascript'>
                var bg = function () 
                {
                var color = ["red","yellow","black","green","blue"];
                document.getElementById('empty').style.backgroundColor = color[Math.round(Math.random(color.length))];
                }
            </script>
        
            <script type="text/javascript">
                var border = function ()
                {
                    document.getElementById('empty').style.border = " solid black 2px";
                }
                
                var borderIncr = function ()
                {
                    document.getElementById('empty').style.border = " solid black 5px";
                }
                
                var colorB = function ()
                {
			    var x = document.getElementById("inputCB");
			         document.getElementById("empty").style.borderColor = x.value;
		        }
                
                var colorT = function ()
                {
			    var x = document.getElementById("inputCT");
			         document.getElementById("empty").style.color= x.value;
		        }
                
                var sizeT = function ()
                {
			    var x = document.getElementById("inputT");
			         document.getElementById("empty").style.fontSize= x.value;
		        }
                
                var width = function ()
                {
			    var x = document.getElementById("inputW");
			         document.getAttribute("empty").style.width = x.value;
		        }
                
                var height = function ()
                {
			    var x = document.getElementById("inputH");
			         document.getElementById("empty").style.height= x.value;
		        }
                
                
            </script>
    </head>
    <body>
        <div> 
        <div>
            <button type='button' onclick="getElementById('empty').style.display=' block'">Show</button>
            <button type='button' onclick="getElementById('empty').style.display= 'none'">Hide</button>
        </div>
        <div>
            Enter Size of the Text : <input type='text' id="inputT" onchange="sizeT()";>
        </div>
            
        <div>
            Enter Width : <input type='text' id="inputW" onchange="width()";>
        </div>
            
        <div>
            Enter Height : <input type='text' id="inputH" onchange="height()";>
        </div>
            
        <div>
            Enter a Color to change the Border Color : <input type='text' id="inputCB" onchange="colorB()";>
        </div>
        <div>
            Enter a Color to change the Text Color : <input type='text' id="inputCT" onchange="colorT()";>
        </div>
        <div>
            <button type="button" onclick="bg()">Change Bacground Color</button>
        </div>
        <div>
            <button type="button" onclick="border()">Put Border</button>
        </div>
        <div>
            <button type="button" onclick="borderIncr()">Increase Border</button>
        </div>
        </div>
        
        <div id="empty" style="display : none;" > EMPTY </div>
            
    </body>
</html>