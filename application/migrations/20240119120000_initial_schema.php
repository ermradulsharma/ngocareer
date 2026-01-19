<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Initial_schema extends CI_Migration
{

    public function up()
    {
        // This is a placeholder. 
        // Since we import a large SQL file, we might not need to create tables here.
        // But we can enable the migrations table.
        // $this->dbforge->add_field(...);
    }

    public function down()
    {
        // $this->dbforge->drop_table('some_table');
    }
}
