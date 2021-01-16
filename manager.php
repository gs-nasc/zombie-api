<?php

// COMPOSER
require "vendor/autoload.php";
// MODELS
require "app/models/Survivor.php";
require "app/models/Item.php";
require "app/models/Inventory.php";
require "app/models/Report.php";
// DATABASE MODEL
require "app/models/database/database.php";
// SCHEMA MODEL
require "app/models/database/schema/survivor.php";
require "app/models/database/schema/report.php";
require "app/models/database/schema/item.php";
require "app/models/database/schema/survivoritemrelation.php";