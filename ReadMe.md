# Supplier Product List Processor

#### Delon Savanhu Submission
#### Usage:
`parser.php --file example_1.csv --unique-combinations=combination_count.csv`

#### Description
This is a basic php application that accepts a file(.csv,.json or .xml) and then transforms it into product object.

#### Takeaways
1. I purposefully funnelled all my execution into CSV. Basically any supported file type will be transformed into a CSV file and then executed.
2. This reduces the burden of supporting many different file types transformation logic into products and then printing.
3. I just need to add a new file type to csv transformer and then the normal execution continues.
4. I added debug code to see error points, these can be removed in production.
5. Set the memory limit to 1 gig, XML, especially, is expensive to manipulate if the file is huge.  
6. The file 'new_products_comma_separated.csv' will throw an expection because it contains missing required fields
7. To see full usage, use 'all_fields_there.csv'. This is a file with dummy data but has all required fields