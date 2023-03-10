# php-parser-csv-tsv

This is php parser for .csv and .tsv files

To donwload just clone the repository.

Usage
    goto commond line 
    
    For CSV just write below commond on your cmd and click enter 
      "php src/parser.php -f files/products_comma_separated.csv -u files/combination_tsv_count.csv" 
      
      parser will read the file you given in "-f"  and display row by row each product object representation of the row. 
      And create a file with a grouped count for each unique combination
    
    For TSV just write below commond on your cmd and click enter 
     "php src/parser.php -f files/products_tab_separated.tsv -u files/combination_count.csv"
     
      parser will read the file you given in "-f"  and display row by row each product object representation of the row. 
      And create a file with a grouped count for each unique combination
      
      
