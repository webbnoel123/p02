<?php
  function sql_protection($str) {
    return (str_contains($str, "'") or str_contains($str, '"') or str_contains($str, " ") or str_contains($str, "=") or str_contains($str, "<") or str_contains($str, ">") or str_contains($str, "/") or str_contains($str, "#"));
  }#kollar efter otillåtna tecken som kan vara skadliga för databasen
  ?>
