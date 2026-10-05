<?php

use App\Models\LostFoundPost;
use App\Models\PrivateMessage;
use App\Models\PostComment;
use App\Models\Product;
use App\Models\User;

it('allows a student to comment on a marketplace post', function () {
    $author = User::factory()->create();
    $student = User::factory()->create();
    $product = Product::create([
        'user_id' => $author->id,
        'title' => 'Calculator',
        'description' => 'Scientific calculator',
        'price' => 250,
        'category' => 'School Supplies',
        'condition' => 'Good',
        'status' => 'available',
    ]);

    $response = $this->actingAs($student)->post(route('interactions.comments.store', ['type' => 'product', 'id' => $product->id]), [
        'body' => 'Is this still available?',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('post_comments', [
        'user_id' => $student->id,
        'commentable_type' => Product::class,
        'commentable_id' => $product->id,
        'body' => 'Is this still available?',
    ]);
});

it('allows a student to privately message a lost and found author', function () {
    $author = User::factory()->create();
    $student = User::factory()->create();
    $post = LostFoundPost::create([
        'user_id' => $author->id,
        'type' => 'found',
        'item_name' => 'Blue notebook',
        'description' => 'Found near the library.',
        'status' => 'open',
    ]);

    $response = $this->actingAs($student)->post(route('interactions.messages.store', ['type' => 'lost-found', 'id' => $post->id]), [
        'body' => 'I think this is mine.',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('private_messages', [
        'sender_id' => $student->id,
        'recipient_id' => $author->id,
        'messageable_type' => LostFoundPost::class,
        'messageable_id' => $post->id,
        'body' => 'I think this is mine.',
    ]);
});

it('does not allow an author to message themselves', function () {
    $author = User::factory()->create();
    $product = Product::create([
        'user_id' => $author->id,
        'title' => 'Book',
        'description' => 'Textbook',
        'price' => 100,
        'category' => 'Books',
        'condition' => 'Good',
        'status' => 'available',
    ]);

    $this->actingAs($author)
        ->post(route('interactions.messages.store', ['type' => 'product', 'id' => $product->id]), [
            'body' => 'Self message',
        ])
        ->assertStatus(422);

    $this->assertDatabaseCount('private_messages', 0);
});

it('allows the post author to reply to a comment', function () {
    $author = User::factory()->create();
    $student = User::factory()->create();
    $product = Product::create([
        'user_id' => $author->id,
        'title' => 'Notebook',
        'description' => 'A notebook',
        'price' => 50,
        'category' => 'School Supplies',
        'condition' => 'New',
        'status' => 'available',
    ]);
    $comment = $product->comments()->create(['user_id' => $student->id, 'body' => 'Where can we meet?']);

    $this->actingAs($author)
        ->post(route('interactions.comments.store', ['type' => 'product', 'id' => $product->id]), [
            'parent_id' => $comment->id,
            'body' => 'At the main gate after class.',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('post_comments', [
        'parent_id' => $comment->id,
        'user_id' => $author->id,
        'body' => 'At the main gate after class.',
    ]);
});

it('allows either participant to reply to a private message', function () {
    $author = User::factory()->create();
    $student = User::factory()->create();
    $product = Product::create([
        'user_id' => $author->id,
        'title' => 'Used book',
        'description' => 'A used book',
        'price' => 80,
        'category' => 'Books',
        'condition' => 'Good',
        'status' => 'available',
    ]);
    $message = $product->privateMessages()->create([
        'sender_id' => $student->id,
        'recipient_id' => $author->id,
        'body' => 'Can I pick this up tomorrow?',
    ]);

    $this->actingAs($author)
        ->post(route('messages.reply', $message), ['body' => 'Yes, that works.'])
        ->assertRedirect();

    $this->assertDatabaseHas('private_messages', [
        'sender_id' => $author->id,
        'recipient_id' => $student->id,
        'messageable_type' => Product::class,
        'messageable_id' => $product->id,
        'body' => 'Yes, that works.',
    ]);
});

it('allows a post owner to delete a comment on their post', function () {
    $author = User::factory()->create();
    $student = User::factory()->create();
    $product = Product::create([
        'user_id' => $author->id,
        'title' => 'Pen',
        'description' => 'Blue pen',
        'price' => 10,
        'category' => 'School Supplies',
        'condition' => 'Good',
        'status' => 'available',
    ]);
    $comment = $product->comments()->create(['user_id' => $student->id, 'body' => 'Comment to remove']);

    $this->actingAs($author)
        ->delete(route('interactions.comments.destroy', $comment))
        ->assertRedirect();

    $this->assertDatabaseMissing('post_comments', ['id' => $comment->id]);
});

it('allows a participant to delete a private message', function () {
    $author = User::factory()->create();
    $student = User::factory()->create();
    $product = Product::create([
        'user_id' => $author->id,
        'title' => 'Bag',
        'description' => 'Backpack',
        'price' => 300,
        'category' => 'Others',
        'condition' => 'Good',
        'status' => 'available',
    ]);
    $message = $product->privateMessages()->create([
        'sender_id' => $student->id,
        'recipient_id' => $author->id,
        'body' => 'Please delete me.',
    ]);

    $this->actingAs($author)
        ->delete(route('messages.destroy', $message))
        ->assertRedirect();

    $this->assertDatabaseMissing('private_messages', ['id' => $message->id]);
});
