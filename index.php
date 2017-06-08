<?php
//url bestandslocatie
$url = "https://datatank.stad.gent/4/bevolking/bevolkingssamenstellingoverzicht.csv";

//certificatie zodat ik het kan ophalen
$arrContextOptions=array(
    "ssl"=>array(
        "cafile" => "perl/vendor/lib/Mozilla/CA/cacert.pem",
        "verify_peer"=> true,
        "verify_peer_name"=> true,
    ),
);
//Ophalen csv bestand
$csvData = file($url, false, stream_context_create($arrContextOptions));
?>

<html>
    <head>
        <title>Somko CSV</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <!--Bootstrap css-->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css " rel="stylesheet">
    <!--datatables css-->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.0/material.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.material.min.css">
  

    </head>
    <body>
    
        <!-- bootstrap table class -->
        <table id="csvTable" class="mdl-data-table" cellspacing="0" width="100%">         
        <?php
        $row = 0;
        
        //overloop document
        foreach ($csvData as $line)
        {    
            //splits en steek in array
            $lineArray = explode(";", $line);  
            //vervang quotes
            str_replace('"', "", $lineArray);
            
            //bij de eerste rij steek ze in een thead
            if($row == 0)
            {
                print '<thead><tr>';
                    for($i=0; $i<count($lineArray);$i++)
                    {                  
                        print '<th>'.str_replace('"', "",$lineArray[$i]).'</th>';
                    }
                print '</tr></thead>';
                $row = 1;
            }
            //anders druk elke cel appart af
            else
            {
                print '<tr>';
                    for($i=0; $i<count($lineArray);$i++)
                    {                  
                        print '<td>'.str_replace('"', "",$lineArray[$i]).'</td>';
                    }
                print '</tr>';
            }
        }
        ?>            
        </table>
   
        
  
    <!-- jQuery -->
    <script src="jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="css/bootstrap/js/bootstrap.min.js"></script>

    <!--Datatables -->
    <script type="text/javascript" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.material.min.js"></script>
      
    <!-- variables DataTable -->
    <script>  
    $('#csvTable').DataTable( {
           
            columnDefs: [
            {
                targets: [ 0, 1, 2 ],
                className: 'mdl-data-table__cell--non-numeric'
            }
        ]
    });
     </script>
    </body>
</html>
