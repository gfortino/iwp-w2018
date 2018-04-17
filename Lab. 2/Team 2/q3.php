<html>
<head>
	<title> My first website </title>
	<link rel="stylesheet" href="style.css">
	<script>
		function appear(){

		}
	</script>
</head>
<body>
	<div class="center">
		<img id="image" onmouseover="funtion1(this)" onmouseout="funtion2(this)" src="Asus.png" >
		<div id="Info">
			<div><h1>Asus Rog</h1></div>
			<div><h1>CAD$ 2200</h1></div>
			<div><h1>10 in stock</h1></div>
		</div>
	</div>
	<div id="test">
	</div>
	<button id="button" onclick="myFunction2()">HIDE</button>
	<button id="button2" onclick="myFunction3()">SHOW</button>


	<select id="my Select" onchange="myFunction()">
		<option value="CountKO">No Count </option>
		<option value="CountOK">Count</option>
	</select>
	<script>
		var str = "Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum Sic vis pacem para bellum <br><br>"; 
		document.getElementById("test").innerHTML = str;
		var str2 = "";

		function myFunction() 
		{

			var n = str.length;
			var yourSelect = document.getElementById("my Select");
			var x = yourSelect.options[yourSelect.selectedIndex].value;
			if (x == "CountKO") {
				console.log("slt");
				str2 = str;
				document.getElementById("test").innerHTML = str2;
			}
			else if (x == "CountOK") {
				console.log("slt2");
				str2 = str + "Count: " + n;
				document.getElementById("test").innerHTML = str2;
			}
		}


		var strE = "";

		function myFunction2() {
			document.getElementById("test").innerHTML = strE;
			
		}
		function myFunction3() {
			document.getElementById("test").innerHTML = str2;
			
			
		}
	</script>

	<script>
		function funtion1(x) {
			x.src="Asus2.png"
		}

		function funtion2(x) {
			x.src="Asus.png"
		}
	</script>



</body>
</html>