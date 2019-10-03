<?php

namespace App\Events;

class DashboardAdminEvent
{
    public $menu;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($menu)
    {
        $this->menu = $menu;
    }
}
