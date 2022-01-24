<?php
  function sql_protection($str) {
    return (str_contains($str, "'") or str_contains($str, '"') or str_contains($str, " ") or str_contains($str, "="));
  }
  ?>
