 <script>
        function showHint(str) {
            if (str.length == 0) {
                document.getElementById("txtHint").innerHTML = "";
                //document.getElementById("txtHint").style.border="0px";

                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                        //document.getElementById("txtHint").style.border="1px solid #A5ACB2";

                    }
                };
                xmlhttp.open("GET", "../Ajax_donne/get_sous_categ?q=" + str, true);
                xmlhttp.send();
            }
        }
 </script>


<p><b>Start typing a name in the input field below:</b></p>

    Categ: <input type="text" name="categ" list="categ_list" onkeyup="showHint(this.value)"/>


 </br>


 <input type="text" size="30" list="txtHint">
 <datalist id="txtHint">

 </datalist>

</br>
 </br>
 </br>
 </br>

 <div style="width: 80%; display: inline-block;">
     <select id="select3">
         <option value="-1">---</option>
     </select>
 </div>

 <script>
     /* This parser won't respect "---" selection */
     function dataParserA(data, selected) {
         retval = [ { val: "-1" , text: "---" } ];

         data.forEach(function(v){
             if(selected == "-1" && v.val == 3)
                 v.selected = true;
             retval.push(v);
         });

         return retval;
     }

     /* This parser let's the component to handle selection */
     function dataParserB(data, selected) {
         retval = [ { val: "-1" , text: "---" } ];
         data.forEach(function(v){ retval.push(v); });
         return retval;
     }

     /* Create select elements */
     $("#select1").tinyselect();
     $("#select2").tinyselect({ showSearch: false });
     //$("#select3").tinyselect({ searchCaseSensitive: false, dataUrl: "../../assets/json/file.json" , dataParser: dataParserA });
     $("#select3").tinyselect({ searchCaseSensitive: false, dataUrl: "../Ajax_products/get_fournisseur" , dataParser: dataParserA });
     $("#select4").tinyselect({ dataUrl: "failure.json" });
     $("#select5").tinyselect({ dataUrl: "file.json" , dataParser: dataParserB });

     $("#select2").on("change",function() {
         console.log($(this).val());
     });

     $("#havoc").show()

 </script>

 <div style="width: 80%; display: inline-block;">
     <select id="fournisseur" name="fournisseur" required>
         <option value="-1">---</option>
     </select>
 </div>

 <script>
     /* Create select elements */
     /*json数据*/
     $("#fournisseur").tinyselect({ searchCaseSensitive: false, dataUrl: "../Ajax_products/get_fournisseur" , dataParser: dataParserA });
     $("#havoc").show()
 </script>
 </br></br></br></br></br></br>
 <div>
 <select id="test">
     <option value=""> </option>
     <option value="-1">123</option>
     <option value="1">456</option>
     <option value="1">789</option>

 </select>
 </div>
 <button id="123" onclick="alert_categ()">123</button>

 <script>
     function alert_categ(){
         if(document.getElementById("test").value==""){
             alert("fournisseur is needed");
         }
         //alert("fournisseur is needed");
     }
 </script>
