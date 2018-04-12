<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script>
            $(document).ready(function(){
                $("div").html($("#actual_text").val()).css("font-size", $("#text_size").val());;
                $("div").css("height", $("#height").val());
                $("div").css("width", $("#width").val());
                $("div").css("border-style", "solid");
                $("div").css("border-width", $("#border_thickness").val()+"px");

                $("#red").click(function(){
                    $("div").css("background-color", "red");
                });
                $("#yellow").click(function(){
                    $("div").css("background-color", "yellow");
                });
                $("#blue").click(function(){
                    $("div").css("background-color", "blue");
                });
                $("#border_visible").click(function(){
                    $("div").css("border-style", "solid");
                });
                $("#border_invisible").click(function(){
                    $("div").css("border-style", "");
                });
                $("#border_thickness").on("click keyup",function(){
                    $("div").css("border-width", $("#border_thickness").val()+"px");
                });
                $("#actual_text").keyup(function(){
                    $("div").html($("#actual_text").val());
                });
                $("#border_red").click(function(){
                    $("div").css("border-color", "red");
                });
                $("#border_yellow").click(function(){
                    $("div").css("border-color", "yellow");
                });
                $("#border_blue").click(function(){
                    $("div").css("border-color", "blue");
                });
                $("#text_red").click(function(){
                    $("div").css("color", "red");
                });
                $("#text_yellow").click(function(){
                    $("div").css("color", "yellow");
                });
                $("#text_blue").click(function(){
                    $("div").css("color", "blue");
                });
                $("#text_size").on("click keyup",function(){
                    $("div").css("font-size", $("#text_size").val());
                });
                /*$("#text_size").click(function(){
                    $("div").css("font-size", $("#text_size").val());
                });*/
                $("#height").on("click keyup",function(){
                    $("div").animate({height:$("#height").val()});
                });
                $("#width").on("click keyup",function(){
                    $("div").animate({width:$("#width").val()});
                });
            });
		</script>
	</head>
	<body>
		<h2>Control form</h2>
        <pre>
		- border (visible/invisible, thickness in pixels, color)
		- background color
		- text color
		- text size
		- actual text (content)
		- height and width
            </pre>
		<table>
			<tr>
				<td>
					Border:
				</td>
				<td>
					<button id="border_visible">Border_visible</button>
					<button id="border_invisible">Border_invisible</button>
				</td>
			</tr>
            <tr>
                <td>
                    thickness:
                </td>
                <td>
                    <input type="number" id="border_thickness" value="30"/>
                </td>
            </tr>
            <tr>
                <td>
                    Border Color:
                </td>
                <td>
                    <button id="border_red" style="background-color: red">red</button>
                    <button id="border_blue" style="background-color: blue">blue</button>
                    <button id="border_yellow" style="background-color: yellow">yellow</button>
                </td>
            </tr>
			<tr>
				<td>
					Background Color:
				</td>
				<td>
					<button id="red" style="background-color: red">red</button>
					<button id="blue" style="background-color: blue">blue</button>
					<button id="yellow" style="background-color: yellow">yellow</button>
				</td>
			</tr>
            <tr>
                <td>
                    Actual Text
                </td>
                <td>
                    <input type="text" id="actual_text" value="Div tag"/>
                </td>
            </tr>
            <tr>
                <td>
                    Text color
                </td>
                <td>
                    <button id="text_red" style="background-color: red">red</button>
                    <button id="text_blue" style="background-color: blue">blue</button>
                    <button id="text_yellow" style="background-color: yellow">yellow</button>
                </td>
            </tr>
            <tr>
                <td>
                    Text size
                </td>
                <td>
                    <input type="number" id="text_size" value="40"/>
                </td>
            </tr>
            <tr>
                <td>
                    Height
                </td>
                <td>
                    <input type="number" id="height" value="150"/>
                </td>
            </tr>
            <tr>
                <td>
                    Width
                </td>
                <td>
                    <input type="number" id="width" value="150"/>
                </td>
            </tr>
		</table>
        <br>
        <br>
		<div style="font-size: 20px; height: 300px">

		</div>
	</body>
</html>