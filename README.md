# facades
Make the Facades for Laravel lovers


```
<?php
use Ramphor\Facades\DB;

DB::get_var("SELECT COUNT(ID) FROM " . DB::posts_table() . " WHERE post_type='post'");
```
