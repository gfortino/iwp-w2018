<script>
function changeText() {
    var x = document.getElementById("text");
    document.getElementById("div").innerHTML = x.value;
}
var sizeText = function ()
{
    var x = document.getElementById("SizeText");
	document.getElementById("div").style.fontSize= x.value;
}

var textColor = function ()
{
    var x = document.getElementById("TextColor");
	document.getElementById("div").style.color= x.value;
}

var width = function ()
{
    var x = document.getElementById("Width");
	document.getElementById("div").style.width= x.value;
}

var height = function ()
{
    var x = document.getElementById("Height");
	document.getElementById("div").style.height= x.value;
}

var borderColor = function ()
{
    var x = document.getElementById("borderColor");
	document.getElementById("div").style.borderColor = x.value;
}

var backgroundColor = function ()
{
    var x = document.getElementById("backgroundColor ");
	document.getElementById("div").style.backgroundColor = x.value;
}

var borderIncr = function ()
{
    document.getElementById('div').style.border = "solid black 5px";
}

</script>

<form class="form-signin" method="POST">
  <label for="Text" >Text</label>
  <input id="text" type="text" name="text" placeholder="Text" onchange="changeText()"> <br/>

  <label for="SizeText" >SizeText</label>
  <input id="SizeText" type="text" name="SizeText" placeholder="SizeText" onchange="sizeText()"> <br/>

  <label for="TextColor" >TextColor</label>
  <input id="TextColor" type="text" name="TextColor" placeholder="TextColor" onchange="textColor()"> <br/>

  <label for="Width" >Width</label>
  <input id="Width" type="text" name="Width" placeholder="Width" onchange="width()"> <br/>

  <label for="Height" >Height</label>
  <input id="Height" type="text" name="Height" placeholder="Height" onchange="height()"> <br/>

  <label for="borderColor" >borderColor</label>
  <input id="borderColor" type="text" name="borderColor" placeholder="borderColor" onchange="borderColor()"> <br/>

  <label for="backgroundColor" >backgroundColor</label>
  <input id="backgroundColor" type="text" name="backgroundColor" placeholder="backgroundColor" onchange="backgroundColor()"> <br/>


  <button type="button" onclick="borderIncr()">Increase Border</button>



</form>

<div id="div"/>
