<html>
	<head>
		<title>Product File</title>
		<link rel = "stylesheet" href = "bckgrnt.css">
		<link rel = "stylesheet" href = "tablent.css">
	</head>
	
	<body>
	
	
		<table>
				<tr>
					<td>Title</td>
					<td>Price</td>
					<td>Quantity available</td>
					<td>Descrpition</td>
					<td>Image</td>
				</tr>
				
				<tr id="item1" class = "paire"  style="display:table-row;">
					<td>Chaise</td>
					<td>50$</td>
					<td>4</td>
					<td>Chaise confortable rouge</td>
					<td><img onmouseover="chaise1Img(this)" onmouseout="chaise2Img(this)" src="chaise.png" alt="chaire rouge" height="42" width="50"></td>
				</tr>
				
				<tr id="item2" class = "paire" style="display:none;">
					<td>Table</td>
					<td>10$</td>
					<td>6</td>
					<td>Petite table ronde </td>
					<td><img onmouseover="table1Img(this)" onmouseout="table2Img(this)" src="table.png" alt="table" height="42" width="45"></td>
				</tr>
				
			
			</table>
			
			<button type="button" onclick="showChaise()">Chaise</button>
			<button type="button" onclick="showTable()">Table</button>

		
		
		<p>Let comment : </p>
		<input type="text" id="comment" value="comment here" onchange="myFunction();">
		
		<p id="text"> </p>
		
		<script>
			function showTable(){
				
					document.getElementById("item1").style.display='none';
    				document.getElementById("item2").style.display='table-row';
    		}
    		function showChaise(){
			
					document.getElementById("item1").style.display='table-row';
    				document.getElementById("item2").style.display='none';
			}
				
			
			function chaise1Img(x) {
    			x.src = "chaise2.png";
			}

			function chaise2Img(x) {
   				x.src = "chaise.png";
    		}
    		
    		function table1Img(x) {
    			x.src = "table2.png";
			}

			function table2Img(x) {
   				x.src = "table.png";
    		}
    		
    		function myFunction() {
   	 			var x = document.getElementById("comment").value;
    			document.getElementById("text").innerHTML = "Comment's size : " + x.length;
			}
		</script>
	</body>
	
</html>