var total=0;	
		
		
			function addRow(elmt, qty, value)
                {
                    var arrayLignes = document.getElementById("tableau").rows;
                    var product = elmt;
                    var qte = qty;
                    var Price = value;
					
                    total = total + value;
					
        

                    var ligne = document.getElementById("tableau").insertRow();

                    ligne.insertCell(0).innerHTML += elmt;
                    ligne.insertCell(1).innerHTML += qty;
                    ligne.insertCell(2).innerHTML += value;
                    ligne.insertCell(3).innerHTML += total;
							
                }
			
            function Price(price)
                {
                    var i = i + price;
                    return i; 
                }
            function print()
            {
                alert(getElementById('tableau'));
            }
			
		

			
		 
		
		
      
		

			