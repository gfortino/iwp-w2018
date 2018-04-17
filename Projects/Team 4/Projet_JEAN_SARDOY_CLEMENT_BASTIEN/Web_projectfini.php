
<html>
    <head>
      
		<?php include('gotologin.php'); ?>
		<script src="tab.js" charset="utf-8"></script>
		
        <link rel="stylesheet" href="Stylesheet_WebPage.css">
        <title>Welcome On FoodOrder</title>
    </head>
    <body>
        <header>
            <div id="contain">
                <div class="top">
                <ul>
                   
					<button onclick="document.getElementById('login').style.display='block'">Login</button>
					<button onclick="document.getElementById('signup').style.display='block'">Sign Up</button>
                </ul>
                </div>
            </div>
        </header>
		
		 
		
		
       <div id="result"></div>
        <div class="Presentation">
            <div class="Window">
                <div class="title">
                    Four-Seasons <br />
                </div>
                
                <div id="inwin">
                    <div class="item">
                        <img src="image/4seasons.jpg" style="width : 100px; height : 100px;" />
                    </div>
                    <div class="item">
                        Price : $16.00
                    </div>
                </div>
                
                <div class="description">
                    Description : The pizza four seasons (quattro stagioni pizza) is a variety of pizza prepared in four portions containing different ingredients, every portion representing a season of the year.
                </div>
                
                <div class="button">
                    <button type="button" onclick="addRow('Pizza Four-Seasons', 1, 16); Price(16)">Add to Cart</button>
                </div>
            </div>
            <div class="Window"> 
                <div class="title">
                    Pizza With Pineapple <br />
                </div>
                
                <div id="inwin">
                    <div class="item">
                        <img src="image/Pizza.jpg" style="width : 100px; height : 100px;" />
                    </div>
                    <div class="item">
                        Price : $17.00
                    </div>
                </div>
                
                <div class="description" style="display = 'none';">
                    Description : La pizza hawaïenne est une de pizza qui se compose généralement de fromage et d'une base de tomate avec des morceaux de jambon ou de poulet et d'ananas 
                </div>
                
                <div class="button">
                    <button type="button" onclick="addRow('Pizza With Pineapple', 1, 17)">Add to Cart</button>
                </div>
            </div>
            <div class="Window"> 
                <div class="title">
                    Pizza Margherita <br />
                </div>
                
                <div id="inwin">
                    <div class="item">
                        <img src="image/Margherita.jpg" style="width : 100px; height : 100px;" />
                    </div>
                    <div class="item">
                        Price : $15.00
                    </div>
                </div>
                
                <div class="description" style="display = 'none';">
                    Description : This pizza is furnished with tomatoes, with mozzarella, with fresh basil, with salt and with olive oil. This pizza is in the colors of the Italian flag.
                </div>
                
                <div class="button">
                    <button type="button" onclick="addRow('Pizza Margherita', 1, 15)">Add to Cart</button>
                </div>
            </div>
            <div class="Window">  
                <div class="title">
                    Calzone <br />
                </div>
                
                <div id="inwin">
                    <div class="item">
                        <img src="image/calzone.jpeg" style="width : 100px; height : 100px;" />
                    </div>
                    <div class="item">
                        Price : $16.00
                    </div>
                </div>
                
                <div class="description" style="display = 'none';">
                    Description : The Italian term can be translated by "slipper"; it is indeed about a filled turned pizza of mozzarella and tomatoes, and with some ham. The Italians consume her during the meals in antipasto (assortment of entrances), for main course or in snack in the afternoon.
                </div>
                
                <div class="button">
                    <button type="button" onclick="addRow('Calzone', 1, 16)">Add to Cart</button>
                </div>
            </div>
            <div class="Window"> 
                <div class="title">
                    Salmone <br />
                </div>
                
                <div id="inwin">
                    <div class="item">
                        <img src="image/salmone.jpg" style="width : 100px; height : 100px;" />
                    </div>
                    <div class="item">
                        Price : $19.00
                    </div>
                </div>
                
                <div class="description" style="display = 'none';">
                    Description : Lemony mascarpone cream, mozzarella, smoked salmon, coulis of basil, sheets of basil.
                </div>
                
                <div class="button">
                    <button type="button" onclick="addRow('Pizza Salmone', 1, 19)">Add to Cart</button>
                </div>
            </div>
            <div class="Window">
                <div class="title">
                    Goat's Milk Cheese and Honey <br />
                </div>
                
                <div id="inwin">
                    <div class="item">
                        <img src="image/honey.jpg" style="width : 100px; height : 100px;" />
                    </div>
                    <div class="item">
                        Price : $17.00
                    </div>
                </div>
                
                <div class="description" style="display = 'none';">
                    Description : Wipe cream and honey, mozzarella, goat cheese, speck, salad.
                </div>
                
                <div class="button">
                    <button type="button" onclick="addRow('Goats Milk Cheese and Honey', 1, 17)">Add to Cart</button>
                </div>
            </div>
            <div class="Window">  
                <div class="title">
                     Piizza with Shrimps<br />
                </div>
                
                <div id="inwin">
                    <div class="item">
                        <img src="image/crevette.jpg" style="width : 100px; height : 100px;" />
                    </div>
                    <div class="item">
                        Price : $18.00
                    </div>
                </div>
                
                <div class="description" style="display = 'none';">
                    Description : Tomato sauce, mozzarella, cuttlefishes and shrimps marinated in the lemony chopped parsley, the molds, the shoots of spinach.
                </div>
                
                <div class="button">
                    <button type="button" onclick="addRow('Pizza with Shrimps', 1, 18)">Add to Cart</button>
                </div>
            </div>
            <div class="Window"> 
                <div class="title">
                    Veggie Pizza <br />
                </div>
                
                <div id="inwin">
                    <div class="item">
                        <img src="image/veg.jpg" style="width : 100px; height : 100px;" />
                    </div>
                    <div class="item">
                        Price : $15.00
                    </div>
                </div>
                
                <div class="description" style="display = 'none';">
                    Description : Concassé de tomates, mozzarella, carpaccio de courgette, mélanges de légumes cuisinés (aubergines et courgettes grillées, concassé de tomates et oignons), tomates cerise marinées, olives noires.
                </div>
                
                <div class="button">
                    <button type="button" onclick="addRow('Veggie Pizza', 1, 15)">Add to Cart</button>
                </div>
            </div>
            <div class="Window"> 
                <div class="title">
                    Hamburger<br />
                </div>
                
                <div id="inwin">
                    <div class="item">
                        <img src="image/hamburger.jpg" style="width : 100px; height : 100px;" />
                    </div>
                    <div class="item">
                        Price : $12.00
                    </div>
                </div>
                
                <div class="description" style="display = 'none';">
                    Description : A hamburger is a German sandwich of origin, compound of two breads of round form generally furnished with minced meat and of raw vegetables - salad, tomato, onion, pickles - of cheese and sauce.
                </div>
                
                <div class="button">
                    <button type="button" onclick="addRow('Hamburger', 1, 12)">Add to Cart</button>
                </div>
            </div>
            <div class="Window"> 
                <div class="title">
                    Cheeseburger <br />
                </div>
                
                <div id="inwin">
                    <div class="item">
                        <img src="image/cheese.jpg" style="width : 100px; height : 100px;" />
                    </div>
                    <div class="item">
                        Price : $12.00
                    </div>
                </div>
                
                <div class="description" style="display = 'none';">
                    Description : Cheeseburger is the name given to a hamburger in which a slice of cheese accompanies the meat
                </div>
                
                <div class="button">
                    <button type="button" onclick="addRow('Cheeseburger', 1, 12)">Add to Cart</button>
                </div>
            </div>
            <div class="Window"> 
                <div class="title">
                    Burger with Chicken and Avocado <br />
                </div>
                
                <div id="inwin">
                    <div class="item">
                        <img src="image/avocat.jpg" style="width : 100px; height : 100px;" />
                    </div>
                    <div class="item">
                        Price : $16.00
                    </div>
                </div>
                
                <div class="description" style="display = 'none';">
                    Description : Grilled chicken, fried crunchy avocado, roasted onions, the crunchy bacon, the cheese, the lettuce and the tomato, served in a ciabatta bread.
                </div>
                
                <div class="button">
                    <button type="button" onclick="addRow('Burger with Chicken and Avocado', 1, 16)">Add to Cart</button>
                </div>
            </div>
            <div class="Window">
                <div class="title">
                    Grilled Cheese with Braised Beef <br />
                </div>
                
                <div id="inwin">
                    <div class="item">
                        <img src="image/braised.jpg" style="width : 100px; height : 100px;" />
                    </div>
                    <div class="item">
                        Price : $16.00
                    </div>
                </div>
                
                <div class="description" style="display = 'none';">
                    Description : Soft braised beef, cheese molten Roadman, fresh red onions and a mixture of lettuces, served between two golden slices of leavened bread.
                </div>
                
                <div class="button">
                    <button type="button" onclick="addRow('Grilled Cheese with Braised Beef', 1, 16)">Add to Cart</button>
                </div>
            </div>
        </div>

    </body>
</html>