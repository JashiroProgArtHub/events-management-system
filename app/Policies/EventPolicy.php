<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Event;

class EventPolicy
{
    /**
     * Determine if the user can view the event
     */
    public function view(Admin $admin, Event $event): bool
    {
        return $admin->admin_id === $event->admin_id;
    }

    /**
     * Determine if the user can update the event
     */
    public function update(Admin $admin, Event $event): bool
    {
        return $admin->admin_id === $event->admin_id;
    }

    /**
     * Determine if the user can delete the event
     */
    public function delete(Admin $admin, Event $event): bool
    {
        return $admin->admin_id === $event->admin_id;
    }
}
