<?php
declare(strict_types=1);


foreach ($result->competitions as $VALUE) {
    echo "<a href='?page=competition&name=$VALUE->code'><ul> $VALUE->name </ul> </a>";
}


