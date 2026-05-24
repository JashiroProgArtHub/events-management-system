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
     * Determine if the user can create an event
     */
    public function create(Admin $admin, Event $event): bool
    {
        return true; // Any authenticated admin can create participants for their own events
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
