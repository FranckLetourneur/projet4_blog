<?php
function autoload($classname)
{
  echo __DIR__;
  if (file_exists($file = __DIR__ . '/' . $classname . '.php'))
  { 
    require $file;
  }
}

spl_autoload_register('autoload');