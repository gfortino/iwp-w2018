<html>
    <head>
        <title>Email Addresses</title>
        <link rel="stylesheet" href="default2.css">
        <link rel="stylesheet" href="table2.css">
        <style>
            body 
            {
                margin: 20px 0 10em 20px;
            }
        </style>
    </head>
            <body>
                <table>
                    <thead> 
                        <tr>
                            <td>User</td>
                            <td>Address</td>
                        </tr>
                    </thead>
                    <tbody>
                    <caption style="text-align : center;">Last Mail Addresses</caption>
                <p>
                    
                    <?php
                    $i = 0;
                    while($i <= 20)
                    {
                        $i++;

                    if ($i%2 == 0)
                    {    
                            
                            print("<tr><td>$i</td><td class='color'>abcdefg@mail.com</td></tr>");

                    }

                    else
                    {
                            print("<tr><td>$i</td><td class='quarter'>abcdefg@email.com</td></tr>");
                            
                    }
                    }
                    ?>
                    
                </p>
                    </tbody>
                </table>
            </body>
</html>               