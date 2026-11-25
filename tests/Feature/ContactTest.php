<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_page_renders(): void
    {
        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('Hubungi Saya')
            ->assertSee('Kirim Pesan');
    }

    public function test_contact_message_can_be_submitted(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'Alya Example',
            'email' => 'alya@example.com',
            'subject' => 'Project inquiry',
            'message' => 'I would like to ask about your project.',
        ])->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('contacts', [
            'name' => 'Alya Example',
            'email' => 'alya@example.com',
            'subject' => 'Project inquiry',
            'is_read' => false,
        ]);
    }

    public function test_admin_can_open_the_contacts_inbox_at_contacts_url(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $contact = Contact::create([
            'name' => 'Alya Example',
            'email' => 'alya@example.com',
            'message' => 'A message for the inbox.',
        ]);

        $this->actingAs($admin)
            ->get('/contacts')
            ->assertOk()
            ->assertSee('Pesan Masuk')
            ->assertSee('Alya Example');

        $this->get(route('post.contacts.index'))
            ->assertOk()
            ->assertSee('Pesan Masuk');

        $this->get(route('post.contacts.show', $contact))
            ->assertOk()
            ->assertSee('A message for the inbox.')
            ->assertSee(route('contacts.index'));

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'is_read' => true,
        ]);
    }

    public function test_regular_users_cannot_open_the_contacts_inbox(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/contacts')
            ->assertForbidden();
    }
}
