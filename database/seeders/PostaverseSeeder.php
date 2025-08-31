<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Group;
use App\Models\Like;
use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostaverseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->admin()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@postaverse.com',
            'bio' => 'Platform administrator managing Postaverse community. Welcome to our amazing social platform! 🚀'
        ]);

        // Create test users
        $testUser = User::factory()->withCompleteProfile()->create([
            'name' => 'Demo User',
            'username' => 'demo',
            'email' => 'demo@postaverse.com',
            'bio' => 'Demo account for exploring Postaverse features. Feel free to connect and interact! ✨'
        ]);

        // Create regular users
        $users = User::factory()->count(20)->create();
        $allUsers = collect([$admin, $testUser])->merge($users);

        // Create groups
        $groups = Group::factory()->count(10)->create([
            'creator_id' => fn() => $allUsers->random()->id
        ]);

        // Add members to groups
        foreach ($groups as $group) {
            $memberCount = random_int(5, min(25, $allUsers->count()));
            $members = $allUsers->random($memberCount);
            
            foreach ($members as $member) {
                if (!$group->members()->where('user_id', $member->id)->exists()) {
                    $group->members()->attach($member->id, [
                        'role' => $member->id === $group->creator_id ? 'admin' : 'member',
                        'status' => 'approved',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            
            $group->update(['members_count' => $group->members()->count()]);
        }

        // Create follows relationships
        foreach ($allUsers as $user) {
            $followingCount = random_int(3, min(15, $allUsers->count() - 1));
            $toFollow = $allUsers->except([$user->id])->random($followingCount);
            
            foreach ($toFollow as $userToFollow) {
                if (!$user->following()->where('following_id', $userToFollow->id)->exists()) {
                    $user->following()->attach($userToFollow->id, [
                        'status' => 'approved',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Create posts
        $posts = Post::factory()->count(50)->create([
            'user_id' => fn() => $allUsers->random()->id
        ]);

        // Create some popular posts
        Post::factory()->count(10)->popular()->create([
            'user_id' => fn() => $allUsers->random()->id
        ]);

        // Create comments
        foreach ($posts as $post) {
            $commentCount = random_int(0, 8);
            $comments = Comment::factory()->count($commentCount)->create([
                'post_id' => $post->id,
                'user_id' => fn() => $allUsers->random()->id
            ]);

            // Create some replies
            foreach ($comments->random(min($commentCount, 3)) as $comment) {
                Comment::factory()->count(random_int(1, 3))->create([
                    'post_id' => $post->id,
                    'parent_id' => $comment->id,
                    'user_id' => fn() => $allUsers->random()->id
                ]);
            }

            $post->update(['comments_count' => $post->comments()->count()]);
        }

        // Create likes for posts
        foreach ($posts as $post) {
            $likeCount = random_int(0, min(50, $allUsers->count()));
            $likingUsers = $allUsers->random($likeCount);
            
            foreach ($likingUsers as $user) {
                Like::create([
                    'user_id' => $user->id,
                    'likeable_type' => Post::class,
                    'likeable_id' => $post->id
                ]);
            }
            
            $post->update(['likes_count' => $post->likes()->count()]);
        }

        // Create some messages
        foreach ($allUsers->take(15) as $user) {
            $messageCount = random_int(5, 20);
            $recipients = $allUsers->except([$user->id])->random(min($messageCount, 5));
            
            foreach ($recipients as $recipient) {
                // Create conversation with 2-8 messages
                $conversationLength = random_int(2, 8);
                
                for ($i = 0; $i < $conversationLength; $i++) {
                    $sender = $i % 2 === 0 ? $user : $recipient;
                    $receiver = $i % 2 === 0 ? $recipient : $user;
                    
                    Message::factory()->create([
                        'sender_id' => $sender->id,
                        'recipient_id' => $receiver->id,
                        'created_at' => now()->subDays(random_int(0, 30))->subMinutes(random_int(0, 1440))
                    ]);
                }
            }
        }

        // Update user last_active_at
        foreach ($allUsers as $user) {
            $user->update([
                'last_active_at' => fake()->dateTimeBetween('-7 days', 'now')
            ]);
        }

        $this->command->info('Postaverse platform seeded successfully!');
        $this->command->info('Admin credentials: admin@postaverse.com / password');
        $this->command->info('Demo credentials: demo@postaverse.com / password');
    }
}