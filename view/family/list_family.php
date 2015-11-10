<?php
$ViewOutput = new html();
$ViewOutput->addlink('?Controller=family&Action=CREATE','Ajouter une famille');

echo $ViewOutput->send(1);

