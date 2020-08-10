# facades
Make the Facades for Laravel lovers


```
<?php
use Ramphor\Facades\DB;

DB::get_var("SELECT COUNT(ID) FROM " . DB::get_table('posts') . " WHERE post_type='post'");
```
