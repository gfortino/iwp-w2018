<html>
<head>
    <title>PHP</title>
    <style>
        body{
        font-family: Arial, sans-serif;
        background-image: url("bg.jpg");
        }
        div.imgProduct{
        width:300px;
        position:absolute;
        }
        div.text{
        margin-top: 90px;
        margin-left:310px;
        }
        div.desc{
        width:500px;
        margin-top: 200px;
        text-align: justify;
        }
    </style>
</head>

<body>
    <div style="margin-bottom: 10px">
        <button type="button" onclick="document.getElementById('click').style.display='none'">Hide</button>
        <button type="button" onclick="document.getElementById('click').style.display='block'">Show</button>
    </div>
    <div class="imgProduct">
        <img src="product.jpg" alt="Product" width="300px" onmouseover="this.src='product2.jpg'" onmouseout="this.src='product.jpg'" />
    </div>
    <div class="text">
        <ul>
            <li><b>Bose QC 35 II</b></li>
            <li>Price: <i>400$</i></li>
            <li>Quantity: 10 pcs</li>
        </ul>
    </div>
    <div id="click">
        <div class="desc">
            Noise-rejecting dual-microphone system for clear phone calls and voice access to your phone's default Virtual assistant, like Siri Industry-leading wireless headphones let you adjust the level of noise cancellation to suit your environment Volume-optimized
            EQ makes your music always sounds its best, whether you turn it up on an airplane, or turn it down while at the office Bluetooth and NFC pairing with voice prompts for hassle-free wireless connections Up to 20 hours of wireless play time from
            a rechargeable lithium-ion battery; up to 40 hours of listening in wired mode.
        </div>
        <script>
            function count(obj) {
            document.getElementById('count').innerHTML = obj.value.length;
            }
        </script>
    <div style="margin-top:20px">
        <textarea onkeyup="count(this)"></textarea><br>
        <span id="count">0</span> characters
    </div>
    </div>
</body>

</html>
